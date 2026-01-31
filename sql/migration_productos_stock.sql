-- Migración: Agregar campos stock_minimo e imagen_url a productos
-- Fecha: 2026-01-31

USE erp_pedimentos;

-- Agregar campo stock_minimo si no existe
ALTER TABLE productos 
ADD COLUMN IF NOT EXISTS stock_minimo INT DEFAULT 10 AFTER costo_promedio;

-- Agregar campo imagen_url si no existe
ALTER TABLE productos 
ADD COLUMN IF NOT EXISTS imagen_url VARCHAR(255) DEFAULT NULL AFTER stock_minimo;

-- Verificar cambios
DESCRIBE productos;
