<?php

class Pedidos
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT 
                p.*, 
                t.nombre_razon_social as cliente_nombre,
                u.nombre as vendedor_nombre,
                c.moneda,
                (SELECT COUNT(*) FROM pedido_detalle pd WHERE pd.pedido_id = p.id) as total_items
            FROM pedidos p
            LEFT JOIN terceros t ON p.cliente_id = t.id
            LEFT JOIN usuarios u ON p.vendedor_id = u.id
            LEFT JOIN cotizaciones c ON p.cotizacion_id = c.id
            ORDER BY p.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        // Obtener cabecera
        $stmt = $this->db->prepare("
            SELECT 
                p.*, 
                t.nombre_razon_social as cliente_nombre,
                t.rfc as cliente_rfc,
                t.direccion as cliente_direccion,
                t.email as cliente_email,
                u.nombre as vendedor_nombre,
                cot.moneda
            FROM pedidos p
            LEFT JOIN terceros t ON p.cliente_id = t.id
            LEFT JOIN usuarios u ON p.vendedor_id = u.id
            LEFT JOIN cotizaciones cot ON p.cotizacion_id = cot.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pedido)
            return null;

        // Obtener detalle
        $stmtDetalle = $this->db->prepare("
            SELECT 
                pd.*, 
                prod.sku, 
                prod.descripcion,
                prod.imagen_url
            FROM pedido_detalle pd
            JOIN productos prod ON pd.producto_id = prod.id
            WHERE pd.pedido_id = ?
        ");
        $stmtDetalle->execute([$id]);
        $pedido['items'] = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

        return $pedido;
    }

    public function createFromQuote($quoteId)
    {
        try {
            $this->db->beginTransaction();

            // 1. Obtener datos de la cotización
            $stmtQuote = $this->db->prepare("SELECT * FROM cotizaciones WHERE id = ?");
            $stmtQuote->execute([$quoteId]);
            $quote = $stmtQuote->fetch(PDO::FETCH_ASSOC);

            if (!$quote)
                throw new Exception("Cotización no encontrada");

            // 2. Crear Pedido
            $folio = 'PED-' . date('Ymd') . '-' . rand(100, 999); // Generar folio único

            $stmtInsert = $this->db->prepare("
                INSERT INTO pedidos 
                (cotizacion_id, folio, cliente_id, vendedor_id, fecha_pedido, fecha_entrega_estimada, subtotal, iva, total, estatus)
                VALUES (?, ?, ?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 5 DAY), ?, ?, ?, 'Pendiente')
            ");

            $stmtInsert->execute([
                $quote['id'],
                $folio,
                $quote['cliente_id'],
                $quote['vendedor_id'],
                $quote['subtotal'],
                $quote['iva'],
                $quote['total']
            ]);

            $pedidoId = $this->db->lastInsertId();

            // 3. Copiar detalles
            $stmtDetails = $this->db->prepare("SELECT * FROM cotizacion_detalle WHERE cotizacion_id = ?");
            $stmtDetails->execute([$quoteId]);
            $items = $stmtDetails->fetchAll(PDO::FETCH_ASSOC);

            $stmtInsertMeta = $this->db->prepare("
                INSERT INTO pedido_detalle (pedido_id, producto_id, cantidad, precio_unitario, subtotal)
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($items as $item) {
                // Calcular subtotal real para el pedido (quantity * price)
                // Usamos el precio final unitario (considerando descuento unitario si aplica en el modelo)
                $stmtInsertMeta->execute([
                    $pedidoId,
                    $item['producto_id'],
                    $item['cantidad'],
                    $item['precio_unitario'],
                    $item['subtotal']
                ]);
            }

            // 4. Actualizar estatus de Cotización
            $stmtUpdateQuote = $this->db->prepare("UPDATE cotizaciones SET estatus = 'Convertida' WHERE id = ?");
            $stmtUpdateQuote->execute([$quoteId]);

            $this->db->commit();
            return $pedidoId;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function fulfillOrder($id)
    {
        try {
            $this->db->beginTransaction();

            $pedido = $this->getById($id);
            if (!$pedido)
                throw new Exception("Pedido no encontrado.");

            if ($pedido['estatus'] !== 'Pendiente' && $pedido['estatus'] !== 'En Proceso') {
                throw new Exception("El pedido ya ha sido surtido o cancelado.");
            }

            foreach ($pedido['items'] as $item) {
                $productId = $item['producto_id'];
                $qtyNeeded = $item['cantidad'];

                // Verificar stock total disponible
                $stmtStock = $this->db->prepare("SELECT SUM(cantidad_actual) as total FROM inventario_lotes WHERE producto_id = ?");
                $stmtStock->execute([$productId]);
                $stockMeta = $stmtStock->fetch(PDO::FETCH_ASSOC);
                $totalAvailable = $stockMeta['total'] ?? 0;

                if ($totalAvailable < $qtyNeeded) {
                    throw new Exception("Stock insuficiente para: " . $item['sku'] . " (Solicitado: $qtyNeeded, Disponible: $totalAvailable)");
                }

                // Descontar usando FIFO
                $stmtLots = $this->db->prepare("
                    SELECT id, cantidad_actual 
                    FROM inventario_lotes 
                    WHERE producto_id = ? AND cantidad_actual > 0 
                    ORDER BY created_at ASC
                ");
                $stmtLots->execute([$productId]);
                $lots = $stmtLots->fetchAll(PDO::FETCH_ASSOC);

                $remainingToDeduct = $qtyNeeded;

                foreach ($lots as $lot) {
                    if ($remainingToDeduct <= 0)
                        break;

                    $deduct = min($lot['cantidad_actual'], $remainingToDeduct);

                    // Actualizar lote
                    $stmtUpdateLot = $this->db->prepare("UPDATE inventario_lotes SET cantidad_actual = cantidad_actual - ? WHERE id = ?");
                    $stmtUpdateLot->execute([$deduct, $lot['id']]);

                    $remainingToDeduct -= $deduct;
                }
            }

            // Actualizar estatus del pedido
            $stmtUpdate = $this->db->prepare("UPDATE pedidos SET estatus = 'Surtido' WHERE id = ?");
            $stmtUpdate->execute([$id]);

            $this->db->commit();
            return ['success' => true];

        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
