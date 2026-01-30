<?php

class Compras
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT c.*, t.nombre_razon_social FROM compras c 
                                 JOIN terceros t ON c.proveedor_id = t.id 
                                 ORDER BY c.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT c.*, t.nombre_razon_social FROM compras c 
                                   JOIN terceros t ON c.proveedor_id = t.id 
                                   WHERE c.id = ?");
        $stmt->execute([$id]);
        $compra = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get product details for this purchase (simplification for MVP: 1 product per purchase)
        $stmt = $this->db->prepare("SELECT p.* FROM productos p 
                                   JOIN inventario_lotes il ON il.producto_id = p.id 
                                   WHERE il.compra_id = ?");
        // Note: For MVP, we'll just link the purchase to a product in the creation
        return $compra;
    }

    public function create($data)
    {
        $this->db->beginTransaction();
        try {
            // 1. Create Purchase
            $sql = "INSERT INTO compras (proveedor_id, fecha_compra, referencia, total) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$data['proveedor_id'], $data['fecha_compra'], $data['referencia'], $data['total']]);
            $compraId = $this->db->lastInsertId();

            // 2. We don't create the inventory lot yet, only the reference if needed
            // For MVP simplicity, we store the product intent in a temporary way or just wait for receiving

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function receiveStock($data)
    {
        $this->db->beginTransaction();
        try {
            // 1. Update purchase status
            $stmt = $this->db->prepare("UPDATE compras SET estatus = 'Recibida' WHERE id = ?");
            $stmt->execute([$data['compra_id']]);

            // 2. Create Inventory Lot (The Pedimento entry)
            $sql = "INSERT INTO inventario_lotes (producto_id, compra_id, cantidad_inicial, cantidad_actual, numero_pedimento, fecha_pedimento, nombre_aduana) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['producto_id'],
                $data['compra_id'],
                $data['cantidad'],
                $data['cantidad'],
                $data['numero_pedimento'],
                $data['fecha_pedimento'],
                $data['nombre_aduana']
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
