
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS mi_restaurante;
USE mi_restaurante;

-- Crear la tabla Usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL
);

-- Crear la tabla Restaurantes
CREATE TABLE restaurantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

-- Crear la tabla Reservas
CREATE TABLE reservas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    nombre VARCHAR(255),
    id_usuario INT,
    id_restaurante INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
);

-- Crear la tabla Especialidades
CREATE TABLE especialidades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    id_restaurante INT,
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
);

-- Crear la tabla Platos
CREATE TABLE platos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    id_restaurante INT,
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
);

-- Crear la tabla Opiniones
CREATE TABLE opiniones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    id_usuario INT,
    id_restaurante INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
);

-- Crear la tabla Incidencias
CREATE TABLE incidencias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descripcion TEXT,
    id_usuario INT,
    id_restaurante INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
);

-- Insertar datos en la tabla Usuarios
INSERT INTO usuarios (usuario, email, contrasena, rol) VALUES
('admin', 'admin@email.com', 'admin', 'admin'),
('usuario', 'usuario@email.com', 'usuario', 'usuario'),
('usuario3', 'usuario3@email.com', 'secreto789', 'usuario');

-- Insertar datos en la tabla Restaurantes
INSERT INTO restaurantes (nombre) VALUES
('Chez Antoine'),
('El Parador Mexicano'),
('The Sizzling Grill'),
('Sushi Palace'),
('Bistro Parisien');

-- Insertar datos en la tabla Reservas
INSERT INTO reservas (fecha, hora, nombre, id_usuario, id_restaurante) VALUES
('2023-01-01', '18:00:00', 'Cena Romántica', 1, 1),
('2023-01-02', '19:30:00', 'Celebración de Graduación', 2, 2),
('2023-01-03', '20:00:00', 'Aniversario Especial', 3, 3);


-- Insertar datos en la tabla Especialidades
INSERT INTO especialidades (nombre, id_restaurante) VALUES
('Cocina Francesa', 1),
('Auténtica Comida Mexicana', 2),
('Parrilla y Barbacoa', 3),
('Sushi y Sashimi', 4),
('Gastronomía Parisina', 5);

-- Insertar datos en la tabla Platos
INSERT INTO platos (nombre, id_restaurante) VALUES
('Filete Mignon', 1),
('Tacos al Pastor', 2),
('Chuletón a la Parrilla', 3),
('Sushi Variado Deluxe', 4),
('Escargot con Ajo y Perejil', 1),
('Enchiladas Verdes', 2),
('Costillas BBQ', 3),
('Roll de Tempura de Camarón', 4),
('Ratatouille', 5),
('Guacamole Fresco', 2),
('Papas Asadas', 3),
('Edamame', 4),
('Soufflé de Chocolate', 1),
('Tres Leches', 2),
('Cheesecake de Frambuesa', 3),
('Helado de Té Verde', 4),
('Crème Brûlée', 5);


-- Insertar datos en la tabla Opiniones
INSERT INTO opiniones (nombre, descripcion, id_usuario, id_restaurante) VALUES
('Paco','Buena experiencia', 1, 1),
('Pepe', 'Excelente servicio', 2, 2),
('Pedro','Comida deliciosa', 3, 3);

-- Insertar datos en la tabla Incidencias
INSERT INTO incidencias (descripcion, id_usuario, id_restaurante) VALUES
('Problema con la reserva', 1, 1),
('Servicio lento', 2, 2),
('Plato equivocado', 3, 3);
