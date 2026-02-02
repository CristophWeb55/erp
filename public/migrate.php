<?php
/**
 * Script de migración general del sistema ERP
 * Ejecutar desde: http://localhost/ERP/public/migrate.php
 */

require_once '../config/database.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Sistema de Migraciones ERP - Cristoph</title>
    <link href='https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap' rel='stylesheet'>
    <style>
        :root {
            --primary: #293887;
            --primary-light: #4c5bb1;
            --secondary: #6c757d;
            --success: #10b981;
            --error: #ef4444;
            --info: #3b82f6;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text-main);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            max-width: 900px;
            width: 100%;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        h1 {
            color: var(--primary);
            font-weight: 700;
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
        }
        .module-section {
            margin-bottom: 30px;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 20px;
        }
        .module-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: var(--primary-light);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .status-msg {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .success { background: #ecfdf5; color: #065f46; border-left: 4px solid var(--success); }
        .error { background: #fef2f2; color: #991b1b; border-left: 4px solid var(--error); }
        .info { background: #eff6ff; color: #1e40af; border-left: 4px solid var(--info); }
        .warning { background: #fffbeb; color: #92400e; border-left: 4px solid #f59e0b; }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(41, 56, 135, 0.2);
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(41, 56, 135, 0.3);
        }
        code {
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Consolas', monospace;
            font-size: 0.9em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background: #f8fafc;
            text-align: left;
            padding: 12px;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🛠️ Panel de Control de Base de Datos</h1>";

try {
    $db = Database::getInstance();
    echo "<div class='status-msg info'>✓ Conexión establecida con la base de datos <code>erp_pedimentos</code></div>";

    // --- MÓDULO PRODUCTOS ---
    echo "<div class='module-section'>";
    echo "<div class='module-title'>📦 Módulo de Productos</div>";

    $checkStockMinimo = $db->query("SHOW COLUMNS FROM productos LIKE 'stock_minimo'")->fetch();
    $checkImagenUrl = $db->query("SHOW COLUMNS FROM productos LIKE 'imagen_url'")->fetch();

    if (!$checkStockMinimo) {
        $db->exec("ALTER TABLE productos ADD COLUMN stock_minimo INT DEFAULT 10 AFTER costo_promedio");
        echo "<div class='status-msg success'>✓ Campo <code>stock_minimo</code> agregado a tabla productos.</div>";
    } else {
        echo "<div class='status-msg warning'>⚠ Campo <code>stock_minimo</code> ya existe en productos.</div>";
    }

    if (!$checkImagenUrl) {
        $db->exec("ALTER TABLE productos ADD COLUMN imagen_url VARCHAR(255) DEFAULT NULL AFTER stock_minimo");
        echo "<div class='status-msg success'>✓ Campo <code>imagen_url</code> agregado a tabla productos.</div>";
    } else {
        echo "<div class='status-msg warning'>⚠ Campo <code>imagen_url</code> ya existe en productos.</div>";
    }
    echo "</div>";

    // --- MÓDULO LOGÍSTICA ---
    echo "<div class='module-section'>";
    echo "<div class='module-title'>🚚 Módulo de Logística y Entregas</div>";

    // Crear tabla entregas
    $existsEntregas = $db->query("SHOW TABLES LIKE 'entregas'")->fetch();
    if (!$existsEntregas) {
        $db->exec("CREATE TABLE entregas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            folio VARCHAR(20) UNIQUE NOT NULL,
            pedido_id INT NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            fecha_entrega_estimada DATE,
            fecha_entrega_real DATETIME,
            estatus ENUM('Programado', 'En Tránsito', 'Entregado', 'Incidencia') DEFAULT 'Programado',
            transportista VARCHAR(100),
            guia_seguimiento VARCHAR(100),
            notas_entrega TEXT,
            evidencia_firma MEDIUMTEXT,
            FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
        )");
        echo "<div class='status-msg success'>✓ Tabla <code>entregas</code> creada correctamente.</div>";
    } else {
        echo "<div class='status-msg warning'>⚠ Tabla <code>entregas</code> ya existe.</div>";
    }

    // Crear tabla entrega_detalle
    $existsEntregaDetalle = $db->query("SHOW TABLES LIKE 'entrega_detalle'")->fetch();
    if (!$existsEntregaDetalle) {
        $db->exec("CREATE TABLE entrega_detalle (
            id INT AUTO_INCREMENT PRIMARY KEY,
            entrega_id INT NOT NULL,
            producto_id INT NOT NULL,
            cantidad_a_entregar INT NOT NULL,
            FOREIGN KEY (entrega_id) REFERENCES entregas(id) ON DELETE CASCADE,
            FOREIGN KEY (producto_id) REFERENCES productos(id)
        )");
        echo "<div class='status-msg success'>✓ Tabla <code>entrega_detalle</code> creada correctamente.</div>";
    } else {
        echo "<div class='status-msg warning'>⚠ Tabla <code>entrega_detalle</code> ya existe.</div>";
    }
    echo "</div>";

    echo "<div style='margin-top: 30px; display: flex; gap: 15px;'>";
    echo "<a href='index.php' class='btn'>Ir al Panel Principal</a>";
    echo "<a href='index.php?controller=Logistica&action=index' class='btn' style='background: var(--success)'>Ir a Logística</a>";
    echo "</div>";

} catch (Exception $e) {
    echo "<div class='status-msg error'>";
    echo "<strong>❌ Error en la migración:</strong> " . $e->getMessage();
    echo "</div>";
    echo "<a href='index.php' class='btn'>Volver al Inicio</a>";
}

echo "</div></body></html>";
?>