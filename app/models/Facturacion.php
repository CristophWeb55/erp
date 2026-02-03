<?php

class Facturacion
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $sql = "SELECT f.*, t.nombre_razon_social as cliente, t.rfc 
                FROM facturas f 
                JOIN terceros t ON f.cliente_id = t.id 
                ORDER BY f.fecha_emision DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        // Headers
        $stmt = $this->db->prepare("
            SELECT f.*, 
                   t.nombre_razon_social as cliente_nombre,
                   t.rfc as cliente_rfc,
                   t.direccion as cliente_direccion,
                   t.email as cliente_email,
                   t.telefono as cliente_telefono,
                   p.folio as pedido_folio
            FROM facturas f 
            JOIN terceros t ON f.cliente_id = t.id 
            LEFT JOIN pedidos p ON f.pedido_id = p.id
            WHERE f.id = ?
        ");
        $stmt->execute([$id]);
        $factura = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($factura) {
            // Items
            $stmtDet = $this->db->prepare("
                SELECT fd.*, p.sku, p.descripcion 
                FROM factura_detalle fd 
                JOIN productos p ON fd.producto_id = p.id 
                WHERE fd.factura_id = ?
            ");
            $stmtDet->execute([$id]);
            $factura['items'] = $stmtDet->fetchAll(PDO::FETCH_ASSOC);
        }

        return $factura;
    }

    public function getByPedidoId($pedidoId)
    {
        $stmt = $this->db->prepare("SELECT * FROM facturas WHERE pedido_id = ? LIMIT 1");
        $stmt->execute([$pedidoId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createFromOrder($pedidoId)
    {
        try {
            $this->db->beginTransaction();

            // 1. Get Order Data
            $stmtPed = $this->db->prepare("SELECT * FROM pedidos WHERE id = ?");
            $stmtPed->execute([$pedidoId]);
            $pedido = $stmtPed->fetch(PDO::FETCH_ASSOC);

            if (!$pedido)
                throw new Exception("Pedido no encontrado");
            if ($pedido['estatus'] == 'Facturado')
                throw new Exception("Este pedido ya fue facturado");

            // 2. Generate Fake Fiscal Data
            $uuid = $this->generateUUID();
            $selloSat = base64_encode(random_bytes(128));
            $selloCfdi = base64_encode(random_bytes(128));
            $cadenaOriginal = "||1.1|" . $uuid . "|2025-01-07T20:18:30|MAS0810247C0|" . substr($selloCfdi, 0, 50) . "|00001000000709182898||";

            // 3. Create Invoice Header (Se marca como Pagada y saldo 0 por petición del usuario)
            $sql = "INSERT INTO facturas 
                    (cotizacion_id, pedido_id, cliente_id, folio_fiscal_uuid, fecha_emision, total, saldo_pendiente, estatus) 
                    VALUES (?, ?, ?, ?, NOW(), ?, 0, 'Pagada')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $pedido['cotizacion_id'],
                $pedidoId,
                $pedido['cliente_id'],
                $uuid,
                $pedido['total']
            ]);
            $facturaId = $this->db->lastInsertId();

            // 4. Copy Details
            $stmtItems = $this->db->prepare("SELECT * FROM pedido_detalle WHERE pedido_id = ?");
            $stmtItems->execute([$pedidoId]);
            $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

            if (empty($items)) {
                throw new Exception("El pedido no tiene productos listados para facturar.");
            }

            $sqlDet = "INSERT INTO factura_detalle (factura_id, producto_id, cantidad, precio_unitario, lote_origen_id) 
                       VALUES (?, ?, ?, ?, NULL)";
            $stmtDet = $this->db->prepare($sqlDet);

            foreach ($items as $item) {
                $stmtDet->execute([
                    $facturaId,
                    $item['producto_id'],
                    $item['cantidad'],
                    $item['precio_unitario']
                ]);
            }

            // 5. Update Order Status
            $stmtUpd = $this->db->prepare("UPDATE pedidos SET estatus = 'Facturado' WHERE id = ?");
            $stmtUpd->execute([$pedidoId]);

            $this->db->commit();
            return $facturaId;

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Error facturando pedido $pedidoId: " . $e->getMessage());
            throw $e;
        }
    }

    private function generateUUID()
    {
        return strtoupper(sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        ));
    }
}
