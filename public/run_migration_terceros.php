<?php
require_once '../config/database.php';

try {
    $db = Database::getInstance();

    // Check if column exists
    $result = $db->query("SHOW COLUMNS FROM terceros LIKE 'imagen_url'");
    $exists = $result->fetch();

    if (!$exists) {
        $db->exec("ALTER TABLE terceros ADD COLUMN imagen_url VARCHAR(255) DEFAULT NULL AFTER tipo");
        echo "✅ Columna 'imagen_url' añadida exitosamente a la tabla 'terceros'.<br>";
    } else {
        echo "ℹ️ La columna 'imagen_url' ya existe en la tabla 'terceros'.<br>";
    }

    // Ensure upload directory exists
    $uploadDir = 'uploads/terceros';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        echo "✅ Directorio de cargas '$uploadDir' creado.<br>";
    }

} catch (PDOException $e) {
    echo "❌ Error en la migración: " . $e->getMessage();
}
