-- Base de datos para el proyecto final InnovaCode
-- Trabajo Final: MySQL y PHP

CREATE DATABASE IF NOT EXISTS innovacode CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE innovacode;

-- Tabla users_data: información personal de los usuarios
CREATE TABLE users_data (
    idUser INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion TEXT,
    sexo ENUM('M', 'F', 'Otro')
);

-- Tabla users_login: información de inicio de sesión
CREATE TABLE users_login (
    idLogin INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL UNIQUE,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE
);

-- Tabla citas: información de las citas
CREATE TABLE citas (
    idCita INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL,
    fecha_cita DATE NOT NULL,
    motivo_cita TEXT,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE
);

-- Tabla noticias: noticias del sitio web
CREATE TABLE noticias (
    idNoticia INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) UNIQUE NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    texto LONGTEXT NOT NULL,
    fecha DATE NOT NULL,
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE
);

-- Insertar usuario administrador por defecto
INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) 
VALUES ('Admin', 'Sistema', 'admin@innovacode.com', '123456789', '1990-01-01', 'Dirección Admin', 'M');

INSERT INTO users_login (idUser, usuario, password, rol) 
VALUES (1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Contraseña: password

-- Insertar algunas noticias de ejemplo
INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES
('Bienvenidos a InnovaCode', 'https://via.placeholder.com/800x400?text=Bienvenidos', 'Esta es la primera noticia de nuestro sitio web. Aquí encontrarás las últimas novedades sobre tecnología y desarrollo.', CURDATE(), 1),
('Nuevas tecnologías 2025', 'https://via.placeholder.com/800x400?text=Tecnologias+2025', 'Las tecnologías emergentes que marcarán el 2025. Descubre las últimas tendencias en desarrollo web y programación.', CURDATE(), 1),
('Curso de PHP avanzado', 'https://via.placeholder.com/800x400?text=PHP+Avanzado', 'Aprende PHP desde cero hasta nivel avanzado con nuestros cursos especializados.', CURDATE(), 1);