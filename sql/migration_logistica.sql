-- Migración para el Módulo de Logística y Entregas

CREATE TABLE IF NOT EXISTS entregas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    folio VARCHAR(20) UNIQUE NOT NULL,
    pedido_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_entrega_estimada DATE,
    fecha_entrega_real DATETIME,
    estatus ENUM('Programado', 'En Tránsito', 'Entregado', 'Incidencia') DEFAULT 'Programado',
    transportista VARCHAR(100),
    guia_seguimiento VARCHAR(100),
    notas_entrega TEXT,
    evidencia_firma MEDIUMTEXT, -- Para guardar la firma en Base64
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

CREATE TABLE IF NOT EXISTS entrega_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entrega_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad_a_entregar INT NOT NULL,
    FOREIGN KEY (entrega_id) REFERENCES entregas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);
