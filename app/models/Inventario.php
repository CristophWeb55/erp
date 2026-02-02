<?php

class Inventario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene el stock general de todos los productos
     */
    public function getStockGeneral()
    {
        $stmt = $this->db->query("
            SELECT 
                p.id,
                p.sku,
                p.descripcion,
                p.stock_minimo,
                p.imagen_url,
                p.precio_venta,
                COALESCE(SUM(il.cantidad_actual), 0) as stock_actual,
                COUNT(il.id) as total_lotes
            FROM productos p
            LEFT JOIN inventario_lotes il ON p.id = il.producto_id
            GROUP BY p.id
            ORDER BY stock_actual ASC, p.sku ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene el detalle de lotes y pedimentos de un producto
     */
    public function getKardex($productoId)
    {
        $stmt = $this->db->prepare("
            SELECT 
                il.*,
                c.referencia as ref_compra,
                t.nombre_razon_social as proveedor
            FROM inventario_lotes il
            LEFT JOIN compras c ON il.compra_id = c.id
            LEFT JOIN terceros t ON c.proveedor_id = t.id
            WHERE il.producto_id = ?
            ORDER BY il.created_at DESC
        ");
        $stmt->execute([$productoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Estadísticas rápidas para el dashboard de inventario
     */
    public function getStats()
    {
        $stats = [
            'total_productos' => 0,
            'valor_inventario' => 0,
            'productos_bajo_stock' => 0,
            'productos_sin_stock' => 0
        ];

        $stock = $this->getStockGeneral();
        foreach ($stock as $item) {
            $stats['total_productos']++;
            $stats['valor_inventario'] += ($item['stock_actual'] * $item['precio_venta']);

            if ($item['stock_actual'] <= 0) {
                $stats['productos_sin_stock']++;
            } elseif ($item['stock_actual'] < $item['stock_minimo']) {
                $stats['productos_bajo_stock']++;
            }
        }

        return $stats;
    }

    /**
     * Realiza un ajuste manual de inventario
     */
    public function adjustStock($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual, numero_pedimento, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");

        // La cantidad puede ser negativa para salidas/mermas
        return $stmt->execute([
            $data['producto_id'],
            $data['cantidad'],
            $data['cantidad'],
            $data['pedimento'] ?? 'AJUSTE'
        ]);
    }
}
