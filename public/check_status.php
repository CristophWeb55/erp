<?php
require_once '../config/database.php';
$db = Database::getInstance();

echo "<h1>Diagnostic Schema & Status</h1>";

$col = $db->query("SHOW COLUMNS FROM cotizaciones LIKE 'estatus'")->fetch(PDO::FETCH_ASSOC);
echo "<h3>ENUM Definition:</h3>";
echo "Type: " . htmlspecialchars($col['Type']) . "<br>";

$cotizaciones = $db->query("SELECT id, folio, estatus FROM cotizaciones")->fetchAll(PDO::FETCH_ASSOC);
echo "<h3>Current Data:</h3>";
foreach ($cotizaciones as $c) {
    echo "ID: {$c['id']} | Folio: {$c['folio']} | Status: '{$c['estatus']}'<br>";
}
?>