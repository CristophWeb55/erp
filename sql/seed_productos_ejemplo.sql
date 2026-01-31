-- Datos de ejemplo para productos con imágenes
-- Ejecutar después de la migración

USE erp_pedimentos;

-- Insertar productos de ejemplo
INSERT INTO productos (sku, descripcion, precio_venta, stock_minimo, imagen_url, requiere_pedimento) VALUES
('UR-MTR-001', 'Motor Eléctrico Trifásico 5HP', 12500.00, 10, 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400', 1),
('UR-MTR-002', 'Motor Eléctrico Trifásico 10HP', 18750.00, 8, 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400', 1),
('UR-MTR-003', 'Motor Eléctrico Trifásico 15HP', 24500.00, 5, 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400', 1),
('UR-TRF-001', 'Transformador Trifásico 75 KVA', 45000.00, 3, 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=400', 1),
('UR-TRF-002', 'Transformador Trifásico 112.5 KVA', 62000.00, 3, 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=400', 1),
('UR-CBL-001', 'Cable Calibre 12 AWG (Metro)', 45.50, 500, NULL, 0),
('UR-CBL-002', 'Cable Calibre 10 AWG (Metro)', 68.00, 500, NULL, 0),
('UR-INT-001', 'Interruptor Termomagnético 20A', 285.00, 50, NULL, 0),
('UR-INT-002', 'Interruptor Termomagnético 30A', 325.00, 50, NULL, 0),
('UR-CNT-001', 'Contactor 25A 220V', 890.00, 20, NULL, 1)
ON DUPLICATE KEY UPDATE id=id;

-- Insertar inventario de ejemplo para los productos
-- Motor 5HP
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual, numero_pedimento, fecha_pedimento, nombre_aduana)
SELECT id, 150, 150, '23  48  3807  8001234', '2024-01-15', 'Aduana de Veracruz'
FROM productos WHERE sku = 'UR-MTR-001';

-- Motor 10HP
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual, numero_pedimento, fecha_pedimento, nombre_aduana)
SELECT id, 100, 75, '23  48  3807  8001235', '2024-01-20', 'Aduana de Veracruz'
FROM productos WHERE sku = 'UR-MTR-002';

-- Motor 15HP
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual, numero_pedimento, fecha_pedimento, nombre_aduana)
SELECT id, 50, 12, '23  48  3807  8001236', '2024-02-01', 'Aduana de Veracruz'
FROM productos WHERE sku = 'UR-MTR-003';

-- Transformador 75 KVA
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual, numero_pedimento, fecha_pedimento, nombre_aduana)
SELECT id, 20, 8, '23  48  3807  8001237', '2024-01-10', 'Aduana de Manzanillo'
FROM productos WHERE sku = 'UR-TRF-001';

-- Transformador 112.5 KVA
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual, numero_pedimento, fecha_pedimento, nombre_aduana)
SELECT id, 15, 2, '23  48  3807  8001238', '2024-01-10', 'Aduana de Manzanillo'
FROM productos WHERE sku = 'UR-TRF-002';

-- Cable 12 AWG
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual)
SELECT id, 5000, 3200 FROM productos WHERE sku = 'UR-CBL-001';

-- Cable 10 AWG
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual)
SELECT id, 3000, 1800 FROM productos WHERE sku = 'UR-CBL-002';

-- Interruptor 20A
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual)
SELECT id, 200, 120 FROM productos WHERE sku = 'UR-INT-001';

-- Interruptor 30A
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual)
SELECT id, 150, 85 FROM productos WHERE sku = 'UR-INT-002';

-- Contactor
INSERT INTO inventario_lotes (producto_id, cantidad_inicial, cantidad_actual, numero_pedimento, fecha_pedimento, nombre_aduana)
SELECT id, 100, 45, '23  48  3807  8001239', '2024-02-05', 'Aduana de Veracruz'
FROM productos WHERE sku = 'UR-CNT-001';

SELECT 'Productos de ejemplo insertados correctamente' as mensaje;
