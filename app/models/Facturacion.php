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
        $stmt = $this->db->query("SELECT f.*, t.nombre_razon_social FROM facturas f 
                                 JOIN terceros t ON f.cliente_id = t.id 
                                 ORDER BY f.fecha_emision DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createFromQuote($cotizacion_id)
    {
        $this->db->beginTransaction();
        try {
            // 1. Get Quote Header
            $stmt = $this->db->prepare("SELECT * FROM cotizaciones WHERE id = ?");
            $stmt->execute([$cotizacion_id]);
            $quote = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Create Invoice Header
            $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
            $sqlF = "INSERT INTO facturas (cotizacion_id, cliente_id, folio_fiscal_uuid, total, saldo_pendiente) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmtF = $this->db->prepare($sqlF);
            $stmtF->execute([$cotizacion_id, $quote['cliente_id'], $uuid, $quote['total'], $quote['total']]);
            $facturaId = $this->db->lastInsertId();

            // 3. Get Quote Details
            $stmtD = $this->db->prepare("SELECT * FROM cotizacion_detalle WHERE cotizacion_id = ?");
            $stmtD->execute([$cotizacion_id]);
            $details = $stmtD->fetchAll(PDO::FETCH_ASSOC);

            foreach ($details as $d) {
                // Check if product requires pedimento
                $stmtP = $this->db->prepare("SELECT requiere_pedimento FROM productos WHERE id = ?");
                $stmtP->execute([$d['producto_id']]);
                $prod = $stmtP->fetch(PDO::FETCH_ASSOC);

                $loteId = null;
                if ($prod['requiere_pedimento']) {
                    // Pull Pedimento using PEPS (FIFO)
                    $stmtL = $this->db->prepare("SELECT id, cantidad_actual FROM inventario_lotes 
                                               WHERE producto_id = ? AND cantidad_actual >= ? 
                                               ORDER BY created_at ASC LIMIT 1");
                    $stmtL->execute([$d['producto_id'], $d['cantidad']]);
                    $lote = $stmtL->fetch(PDO::FETCH_ASSOC);

                    if (!$lote) {
                        throw new Exception("Sin existencias con pedimento para el producto " . $d['producto_id']);
                    }
                    $loteId = $lote['id'];

                    // Discount from lot
                    $stmtU = $this->db->prepare("UPDATE inventario_lotes SET cantidad_actual = cantidad_actual - ? WHERE id = ?");
                    $stmtU->execute([$d['cantidad'], $loteId]);
                }

                // Create Invoice Detail
                $sqlID = "INSERT INTO factura_detalle (factura_id, producto_id, cantidad, precio_unitario, lote_origen_id) 
                         VALUES (?, ?, ?, ?, ?)";
                $stmtID = $this->db->prepare($sqlID);
                $stmtID->execute([$facturaId, $d['producto_id'], $d['cantidad'], $d['precio_unitario'], $loteId]);
            }

            // Update quote status to say it was invoiced
            $stmtUQ = $this->db->prepare("UPDATE cotizaciones SET estatus = 'Aprobada' WHERE id = ?");
            $stmtUQ->execute([$cotizacion_id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getDetail($id)
    {
        $stmtH = $this->db->prepare("SELECT f.*, t.nombre_razon_social, t.rfc, t.direccion FROM facturas f 
                                    JOIN terceros t ON f.cliente_id = t.id WHERE f.id = ?");
        $stmtH->execute([$id]);
        $header = $stmtH->fetch(PDO::FETCH_ASSOC);

        $stmtD = $this->db->prepare("SELECT fd.*, p.sku, p.descripcion, l.numero_pedimento, l.fecha_pedimento, l.nombre_aduana 
                                    FROM factura_detalle fd 
                                    JOIN productos p ON fd.producto_id = p.id 
                                    LEFT JOIN inventario_lotes l ON fd.lote_origen_id = l.id 
                                    WHERE fd.factura_id = ?");
        $stmtD->execute([$id]);
        $details = $stmtD->fetchAll(PDO::FETCH_ASSOC);

        return ['header' => $header, 'details' => $details];
    }
}
