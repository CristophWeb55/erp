<?php

class Ventas
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT c.*, t.nombre_razon_social FROM cotizaciones c 
                                 JOIN terceros t ON c.cliente_id = t.id 
                                 ORDER BY c.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $this->db->beginTransaction();
        try {
            // 1. Generar Folio Automático si no viene uno
            $folio = $data['folio'] ?? 'COT-' . date('Ymd') . '-' . rand(100, 999);

            // 2. Calcular Totales desde el array de items
            $subtotal = 0;
            foreach ($data['items'] as $item) {
                $subtotal += ($item['cantidad'] * $item['precio_unitario']);
            }

            $descuentoTotal = ($subtotal * ($data['descuento_porcentaje'] ?? 0)) / 100;
            $subtotalConDesc = $subtotal - $descuentoTotal;
            $iva = $subtotalConDesc * 0.16;
            $total = $subtotalConDesc + $iva;

            // 3. Insertar Encabezado
            $sql = "INSERT INTO cotizaciones (folio, cliente_id, moneda, fecha_emision, fecha_vencimiento, subtotal, descuento_porcentaje, iva, total, estatus, version) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $folio,
                $data['cliente_id'],
                $data['moneda'] ?? 'MXN',
                $data['fecha_emision'] ?? date('Y-m-d'),
                $data['fecha_vencimiento'] ?? date('Y-m-d', strtotime('+15 days')),
                $subtotal,
                $data['descuento_porcentaje'] ?? 0,
                $iva,
                $total,
                'Borrador'
            ]);
            $cotizacionId = $this->db->lastInsertId();

            // 4. Insertar Detalle (Multi-item)
            $sqlDet = "INSERT INTO cotizacion_detalle (cotizacion_id, producto_id, cantidad, precio_unitario, subtotal) 
                       VALUES (?, ?, ?, ?, ?)";
            $stmtDet = $this->db->prepare($sqlDet);

            foreach ($data['items'] as $item) {
                $itemSubtotal = $item['cantidad'] * $item['precio_unitario'];
                $stmtDet->execute([
                    $cotizacionId,
                    $item['producto_id'],
                    $item['cantidad'],
                    $item['precio_unitario'],
                    $itemSubtotal
                ]);
            }

            $this->db->commit();
            return $cotizacionId;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }


    public function approve($id)
    {
        $stmt = $this->db->prepare("UPDATE cotizaciones SET estatus = 'Aprobada' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Convierte una cotización aprobada en un Pedido formal
     */
    public function convertToPedido($id)
    {
        $this->db->beginTransaction();
        try {
            // 1. Obtener datos de la cotización
            $stmt = $this->db->prepare("SELECT * FROM cotizaciones WHERE id = ?");
            $stmt->execute([$id]);
            $cot = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cot || $cot['estatus'] !== 'Aprobada') {
                throw new Exception("La cotización debe estar aprobada para convertirse.");
            }

            // 2. Insertar en Pedidos
            $folioPedido = str_replace('COT', 'PED', $cot['folio']);
            $sqlPed = "INSERT INTO pedidos (cotizacion_id, folio, cliente_id, fecha_pedido, subtotal, iva, total, estatus) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, 'Pendiente')";
            $stmtPed = $this->db->prepare($sqlPed);
            $stmtPed->execute([
                $id,
                $folioPedido,
                $cot['cliente_id'],
                date('Y-m-d'),
                $cot['subtotal'],
                $cot['iva'],
                $cot['total']
            ]);
            $pedidoId = $this->db->lastInsertId();

            // 3. Insertar Detalle de Pedido desde Detalle de Cotización
            $stmtItems = $this->db->prepare("SELECT * FROM cotizacion_detalle WHERE cotizacion_id = ?");
            $stmtItems->execute([$id]);
            $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

            $stmtPedDet = $this->db->prepare("INSERT INTO pedido_detalle (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
            foreach ($items as $item) {
                $stmtPedDet->execute([
                    $pedidoId,
                    $item['producto_id'],
                    $item['cantidad'],
                    $item['precio_unitario'],
                    $item['subtotal']
                ]);
            }

            // 4. Actualizar Estatus de Cotización
            $stmtUpd = $this->db->prepare("UPDATE cotizaciones SET estatus = 'Convertida' WHERE id = ?");
            $stmtUpd->execute([$id]);

            $this->db->commit();
            return $pedidoId;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Crea una nueva versión (copia) de una cotización existente
     */
    public function duplicateAsNewVersion($id)
    {
        $this->db->beginTransaction();
        try {
            // 1. Obtener datos originales
            $stmt = $this->db->prepare("SELECT * FROM cotizaciones WHERE id = ?");
            $stmt->execute([$id]);
            $original = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$original)
                throw new Exception("Cotización no encontrada");

            // 2. Insertar nueva versión
            $sql = "INSERT INTO cotizaciones (folio, cliente_id, moneda, fecha_emision, fecha_vencimiento, subtotal, descuento_porcentaje, iva, total, estatus, version) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Borrador', ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $original['folio'],
                $original['cliente_id'],
                $original['moneda'],
                date('Y-m-d'),
                date('Y-m-d', strtotime('+15 days')),
                $original['subtotal'],
                $original['descuento_porcentaje'],
                $original['iva'],
                $original['total'],
                ($original['version'] + 1)
            ]);
            $newId = $this->db->lastInsertId();

            // 3. Copiar Detalle
            $stmtItems = $this->db->prepare("SELECT * FROM cotizacion_detalle WHERE cotizacion_id = ?");
            $stmtItems->execute([$id]);
            $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

            $stmtInsDet = $this->db->prepare("INSERT INTO cotizacion_detalle (cotizacion_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
            foreach ($items as $item) {
                $stmtInsDet->execute([
                    $newId,
                    $item['producto_id'],
                    $item['cantidad'],
                    $item['precio_unitario'],
                    $item['subtotal']
                ]);
            }

            $this->db->commit();
            return $newId;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}


