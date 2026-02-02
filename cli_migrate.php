<?php
/**
 * CLI Migration Script
 */
require_once __DIR__ . '/config/database.php';

try {
    $db = Database::getInstance();
    echo "Conexión a base de datos establecida.\n";

    // Verificar columnas
    $columns = $db->query("SHOW COLUMNS FROM productos")->fetchAll(PDO::FETCH_COLUMN);

    if (!in_array('stock_minimo', $columns)) {
        echo "Agregando columna stock_minimo...\n";
        $db->exec("ALTER TABLE productos ADD COLUMN stock_minimo INT DEFAULT 10 AFTER costo_promedio");
    } else {
        echo "La columna stock_minimo ya existe.\n";
    }

    if (!in_array('imagen_url', $columns)) {
        echo "Agregando columna imagen_url...\n";
        $db->exec("ALTER TABLE productos ADD COLUMN imagen_url VARCHAR(255) DEFAULT NULL AFTER stock_minimo");
    } else {
        echo "La columna imagen_url ya existe.\n";
    }

    echo "¡Migración completada con éxito!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
