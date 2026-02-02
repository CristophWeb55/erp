<?php

class Dashboard
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getKpis()
    {
        $stats = [];

        // 1. Cotizaciones del Mes
        $sql = "SELECT COUNT(*) as total, SUM(total) as monto FROM cotizaciones WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $row = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        $stats['cotizaciones_mes_count'] = $row['total'];
        $stats['cotizaciones_mes_monto'] = $row['monto'] ?? 0;

        // 2. Pedidos Pendientes
        $sql = "SELECT COUNT(*) as total FROM pedidos WHERE estatus = 'Pendiente'";
        $row = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        $stats['pedidos_pendientes'] = $row['total'];

        // 3. Compras por Recibir
        $sql = "SELECT COUNT(*) as total FROM compras WHERE estatus = 'Pendiente'";
        $row = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        $stats['compras_pendientes'] = $row['total'];

        // 4. Inventario Crítico
        // Check if columns exist first to avoid errors if migrates failed, but assuming schema matches recent updates
        try {
            $sql = "SELECT COUNT(*) as total FROM inventario_lotes"; // Approximation if we don't have stock_minimo logic perfect yet
            // Better: use products table
            $sql = "SELECT COUNT(*) as total FROM productos p 
                    LEFT JOIN (SELECT producto_id, SUM(cantidad_actual) as stock FROM inventario_lotes GROUP BY producto_id) i 
                    ON p.id = i.producto_id 
                    WHERE COALESCE(i.stock, 0) <= p.stock_minimo";
            $row = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
            $stats['productos_stock_bajo'] = $row['total'];
        } catch (Exception $e) {
            $stats['productos_stock_bajo'] = 0;
        }

        // 5. Entregas en Ruta
        $sql = "SELECT COUNT(*) as total FROM entregas WHERE estatus = 'En Tránsito'";
        $row = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        $stats['entregas_ruta'] = $row['total'];

        return $stats;
    }

    public function getRecentActivity()
    {
        // Union of recent Cotizaciones and Pedidos
        $sql = "
            (SELECT 'Cotización' as tipo, folio as referencia, cliente_id, total, estatus, created_at 
             FROM cotizaciones ORDER BY created_at DESC LIMIT 5)
            UNION
            (SELECT 'Pedido' as tipo, folio as referencia, cliente_id, total, estatus, created_at 
             FROM pedidos ORDER BY created_at DESC LIMIT 5)
            UNION
            (SELECT 'Compra' as tipo, referencia, proveedor_id as cliente_id, total, estatus, created_at 
             FROM compras ORDER BY created_at DESC LIMIT 5)
            ORDER BY created_at DESC LIMIT 10
        ";

        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Enrich with client names
        foreach ($results as &$row) {
            $stmtName = $this->db->prepare("SELECT nombre_razon_social FROM terceros WHERE id = ?");
            $stmtName->execute([$row['cliente_id']]);
            $client = $stmtName->fetch(PDO::FETCH_ASSOC);
            $row['tercero'] = $client['nombre_razon_social'] ?? 'Desconocido';
        }

        return $results;
    }
}
