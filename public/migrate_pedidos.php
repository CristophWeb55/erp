<?php
/**
 * Script de migración para el Módulo de Pedidos y Lotes
 * Ejecutar desde: http://localhost/ERP/public/migrate_pedidos.php
 */

require_once '../config/database.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Migración de Módulo de Pedidos</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; max-width: 850px; margin: 40px auto; background: #f0f2f5; color: #333; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h1 { color: #1a73e8; border-bottom: 2px solid #e8eaed; padding-bottom: 15px; }
        .status { padding: 12px 18px; border-radius: 6px; margin: 15px 0; font-weight: 500; }
        .success { background: #e6f4ea; color: #1e8e3e; border-left: 5px solid #34a853; }
        .error { background: #fce8e6; color: #d93025; border-left: 5px solid #ea4335; }
        .info { background: #e8f0fe; color: #1967d2; border-left: 5px solid #4285f4; }
        ul { list-style: none; padding: 0; }
        li { padding: 8px 0; border-bottom: 1px solid #f1f3f4; }
        li:before { content: '✓ '; color: #34a853; font-weight: bold; }
        li.exists:before { content: '⚠ '; color: #fbbc04; }
        .btn { display: inline-block; padding: 12px 24px; background: #1a73e8; color: white; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background 0.2s; }
        .btn:hover { background: #1557b0; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; font-size: 13px; border: 1px solid #dadce0; }
    </style>
</head>
<body>
    <div class='card'>
        <h1>🚀 Migración: Módulo de Pedidos</h1>";

try {
    $db = Database::getInstance();
    echo "<div class='status info'>Conexión exitosa a la base de datos <code>" . DB_NAME . "</code></div>";

    $queries = [
        "Pedidos" => "CREATE TABLE IF NOT EXISTS pedidos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            cotizacion_id INT,
            folio VARCHAR(20) UNIQUE NOT NULL,
            cliente_id INT NOT NULL,
            vendedor_id INT,
            fecha_pedido DATE NOT NULL,
            fecha_entrega_estimada DATE,
            subtotal DECIMAL(15,2) NOT NULL DEFAULT 0.00,
            iva DECIMAL(15,2) NOT NULL DEFAULT 0.00,
            total DECIMAL(15,2) NOT NULL DEFAULT 0.00,
            estatus ENUM('Pendiente', 'En Proceso', 'Surtido', 'Facturado', 'Cancelado') DEFAULT 'Pendiente',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (cliente_id) REFERENCES terceros(id),
            FOREIGN KEY (vendedor_id) REFERENCES usuarios(id),
            FOREIGN KEY (cotizacion_id) REFERENCES cotizaciones(id)
        )",
        "Detalle de Pedidos" => "CREATE TABLE IF NOT EXISTS pedido_detalle (
            id INT AUTO_INCREMENT PRIMARY KEY,
            pedido_id INT NOT NULL,
            producto_id INT NOT NULL,
            cantidad INT NOT NULL,
            precio_unitario DECIMAL(15,2) NOT NULL,
            subtotal DECIMAL(15,2) NOT NULL,
            FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
            FOREIGN KEY (producto_id) REFERENCES productos(id)
        )",
        "Compras" => "CREATE TABLE IF NOT EXISTS compras (
            id INT AUTO_INCREMENT PRIMARY KEY,
            proveedor_id INT NOT NULL,
            fecha_compra DATE NOT NULL,
            referencia VARCHAR(50),
            total DECIMAL(15,2) NOT NULL DEFAULT 0.00,
            estatus ENUM('Pendiente', 'Recibida', 'Cancelada') DEFAULT 'Pendiente',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (proveedor_id) REFERENCES terceros(id)
        )",
        "Inventario por Lotes" => "CREATE TABLE IF NOT EXISTS inventario_lotes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            producto_id INT NOT NULL,
            compra_id INT,
            cantidad_inicial INT NOT NULL,
            cantidad_actual INT NOT NULL,
            numero_pedimento VARCHAR(21),
            fecha_pedimento DATE,
            nombre_aduana VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (producto_id) REFERENCES productos(id),
            FOREIGN KEY (compra_id) REFERENCES compras(id)
        )"
    ];

    echo "<ul>";
    foreach ($queries as $name => $sql) {
        // Verificar si la tabla ya existe (para un mensaje más informativo)
        $tableName = strtolower(str_replace(' ', '_', $name));
        if ($name == "Pedidos")
            $tableName = "pedidos";
        if ($name == "Detalle de Pedidos")
            $tableName = "pedido_detalle";
        if ($name == "Compras")
            $tableName = "compras";
        if ($name == "Inventario por Lotes")
            $tableName = "inventario_lotes";

        $check = $db->query("SHOW TABLES LIKE '$tableName'")->fetch();

        if ($check) {
            echo "<li class='exists'>La tabla <strong>$tableName</strong> ($name) ya existe.</li>";
        } else {
            $db->exec($sql);
            echo "<li>Tabla <strong>$tableName</strong> ($name) creada exitosamente.</li>";
        }
    }
    echo "</ul>";

    echo "<div class='status success'>
            <h3>✅ ¡Todo listo!</h3>
            <p>Las tablas necesarias para el módulo de pedidos han sido verificadas/creadas.</p>
          </div>";

    echo "<div style='margin-top: 30px;'>
            <a href='index.php?controller=Pedidos&action=index' class='btn'>Ir al Módulo de Pedidos</a>
            <a href='index.php' style='margin-left: 15px; color: #5f6368;'>Volver al Inicio</a>
          </div>";

} catch (Exception $e) {
    echo "<div class='status error'>
            <h3>❌ Error durante la migración</h3>
            <p>" . $e->getMessage() . "</p>
            <pre>" . $e->getTraceAsString() . "</pre>
          </div>";
}

echo "</div></body></html>";
