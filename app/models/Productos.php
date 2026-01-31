<?php

class Productos
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        // Obtener productos con stock actual calculado desde inventario_lotes
        $stmt = $this->db->query("
            SELECT 
                p.*,
                COALESCE(SUM(il.cantidad_actual), 0) as stock_actual
            FROM productos p
            LEFT JOIN inventario_lotes il ON p.id = il.producto_id
            GROUP BY p.id
            ORDER BY p.sku ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT 
                p.*,
                COALESCE(SUM(il.cantidad_actual), 0) as stock_actual
            FROM productos p
            LEFT JOIN inventario_lotes il ON p.id = il.producto_id
            WHERE p.id = ?
            GROUP BY p.id
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO productos (sku, descripcion, precio_venta, stock_minimo, imagen_url, requiere_pedimento) 
                VALUES (:sku, :descripcion, :precio_venta, :stock_minimo, :imagen_url, :requiere_pedimento)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':sku' => $data['sku'],
            ':descripcion' => $data['descripcion'],
            ':precio_venta' => $data['precio_venta'],
            ':stock_minimo' => $data['stock_minimo'] ?? 10,
            ':imagen_url' => $data['imagen_url'] ?? null,
            ':requiere_pedimento' => $data['requiere_pedimento']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE productos 
                SET sku = :sku, 
                    descripcion = :descripcion, 
                    precio_venta = :precio_venta,
                    stock_minimo = :stock_minimo,
                    imagen_url = :imagen_url,
                    requiere_pedimento = :requiere_pedimento
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':sku' => $data['sku'],
            ':descripcion' => $data['descripcion'],
            ':precio_venta' => $data['precio_venta'],
            ':stock_minimo' => $data['stock_minimo'] ?? 10,
            ':imagen_url' => $data['imagen_url'] ?? null,
            ':requiere_pedimento' => $data['requiere_pedimento']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function search($query)
    {
        $stmt = $this->db->prepare("
            SELECT 
                p.*,
                COALESCE(SUM(il.cantidad_actual), 0) as stock_actual
            FROM productos p
            LEFT JOIN inventario_lotes il ON p.id = il.producto_id
            WHERE p.sku LIKE :query OR p.descripcion LIKE :query
            GROUP BY p.id
            ORDER BY p.sku ASC
        ");
        $searchTerm = "%{$query}%";
        $stmt->execute([':query' => $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

