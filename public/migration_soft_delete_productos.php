<?php
// Script temporal para agregar soft delete
// Ajustar ruta si es necesario, asumo que Database.php está en app/config
require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getInstance();
    // Verificar si la columna existe para evitar error
    $check = $db->query("SHOW COLUMNS FROM productos LIKE 'activo'");
    if ($check->rowCount() == 0) {
        $sql = "ALTER TABLE productos ADD COLUMN activo BOOLEAN DEFAULT TRUE";
        $db->query($sql);
        echo "Columna 'activo' agregada correctamente a la tabla 'productos'.\n";
    } else {
        echo "La columna 'activo' ya existe.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>