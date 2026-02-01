<?php

class Productos
{
    private $db;
    private $hasStockMinimo = null;
    private $hasImagenUrl = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->checkColumns();
    }

    /**
     * Verifica si las columnas stock_minimo e imagen_url existen
     */
    private function checkColumns()
    {
        try {
            $columns = $this->db->query("SHOW COLUMNS FROM productos")->fetchAll(PDO::FETCH_COLUMN);
            $this->hasStockMinimo = in_array('stock_minimo', $columns);
            $this->hasImagenUrl = in_array('imagen_url', $columns);
        } catch (Exception $e) {
            $this->hasStockMinimo = false;
            $this->hasImagenUrl = false;
        }
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
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agregar valores por defecto si las columnas no existen
        foreach ($productos as &$producto) {
            if (!$this->hasStockMinimo) {
                $producto['stock_minimo'] = 10;
            }
            if (!$this->hasImagenUrl) {
                $producto['imagen_url'] = null;
            }
        }

        return $productos;
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
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        // Agregar valores por defecto si las columnas no existen
        if ($producto) {
            if (!$this->hasStockMinimo) {
                $producto['stock_minimo'] = 10;
            }
            if (!$this->hasImagenUrl) {
                $producto['imagen_url'] = null;
            }
        }

        return $producto;
    }

    public function create($data)
    {
        // Construir SQL dinámicamente según columnas disponibles
        $fields = ['sku', 'descripcion', 'precio_venta', 'requiere_pedimento'];
        $placeholders = [':sku', ':descripcion', ':precio_venta', ':requiere_pedimento'];
        $values = [
            ':sku' => $data['sku'],
            ':descripcion' => $data['descripcion'],
            ':precio_venta' => $data['precio_venta'],
            ':requiere_pedimento' => $data['requiere_pedimento']
        ];

        if ($this->hasStockMinimo) {
            $fields[] = 'stock_minimo';
            $placeholders[] = ':stock_minimo';
            $values[':stock_minimo'] = $data['stock_minimo'] ?? 10;
        }

        if ($this->hasImagenUrl) {
            $fields[] = 'imagen_url';
            $placeholders[] = ':imagen_url';
            $values[':imagen_url'] = $data['imagen_url'] ?? null;
        }

        $sql = "INSERT INTO productos (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function update($id, $data)
    {
        // Construir SQL dinámicamente según columnas disponibles
        $sets = [
            'sku = :sku',
            'descripcion = :descripcion',
            'precio_venta = :precio_venta',
            'requiere_pedimento = :requiere_pedimento'
        ];

        $values = [
            ':id' => $id,
            ':sku' => $data['sku'],
            ':descripcion' => $data['descripcion'],
            ':precio_venta' => $data['precio_venta'],
            ':requiere_pedimento' => $data['requiere_pedimento']
        ];

        if ($this->hasStockMinimo) {
            $sets[] = 'stock_minimo = :stock_minimo';
            $values[':stock_minimo'] = $data['stock_minimo'] ?? 10;
        }

        if ($this->hasImagenUrl) {
            $sets[] = 'imagen_url = :imagen_url';
            $values[':imagen_url'] = $data['imagen_url'] ?? null;
        }

        $sql = "UPDATE productos SET " . implode(', ', $sets) . " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
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
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agregar valores por defecto si las columnas no existen
        foreach ($productos as &$producto) {
            if (!$this->hasStockMinimo) {
                $producto['stock_minimo'] = 10;
            }
            if (!$this->hasImagenUrl) {
                $producto['imagen_url'] = null;
            }
        }

        return $productos;
    }
}
