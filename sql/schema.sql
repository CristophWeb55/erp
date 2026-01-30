-- Database schema for ERP MVP with Pedimento tracking
CREATE DATABASE IF NOT EXISTS erp_pedimentos;
USE erp_pedimentos;

-- Terceros (Clientes y Proveedores)
CREATE TABLE IF NOT EXISTS terceros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_razon_social VARCHAR(255) NOT NULL,
    rfc VARCHAR(13) NOT NULL,
    direccion TEXT,
    email VARCHAR(100),
    telefono VARCHAR(20),
    tipo ENUM('Cliente', 'Proveedor', 'Ambos') DEFAULT 'Cliente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT NOT NULL,
    precio_venta DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    costo_promedio DECIMAL(15,2) DEFAULT 0.00,
    requiere_pedimento BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cotizaciones / Pedidos
CREATE TABLE IF NOT EXISTS cotizaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    fecha_emision DATE NOT NULL,
    subtotal DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    iva DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    estatus ENUM('Borrador', 'Enviada', 'Aprobada', 'Cancelada') DEFAULT 'Borrador',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES terceros(id)
);

CREATE TABLE IF NOT EXISTS cotizacion_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cotizacion_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(15,2) NOT NULL,
    subtotal DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (cotizacion_id) REFERENCES cotizaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Compras (Entradas)
CREATE TABLE IF NOT EXISTS compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedor_id INT NOT NULL,
    fecha_compra DATE NOT NULL,
    referencia VARCHAR(50),
    total DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    estatus ENUM('Pendiente', 'Recibida', 'Cancelada') DEFAULT 'Pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proveedor_id) REFERENCES terceros(id)
);

-- Inventario Lotes (The core of Pedimento)
CREATE TABLE IF NOT EXISTS inventario_lotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    compra_id INT,
    cantidad_inicial INT NOT NULL,
    cantidad_actual INT NOT NULL,
    numero_pedimento VARCHAR(21), -- Cadena de 15 a 21 dígitos para cumplimiento
    fecha_pedimento DATE,
    nombre_aduana VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (compra_id) REFERENCES compras(id)
);

-- Facturas (Simuladas)
CREATE TABLE IF NOT EXISTS facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cotizacion_id INT,
    cliente_id INT NOT NULL,
    folio_fiscal_uuid VARCHAR(36),
    fecha_emision DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(15,2) NOT NULL,
    saldo_pendiente DECIMAL(15,2) NOT NULL,
    estatus ENUM('Pendiente', 'Pagada', 'Cancelada') DEFAULT 'Pendiente',
    FOREIGN KEY (cliente_id) REFERENCES terceros(id),
    FOREIGN KEY (cotizacion_id) REFERENCES cotizaciones(id)
);

CREATE TABLE IF NOT EXISTS factura_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    factura_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(15,2) NOT NULL,
    lote_origen_id INT, -- Ligamos con el pedimento específico
    FOREIGN KEY (factura_id) REFERENCES facturas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (lote_origen_id) REFERENCES inventario_lotes(id)
);

-- Pagos
CREATE TABLE IF NOT EXISTS pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    factura_id INT NOT NULL,
    fecha_pago DATE NOT NULL,
    monto DECIMAL(15,2) NOT NULL,
    forma_pago VARCHAR(50),
    referencia VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (factura_id) REFERENCES facturas(id)
);

-- Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Admin', 'Ventas', 'Almacen') DEFAULT 'Admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario por defecto (password: admin123)
-- Nota: En producción usar password_hash
INSERT INTO usuarios (nombre, usuario, password, rol) 
VALUES ('Administrador Genesis', 'admin', '$2y$10$8.09f6vK.iX..w..x..y..z..v..w..u..t..s..r..q..p..o', 'Admin')
ON DUPLICATE KEY UPDATE id=id;

