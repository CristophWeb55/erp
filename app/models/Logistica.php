<?php

class Logistica
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene todas las entregas
     */
    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT e.*, p.folio as folio_pedido, t.nombre_razon_social as cliente
            FROM entregas e
            JOIN pedidos p ON e.pedido_id = p.id
            JOIN terceros t ON p.cliente_id = t.id
            ORDER BY e.fecha_creacion DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una entrega por ID con su detalle
     */
    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT e.*, p.folio as folio_pedido, p.cliente_id, t.nombre_razon_social as cliente, t.direccion
            FROM entregas e
            JOIN pedidos p ON e.pedido_id = p.id
            JOIN terceros t ON p.cliente_id = t.id
            WHERE e.id = ?
        ");
        $stmt->execute([$id]);
        $entrega = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($entrega) {
            $stmtDet = $this->db->prepare("
                SELECT ed.*, prod.sku, prod.descripcion, prod.imagen_url
                FROM entrega_detalle ed
                JOIN productos prod ON ed.producto_id = prod.id
                WHERE ed.entrega_id = ?
            ");
            $stmtDet->execute([$id]);
            $entrega['items'] = $stmtDet->fetchAll(PDO::FETCH_ASSOC);
        }

        return $entrega;
    }

    /**
     * Crea una nueva entrega desde un pedido
     */
    public function createFromPedido($pedidoId)
    {
        $this->db->beginTransaction();
        try {
            // 1. Obtener datos del pedido
            $stmtPed = $this->db->prepare("SELECT * FROM pedidos WHERE id = ?");
            $stmtPed->execute([$pedidoId]);
            $pedido = $stmtPed->fetch(PDO::FETCH_ASSOC);

            if (!$pedido)
                throw new Exception("Pedido no encontrado");

            // 2. Generar folio de entrega
            $folio = 'ENT-' . date('Ymd') . '-' . rand(100, 999);

            // 3. Insertar encabezado de entrega
            $stmtInsert = $this->db->prepare("
                INSERT INTO entregas (folio, pedido_id, fecha_entrega_estimada, estatus)
                VALUES (?, ?, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 'Programado')
            ");
            $stmtInsert->execute([$folio, $pedidoId]);
            $entregaId = $this->db->lastInsertId();

            // 4. Copiar detalles del pedido a la entrega
            $stmtItems = $this->db->prepare("SELECT * FROM pedido_detalle WHERE pedido_id = ?");
            $stmtItems->execute([$pedidoId]);
            $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

            $stmtInsDet = $this->db->prepare("
                INSERT INTO entrega_detalle (entrega_id, producto_id, cantidad_a_entregar)
                VALUES (?, ?, ?)
            ");

            foreach ($items as $item) {
                $stmtInsDet->execute([
                    $entregaId,
                    $item['producto_id'],
                    $item['cantidad']
                ]);
            }

            // 5. Opcionalmente actualizar estatus del pedido (por ejemplo a 'Enviando')
            // $this->db->prepare("UPDATE pedidos SET estatus = 'Enviando' WHERE id = ?")->execute([$pedidoId]);

            $this->db->commit();
            return $entregaId;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Confirma la entrega y guarda la firma
     */
    public function confirmDelivery($id, $firmaBase64, $notas = '')
    {
        $stmt = $this->db->prepare("
            UPDATE entregas 
            SET estatus = 'Entregado', 
                fecha_entrega_real = NOW(), 
                evidencia_firma = ?, 
                notas_entrega = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$firmaBase64, $notas, $id]);
    }
}
