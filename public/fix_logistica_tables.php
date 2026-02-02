<?php
require_once __DIR__ . '/../app/config/Database.php';

try {
    $db = Database::getInstance();

    echo "Verificando tablas de Logística...\n";

    $queries = [
        "CREATE TABLE IF NOT EXISTS transportistas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            rfc VARCHAR(15),
            telefono VARCHAR(20),
            correo VARCHAR(100),
            activo TINYINT(1) DEFAULT 1,
            fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        "CREATE TABLE IF NOT EXISTS vehiculos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            placas VARCHAR(20) UNIQUE NOT NULL,
            marca_modelo VARCHAR(100),
            tipo VARCHAR(50),
            transportista_id INT,
            activo TINYINT(1) DEFAULT 1,
            FOREIGN KEY (transportista_id) REFERENCES transportistas(id) ON DELETE SET NULL
        )"
    ];

    foreach ($queries as $query) {
        $db->exec($query);
        echo "Ejecutando: " . substr($query, 0, 50) . "...\n";
    }

    echo "Tablas creadas o ya existentes correctamente.\n";

    // Insertar algunos datos de ejemplo si están vacías
    $check = $db->query("SELECT COUNT(*) FROM transportistas")->fetchColumn();
    if ($check == 0) {
        $db->exec("INSERT INTO transportistas (nombre, activo) VALUES ('Transportes Internos', 1), ('Logística Nacional', 1)");
        echo "Datos de ejemplo insertados en transportistas.\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
