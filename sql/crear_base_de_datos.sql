-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS tienda_virtual_crud;

USE tienda_virtual_crud;

-- Crear tabla de Categorías
CREATE TABLE IF NOT EXISTS TBL_Categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(255) NOT NULL,
    descripcion_categoria TEXT,
    fecha_categoria TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de Productos
CREATE TABLE IF NOT EXISTS TBL_Productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT,
    nombre_producto VARCHAR(255) NOT NULL,
    descripcion_producto TEXT,
    precio_producto DECIMAL(10, 2) NOT NULL,
    stock_producto INT NOT NULL,
    oferta_producto BOOLEAN DEFAULT 0,
    fecha_producto TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES TBL_Categorias(id_categoria) ON DELETE SET NULL
);

-- Crear tabla de Usuarios
CREATE TABLE IF NOT EXISTS TBL_Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(255) NOT NULL,
    correo_usuario VARCHAR(255) UNIQUE NOT NULL,
    contrasena_usuario VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de Métodos de Pago
CREATE TABLE IF NOT EXISTS TBL_Metodos_Pago (
    id_metodo_pago INT AUTO_INCREMENT PRIMARY KEY,
    nombre_metodo_pago VARCHAR(255) NOT NULL,
    descripcion_metodo_pago TEXT
);

-- Crear tabla de Pedidos
CREATE TABLE IF NOT EXISTS TBL_Pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado_pedido VARCHAR(50) DEFAULT 'Pendiente',
    FOREIGN KEY (id_usuario) REFERENCES TBL_Usuarios(id_usuario)
);

-- Tabla pivote: Relación entre Productos y Pedidos
CREATE TABLE IF NOT EXISTS TBL_Rel_Pedidos_Productos (
    id_pedido INT,
    id_producto INT,
    cantidad INT NOT NULL,
    PRIMARY KEY (id_pedido, id_producto),
    FOREIGN KEY (id_pedido) REFERENCES TBL_Pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES TBL_Productos(id_producto) ON DELETE CASCADE
);

-- Tabla pivote: Relación entre Usuarios y Métodos de Pago
CREATE TABLE IF NOT EXISTS TBL_Usuarios_Metodos_Pago (
    id_usuario INT,
    id_metodo_pago INT,
    PRIMARY KEY (id_usuario, id_metodo_pago),
    FOREIGN KEY (id_usuario) REFERENCES TBL_Usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_metodo_pago) REFERENCES TBL_Metodos_Pago(id_metodo_pago) ON DELETE CASCADE
);

-- Insertar datos de ejemplo en Categorías
INSERT INTO TBL_Categorias (nombre_categoria, descripcion_categoria) VALUES 
('Electrónica', 'Dispositivos electrónicos como móviles, computadoras, etc.'),
('Ropa', 'Ropa para hombres, mujeres y niños'),
('Hogar', 'Artículos de hogar y decoración');

-- Insertar datos de ejemplo en Métodos de Pago
INSERT INTO TBL_Metodos_Pago (nombre_metodo_pago, descripcion_metodo_pago) VALUES
('Tarjeta de Crédito', 'Pago mediante tarjeta de crédito.'),
('PayPal', 'Pago mediante cuenta PayPal.'),
('Transferencia Bancaria', 'Pago mediante transferencia bancaria.');

-- Insertar datos de ejemplo en Productos
INSERT INTO TBL_Productos (id_categoria, nombre_producto, descripcion_producto, precio_producto, stock_producto, oferta_producto) VALUES
(1, 'Smartphone XYZ', 'Teléfono móvil con pantalla de 6.5 pulgadas y 128GB de almacenamiento', 299.99, 50, 1),
(2, 'Camisa de Algodón', 'Camisa de algodón para hombre, disponible en varios colores', 19.99, 100, 0),
(3, 'Sofá 3 plazas', 'Sofá de tres plazas en color gris, ideal para salas de estar', 499.99, 30, 0);
