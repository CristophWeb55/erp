<?php
/**
 * Script de migración para agregar campos stock_minimo e imagen_url
 * Ejecutar desde: http://localhost/ERP/public/migrate.php
 */

require_once '../config/database.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Migración de Base de Datos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #293887;
            border-bottom: 3px solid #293887;
            padding-bottom: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #dc3545;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #17a2b8;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #293887;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #1e2a5f;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 Migración de Base de Datos - Módulo de Productos</h1>";

try {
    $db = Database::getInstance();

    echo "<div class='info'>✓ Conexión a base de datos establecida</div>";

    // Verificar si las columnas ya existen
    $checkStockMinimo = $db->query("SHOW COLUMNS FROM productos LIKE 'stock_minimo'")->fetch();
    $checkImagenUrl = $db->query("SHOW COLUMNS FROM productos LIKE 'imagen_url'")->fetch();

    $cambios = [];

    // Agregar stock_minimo si no existe
    if (!$checkStockMinimo) {
        $db->exec("ALTER TABLE productos ADD COLUMN stock_minimo INT DEFAULT 10 AFTER costo_promedio");
        $cambios[] = "✓ Campo <code>stock_minimo</code> agregado correctamente";
    } else {
        $cambios[] = "⚠ Campo <code>stock_minimo</code> ya existe (no se modificó)";
    }

    // Agregar imagen_url si no existe
    if (!$checkImagenUrl) {
        $db->exec("ALTER TABLE productos ADD COLUMN imagen_url VARCHAR(255) DEFAULT NULL AFTER stock_minimo");
        $cambios[] = "✓ Campo <code>imagen_url</code> agregado correctamente";
    } else {
        $cambios[] = "⚠ Campo <code>imagen_url</code> ya existe (no se modificó)";
    }

    echo "<div class='success'>";
    echo "<h3>✅ Migración completada exitosamente</h3>";
    echo "<ul>";
    foreach ($cambios as $cambio) {
        echo "<li>$cambio</li>";
    }
    echo "</ul>";
    echo "</div>";

    // Mostrar estructura actual de la tabla
    echo "<div class='info'>";
    echo "<h3>📋 Estructura actual de la tabla 'productos':</h3>";
    echo "<table style='width: 100%; border-collapse: collapse;'>";
    echo "<tr style='background: #293887; color: white;'>
            <th style='padding: 10px; text-align: left;'>Campo</th>
            <th style='padding: 10px; text-align: left;'>Tipo</th>
            <th style='padding: 10px; text-align: left;'>Nulo</th>
            <th style='padding: 10px; text-align: left;'>Default</th>
          </tr>";

    $columns = $db->query("DESCRIBE productos")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "<tr style='border-bottom: 1px solid #ddd;'>";
        echo "<td style='padding: 8px;'><code>{$col['Field']}</code></td>";
        echo "<td style='padding: 8px;'>{$col['Type']}</td>";
        echo "<td style='padding: 8px;'>{$col['Null']}</td>";
        echo "<td style='padding: 8px;'>{$col['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";

    echo "<div class='info'>";
    echo "<h3>🎯 Próximos pasos:</h3>";
    echo "<ol>";
    echo "<li>Ir al módulo de productos: <a href='index.php?controller=Productos&action=index'>Ver Productos</a></li>";
    echo "<li>(Opcional) Cargar datos de ejemplo ejecutando: <code>sql/seed_productos_ejemplo.sql</code></li>";
    echo "<li>Crear o editar productos con los nuevos campos</li>";
    echo "</ol>";
    echo "</div>";

} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<h3>❌ Error en la migración</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "</div>";
}

echo "<a href='index.php?controller=Productos&action=index' class='btn'>Ir al Módulo de Productos</a>";
echo "</div></body></html>";
?>