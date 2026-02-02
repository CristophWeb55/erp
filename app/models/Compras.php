<?php

class Compras
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Obtener todas las compras
    public function getAll()
    {
        $sql = "SELECT c.*, t.nombre_razon_social as proveedor 
                FROM compras c 
                JOIN terceros t ON c.proveedor_id = t.id 
                ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una compra por ID con sus detalles
    public function getById($id)
    {
        $sql = "SELECT c.*, t.nombre_razon_social as proveedor, t.rfc, t.direccion 
                FROM compras c 
                JOIN terceros t ON c.proveedor_id = t.id 
                WHERE c.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $compra = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($compra) {
            $sqlDetails = "SELECT cd.*, p.sku, p.descripcion 
                           FROM compra_detalles cd 
                           JOIN productos p ON cd.producto_id = p.id 
                           WHERE cd.compra_id = :id";
            $stmtDetails = $this->db->prepare($sqlDetails);
            $stmtDetails->execute([':id' => $id]);
            $compra['items'] = $stmtDetails->fetchAll(PDO::FETCH_ASSOC);
        }

        return $compra;
    }

    // Crear una nueva compra
    public function create($data, $items)
    {
        try {
            $this->db->beginTransaction();

            // Insertar compra
            $sql = "INSERT INTO compras (proveedor_id, fecha_compra, referencia, observaciones, total, estatus) 
                    VALUES (:proveedor_id, :fecha_compra, :referencia, :observaciones, :total, 'Pendiente')";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':proveedor_id' => $data['proveedor_id'],
                ':fecha_compra' => $data['fecha_compra'],
                ':referencia' => $data['referencia'],
                ':observaciones' => $data['observaciones'],
                ':total' => $data['total']
            ]);

            $compraId = $this->db->lastInsertId();

            // Insertar detalles
            $sqlDetail = "INSERT INTO compra_detalles (compra_id, producto_id, cantidad, costo_unitario, subtotal) 
                          VALUES (:compra_id, :producto_id, :cantidad, :costo_unitario, :subtotal)";
            $stmtDetail = $this->db->prepare($sqlDetail);

            foreach ($items as $item) {
                $stmtDetail->execute([
                    ':compra_id' => $compraId,
                    ':producto_id' => $item['producto_id'],
                    ':cantidad' => $item['cantidad'],
                    ':costo_unitario' => $item['costo_unitario'],
                    ':subtotal' => $item['subtotal']
                ]);
            }

            $this->db->commit();
            return $compraId;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Recibir mercancía (Actualizar Inventario)
    public function receiveOrder($id)
    {
        try {
            $this->db->beginTransaction();

            // 1. Obtener detalles de la compra
            $compra = $this->getById($id);
            if (!$compra || $compra['estatus'] == 'Recibida') {
                throw new Exception("Compra no válida o ya recibida.");
            }

            // 2. Crear registros en inventario_lotes
            $sqlLote = "INSERT INTO inventario_lotes (producto_id, compra_id, cantidad_inicial, cantidad_actual, 
                        fecha_pedimento, created_at) 
                        VALUES (:producto_id, :compra_id, :cantidad, :cantidad, CURDATE(), NOW())";
            $stmtLote = $this->db->prepare($sqlLote);

            // 3. Actualizar costo promedio en productos (Opcional, pero recomendado)
            // Por simplicidad, solo agregamos al inventario
            foreach ($compra['items'] as $item) {
                $stmtLote->execute([
                    ':producto_id' => $item['producto_id'],
                    ':compra_id' => $id,
                    ':cantidad' => $item['cantidad']
                ]);
            }

            // 4. Actualizar estatus de la compra
            $sqlUpdate = "UPDATE compras SET estatus = 'Recibida' WHERE id = :id";
            $this->db->prepare($sqlUpdate)->execute([':id' => $id]);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
