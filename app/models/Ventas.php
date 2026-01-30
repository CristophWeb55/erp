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
            $subtotal = $data['cantidad'] * $data['precio_unitario'];
            $iva = $subtotal * 0.16;
            $total = $subtotal + $iva;

            $sql = "INSERT INTO cotizaciones (cliente_id, fecha_emision, subtotal, iva, total) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['cliente_id'],
                $data['fecha_emision'],
                $subtotal,
                $iva,
                $total
            ]);
            $cotizacionId = $this->db->lastInsertId();

            $sqlDet = "INSERT INTO cotizacion_detalle (cotizacion_id, producto_id, cantidad, precio_unitario, subtotal) 
                       VALUES (?, ?, ?, ?, ?)";
            $stmtDet = $this->db->prepare($sqlDet);
            $stmtDet->execute([
                $cotizacionId,
                $data['producto_id'],
                $data['cantidad'],
                $data['precio_unitario'],
                $subtotal
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function approve($id)
    {
        $stmt = $this->db->prepare("UPDATE cotizaciones SET estatus = 'Aprobada' WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
