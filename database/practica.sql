DROP DATABASE IF EXISTS practica_daw2_und1;

CREATE DATABASE practica_daw2_und1;

USE practica_daw2_und1;


/* ===========================
   VARIANTE A
   =========================== */

CREATE TABLE prestamos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante VARCHAR(100) NOT NULL,
    equipo VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'PRESTADO'
);

INSERT INTO prestamos
(estudiante, equipo, fecha, estado)
VALUES
('Ana Torres', 'Laptop HP', '2026-09-20', 'PRESTADO'),
('Luis Pérez', 'Proyector Epson', '2026-09-21', 'DEVUELTO');


/* ===========================
   VARIANTE B
   =========================== */

CREATE TABLE incidencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    asunto VARCHAR(150) NOT NULL,
    prioridad VARCHAR(20) NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'PENDIENTE'
);

INSERT INTO incidencias
(usuario, asunto, prioridad, estado)
VALUES
('Carlos Pérez', 'No puede acceder al sistema', 'ALTA', 'PENDIENTE'),
('Ana Torres', 'Impresora no responde', 'MEDIA', 'ATENDIDO');


/* ===========================
   VARIANTE C
   =========================== */

CREATE TABLE equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(30) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'OPERATIVO'
);

INSERT INTO equipos
(codigo, nombre, categoria, estado)
VALUES
('EQ-001', 'Laptop Lenovo', 'Laptop', 'OPERATIVO'),
('EQ-002', 'Proyector Epson', 'Proyector', 'OPERATIVO');