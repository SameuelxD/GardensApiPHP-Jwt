CREATE DATABASE jardineria;
USE jardineria;
CREATE TABLE oficina (
  codigo_oficina VARCHAR(10) NOT NULL,
  ciudad VARCHAR(30) NOT NULL,
  pais VARCHAR(50) NOT NULL,
  region VARCHAR(50) DEFAULT NULL,
  codigo_postal VARCHAR(10) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  linea_direccion1 VARCHAR(50) NOT NULL,
  linea_direccion2 VARCHAR(50) DEFAULT NULL,
  CONSTRAINT PK_oficina_codigo_oficina PRIMARY KEY (codigo_oficina)
);
CREATE TABLE empleado (
  codigo_empleado INTEGER NOT NULL,
  nombre VARCHAR(50) NOT NULL,
  apellido1 VARCHAR(50) NOT NULL,
  apellido2 VARCHAR(50) DEFAULT NULL,
  extension VARCHAR(10) NOT NULL,
  email VARCHAR(100) NOT NULL,
  codigo_oficina VARCHAR(10) NOT NULL,
  codigo_jefe INTEGER DEFAULT NULL,
  puesto VARCHAR(50) DEFAULT NULL,
  CONSTRAINT PK_codigo_empleado PRIMARY KEY (codigo_empleado),
  CONSTRAINT FK_empleado_codigo_oficina_oficina_codigo_oficina FOREIGN KEY (codigo_oficina) REFERENCES oficina (codigo_oficina),
  CONSTRAINT FK_empleado_codigo_jefe_empleado_codigo_empleado FOREIGN KEY (codigo_jefe) REFERENCES empleado (codigo_empleado)
);
CREATE TABLE gama_producto (
  gama VARCHAR(50) NOT NULL,
  descripcion_texto TEXT,
  descripcion_html TEXT,
  imagen VARCHAR(256),
  CONSTRAINT PK_gama_producto_gama PRIMARY KEY (gama)
);
CREATE TABLE cliente (
  codigo_cliente INTEGER NOT NULL,
  nombre_cliente VARCHAR(50) NOT NULL,
  nombre_contacto VARCHAR(30) DEFAULT NULL,
  apellido_contacto VARCHAR(30) DEFAULT NULL,
  telefono VARCHAR(15) NOT NULL,
  fax VARCHAR(15) NOT NULL,
  linea_direccion1 VARCHAR(50) NOT NULL,
  linea_direccion2 VARCHAR(50) DEFAULT NULL,
  ciudad VARCHAR(50) NOT NULL,
  region VARCHAR(50) DEFAULT NULL,
  pais VARCHAR(50) DEFAULT NULL,
  codigo_postal VARCHAR(10) DEFAULT NULL,
  codigo_empleado_rep_ventas INTEGER DEFAULT NULL,
  limite_credito NUMERIC(15, 2) DEFAULT NULL,
  CONSTRAINT PK_cliente_codigo_cliente PRIMARY KEY (codigo_cliente),
  CONSTRAINT FK_cliente_codigo_empleado_rep_ventas_empleado_codigo_empleado FOREIGN KEY (codigo_empleado_rep_ventas) REFERENCES empleado (codigo_empleado)
);
CREATE TABLE pedido (
  codigo_pedido INTEGER NOT NULL,
  fecha_pedido date NOT NULL,
  fecha_esperada date NOT NULL,
  fecha_entrega date DEFAULT NULL,
  estado VARCHAR(15) NOT NULL,
  comentarios TEXT,
  codigo_cliente INTEGER NOT NULL,
  CONSTRAINT PK_pedido_codigo_pedido PRIMARY KEY (codigo_pedido),
  CONSTRAINT FK_pedido_codigo_cliente_cliente_codigo_cliente FOREIGN KEY (codigo_cliente) REFERENCES cliente (codigo_cliente)
);
CREATE TABLE producto (
  codigo_producto VARCHAR(15) NOT NULL,
  nombre VARCHAR(70) NOT NULL,
  gama VARCHAR(50) NOT NULL,
  dimensiones VARCHAR(25) NULL,
  proveedor VARCHAR(50) DEFAULT NULL,
  descripcion text NULL,
  cantidad_en_stock SMALLINT NOT NULL,
  precio_venta NUMERIC(15, 2) NOT NULL,
  precio_proveedor NUMERIC(15, 2) DEFAULT NULL,
  CONSTRAINT PK_producto_codigo_producto PRIMARY KEY (codigo_producto),
  CONSTRAINT FK_producto_gama_gama_producto_gama FOREIGN KEY (gama) REFERENCES gama_producto (gama)
);
CREATE TABLE detalle_pedido (
  codigo_pedido INTEGER NOT NULL,
  codigo_producto VARCHAR(15) NOT NULL,
  cantidad INTEGER NOT NULL,
  precio_unidad NUMERIC(15, 2) NOT NULL,
  numero_linea SMALLINT NOT NULL,
  CONSTRAINT PK_detalle_pedido_codigo_pedido__codigo_producto PRIMARY KEY (codigo_pedido, codigo_producto),
  CONSTRAINT FK_detalle_pedido_codigo_pedido_pedido_codigo_pedido FOREIGN KEY (codigo_pedido) REFERENCES pedido (codigo_pedido),
  CONSTRAINT FK_detalle_pedido_codigo_producto_producto_codigo_producto FOREIGN KEY (codigo_producto) REFERENCES producto (codigo_producto)
);
CREATE TABLE pago (
  codigo_cliente INTEGER NOT NULL,
  forma_pago VARCHAR(40) NOT NULL,
  id_transaccion VARCHAR(50) NOT NULL,
  fecha_pago date NOT NULL,
  total NUMERIC(15, 2) NOT NULL,
  CONSTRAINT PK_pago_codigo_cliente__id_transaccion PRIMARY KEY (codigo_cliente, id_transaccion),
  CONSTRAINT FK_pago_codigo_cliente_cliente_codigo_cliente FOREIGN KEY (codigo_cliente) REFERENCES cliente (codigo_cliente)
);
-- Crear tabla de roles
CREATE TABLE Rol (
  id INT PRIMARY KEY AUTO_INCREMENT,
  names VARCHAR(20) NOT NULL
);
-- Crear tabla de usuarios
CREATE TABLE User (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(20) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(50) NOT NULL,
  rol_id INT,
  FOREIGN KEY (rol_id) REFERENCES Rol(id)
);
-- Crear tabla de tokens de actualización
CREATE TABLE RefreshToken (
  id INT PRIMARY KEY AUTO_INCREMENT,
  token VARCHAR(255) UNIQUE NOT NULL,
  user_id INT NOT NULL,
  expires_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES User(id)
);