<?php
// app/controllers/AIAssistantController.php

class AIAssistantController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function processQuery()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $query = $_POST['query'] ?? '';

        if (empty($query)) {
            echo json_encode(['success' => false, 'message' => 'Empty query']);
            return;
        }

        // Check for export intent before calling AI if possible, 
        // or let AI decide and provide the link. 
        // Let's let AI provide the link by updating the prompt.

        try {
            // 1. Gather Context (RAG - Retrieval Augmented Generation)
            // Ideally, we would vector search, but for MVP we fetch recent/relevant data based on basic logic
            $context = $this->gatherContext($query);

            // 2. Call Gemini API
            $response = $this->callGemini($query, $context);

            echo json_encode([
                'success' => true,
                'response' => $response
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'response' => "Error interno: " . $e->getMessage()
            ]);
        }
        exit;
    }

    private function gatherContext($userQuery)
    {
        $context = "";

        // Determine intent based on keywords (simple routing)
        $intent = $this->determineIntent($userQuery);

        switch ($intent) {
            case 'ventas':
                $stmt = $this->db->query("
                    SELECT p.folio, t.nombre_razon_social as cliente, p.total, p.estatus, p.fecha_pedido 
                    FROM pedidos p 
                    JOIN terceros t ON p.cliente_id = t.id 
                    ORDER BY p.fecha_pedido DESC LIMIT 10
                ");
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $context .= "Últimos pedidos:\n" . json_encode($data) . "\n\n";
                break;

            case 'productos':
                $stmt = $this->db->query("
                    SELECT sku, descripcion, precio_venta, stock_minimo 
                    FROM productos 
                    LIMIT 20
                ");
                // Note: We need a way to get actual stock. Currently schema lacks 'stock' column in products table directly, 
                // it seems it uses 'inventario_lotes'. Let's aggregate.

                $stmtStock = $this->db->query("
                    SELECT p.sku, p.descripcion, SUM(l.cantidad_actual) as stock_total 
                    FROM productos p 
                    LEFT JOIN inventario_lotes l ON p.id = l.producto_id 
                    GROUP BY p.id 
                    LIMIT 20
                ");
                $data = $stmtStock->fetchAll(PDO::FETCH_ASSOC);
                $context .= "Inventario de productos (Sku, Desc, Stock):\n" . json_encode($data) . "\n\n";
                break;

            case 'clientes':
                $stmt = $this->db->query("SELECT nombre_razon_social, email, tipo FROM terceros LIMIT 20");
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $context .= "Lista de Clientes/Proveedores:\n" . json_encode($data) . "\n\n";
                break;

            case 'finanzas':
                // Facturas recientes
                $stmt = $this->db->query("
                    SELECT f.folio_fiscal_uuid, t.nombre_razon_social, f.total, f.saldo_pendiente, f.estatus 
                    FROM facturas f
                    JOIN terceros t ON f.cliente_id = t.id
                    ORDER BY f.fecha_emision DESC LIMIT 10
                ");
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $context .= "Facturas recientes:\n" . json_encode($data) . "\n\n";
                break;

            default:
                // General context
                $context .= "El usuario pregunta algo general. Tienes acceso a módulos de Ventas, Productos, Clientes y Finanzas.";
                break;
        }

        return $context;
    }

    private function determineIntent($query)
    {
        $query = strtolower($query);
        if (strpos($query, 'pedido') !== false || strpos($query, 'venta') !== false || strpos($query, 'vendio') !== false)
            return 'ventas';
        if (strpos($query, 'producto') !== false || strpos($query, 'stock') !== false || strpos($query, 'inventario') !== false)
            return 'productos';
        if (strpos($query, 'cliente') !== false || strpos($query, 'proveedor') !== false)
            return 'clientes';
        if (strpos($query, 'factura') !== false || strpos($query, 'dinero') !== false || strpos($query, 'cobra') !== false || strpos($query, 'pago') !== false)
            return 'finanzas';
        return 'general';
    }

    private function callGemini($query, $context)
    {
        $apiKey = trim(TITAN_API_KEY);
        $model = trim(TITAN_MODEL);
        // Using v1beta for the latest models like 2.5
        $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";

        $prompt = "Eres un Asistente IA experto y amable para el ERP URICA. \n" .
            "Tu misión es ayudar al usuario a entender sus datos de negocio de forma clara y profesional. \n" .
            "1. Tono: Amigable, servicial y conciso (estilo Gemini). \n" .
            "2. Estructura: negritas, listas con puntos, tablas si es necesario para que la información sea fácil de leer. \n" .
            "3. Datos: Basa tu respuesta estrictamente en el CONTEXTO DB proporcionado. \n" .
            "4. Exportación de Inventario: Si el usuario pide un reporte, inventario o descargar productos, DEBES responder exactamente con este bloque HTML premium: \n" .
            "   <div class='report-card'> \n" .
            "     <p>¡Perfecto! He generado el reporte de inventario con los datos actuales.</p> \n" .
            "     <ul> \n" .
            "       <li>✅ Listado completo de productos (SKU)</li> \n" .
            "       <li>✅ Stock actual calculado de almacén</li> \n" .
            "       <li>✅ Precios de venta actualizados</li> \n" .
            "       <li>✅ Estatus de pedimentos</li> \n" .
            "     </ul> \n" .
            "     <a href='index.php?controller=AIAssistant&action=exportProducts' class='btn-download-excel'><i class='fa-solid fa-download'></i> Descargar Reporte de Inventario</a> \n" .
            "     <div class='footer-text'>El archivo se descargará automáticamente al hacer clic en el botón.</div> \n" .
            "   </div> \n" .
            "5. Honestidad: Si la información no está en el contexto, admítelo con amabilidad. \n\n" .
            "CONTEXTO DB: \n$context \n\n" .
            "PREGUNTA DEL USUARIO: $query \n\n" .
            "RESPUESTA (en Markdown amigable + bloque reporte HTML):";

        $data = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return "Error de conexión con IA: " . curl_error($ch);
        }

        curl_close($ch);

        $json = json_decode($response, true);

        if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
            return $json['candidates'][0]['content']['parts'][0]['text'];
        } else {
            // Manejo de errores de API (ej. quota, bloqueos)
            if (isset($json['error'])) {
                return "Error de IA: " . $json['error']['message'];
            }
            return "Lo siento, no pude procesar tu solicitud en este momento.";
        }
    }

    public function exportProducts()
    {
        require_once '../app/models/Productos.php';
        $productosModel = new Productos();
        $productos = $productosModel->getAll();

        $filename = "Reporte_Productos_" . date('Y-m-d_H-i-s') . ".xls";

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=$filename");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        // UTF-8 BOM for Excel to recognize characters correctly
        echo "\xEF\xBB\xBF";

        echo "<table border='1'>";
        echo "<tr>
                <th style='background-color: #293887; color: white;'>SKU</th>
                <th style='background-color: #293887; color: white;'>Descripción</th>
                <th style='background-color: #293887; color: white;'>Precio Venta</th>
                <th style='background-color: #293887; color: white;'>Stock Actual</th>
                <th style='background-color: #293887; color: white;'>Mínimo</th>
                <th style='background-color: #293887; color: white;'>Pedimento</th>
              </tr>";

        foreach ($productos as $p) {
            $pedimento = ($p['requiere_pedimento'] == 1) ? 'Sí' : 'No';
            echo "<tr>";
            echo "<td>" . htmlspecialchars($p['sku']) . "</td>";
            echo "<td>" . htmlspecialchars($p['descripcion']) . "</td>";
            echo "<td>" . number_format($p['precio_venta'], 2) . "</td>";
            echo "<td>" . (int) $p['stock_actual'] . "</td>";
            echo "<td>" . (int) $p['stock_minimo'] . "</td>";
            echo "<td>" . $pedimento . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        exit;
    }
}
