<?php
/**
 * Script de migración para asegurar que el ENUM de estatus en cotizaciones sea el correcto.
 */
require_once '../config/database.php';

try {
    $db = Database::getInstance();

    // Asegurar que el ENUM incluya todos los estatus necesarios
    $db->exec("ALTER TABLE cotizaciones MODIFY COLUMN estatus ENUM('Borrador', 'Enviada', 'Aprobada', 'Convertida', 'Cancelada') DEFAULT 'Borrador'");

    echo "<h1>✓ Migración de Estatus Completada</h1>";
    echo "<p>El campo ENUM ha sido actualizado para incluir 'Convertida'.</p>";
    echo "<a href='index.php?controller=Ventas&action=index'>Volver al ERP</a>";
} catch (Exception $e) {
    echo "<h1>❌ Error en la migración</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>