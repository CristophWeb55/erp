<?php
/**
 * CLI Seed Script
 */
require_once __DIR__ . '/config/database.php';

try {
    $db = Database::getInstance();
    echo "Conexión a base de datos establecida.\n";

    $sql = file_get_contents(__DIR__ . '/sql/seed_productos_ejemplo.sql');

    // El script contiene múltiples comandos, PDO::exec puede no soportarlos todos a la vez dependiendo de la configuración
    // Pero intentaremos ejecutarlo directamente.
    $db->exec($sql);

    echo "¡Datos de ejemplo insertados con éxito!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
