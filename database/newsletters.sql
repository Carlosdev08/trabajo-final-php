-- Base de datos para el proyecto final InnovaCode
-- Trabajo Final: MySQL y PHP
-- NOTA: Esta base de datos se llama 'newsletters' en el entorno actual

CREATE DATABASE IF NOT EXISTS newsletters CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE newsletters;

-- Tabla users_data: información personal de los usuarios
CREATE TABLE IF NOT EXISTS users_data (
    idUser BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion VARCHAR(255),
    sexo VARCHAR(20),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabla users_login: información de inicio de sesión
CREATE TABLE IF NOT EXISTS users_login (
    idLogin BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    idUser BIGINT UNSIGNED NOT NULL UNIQUE,
    usuario VARCHAR(191) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(191) NOT NULL,
    rol ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    remember_token VARCHAR(100),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE
);

-- Tabla citas: información de las citas
CREATE TABLE IF NOT EXISTS citas (
    idCita BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    idUser BIGINT UNSIGNED NOT NULL,
    fecha_cita DATE NOT NULL,
    motivo_cita VARCHAR(255),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE,
    INDEX citas_iduser_index (idUser),
    INDEX citas_fecha_cita_index (fecha_cita)
);

-- Tabla noticias: información de las noticias
CREATE TABLE IF NOT EXISTS noticias (
    idNoticia BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) UNIQUE NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    texto TEXT NOT NULL,
    fecha DATE NOT NULL,
    idUser BIGINT UNSIGNED NOT NULL,
    contenido TEXT,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE,
    INDEX noticias_fecha_index (fecha)
);

-- Tabla sessions (opcional para manejo de sesiones avanzado)
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(191) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);

-- CREDENCIALES DE ACCESO:
-- Admin: usuario='admin', password='admin123'
-- Usuario: usuario='miralofles', password='user123'
-- 
-- Las contraseñas están hasheadas con PASSWORD_DEFAULT de PHP

-- Datos de ejemplo (coinciden con tu base de datos actual)
-- Usuario administrador
INSERT INTO users_data (idUser, nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo, created_at, updated_at) VALUES
(1, 'Admin', 'Principal', 'admin@example.com', '600000000', '1980-01-01', 'Sede Central 1', 'O', NOW(), NOW())
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

INSERT INTO users_login (idLogin, idUser, usuario, email, password, rol, created_at, updated_at) VALUES
(1, 1, 'admin', 'admin@example.com', '$2y$12$FINtsH3VkvSIbOXD8G7jXeGFyVD3ZRQChpOR4jDqAwaF11OHRldye', 'admin', NOW(), NOW())
ON DUPLICATE KEY UPDATE password = VALUES(password);

-- Usuario regular (miralofles - existente en tu BD)
INSERT INTO users_data (idUser, nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo, created_at, updated_at) VALUES
(2, 'miralofles', 'Golden', 'miralofles@miralofles.com', '622622622', '1985-08-25', 'miralofles 12', 'M', NOW(), NOW())
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

INSERT INTO users_login (idLogin, idUser, usuario, email, password, rol, created_at, updated_at) VALUES
(2, 2, 'miralofles', 'miralofles@miralofles.com', '$2y$12$GVRMrNum//QLELfdHSFNjudbfHbs/JOxN8IlcBRUNlcjCKDZ.YcvW', 'user', NOW(), NOW())
ON DUPLICATE KEY UPDATE password = VALUES(password);

-- Noticias de ejemplo (basadas en tu estructura actual)
INSERT INTO noticias (idNoticia, titulo, imagen, texto, fecha, idUser, contenido, created_at, updated_at) VALUES
(1, 'Bienvenido a InnovaCode', 'https://picsum.photos/seed/bienvenido-innovacode/800/480', 'Esta es una noticia de bienvenida al sistema InnovaCode. Aquí podrás gestionar usuarios, noticias y citaciones de manera eficiente. El sistema cuenta con todas las funcionalidades implementadas y seguridad avanzada.', CURDATE(), 1, 'Sistema de gestión completo con todas las funcionalidades implementadas.', NOW(), NOW()),
(2, 'Nueva actualización de seguridad', 'https://picsum.photos/seed/seguridad-update/800/480', 'Hemos implementado nuevas medidas de seguridad incluyendo protección CSRF, rate limiting y logs de seguridad. Tu información está más protegida que nunca.', CURDATE(), 1, 'Mejoras de seguridad implementadas con éxito.', NOW(), NOW()),
(3, 'Funcionalidades del sistema', 'https://picsum.photos/seed/funcionalidades-sistema/800/480', 'Descubre todas las funcionalidades disponibles: gestión de usuarios, sistema de noticias, programación de citaciones y mucho más. Todo desarrollado con las mejores prácticas de PHP.', CURDATE(), 1, 'Exploración completa de características del sistema.', NOW(), NOW())
ON DUPLICATE KEY UPDATE titulo = VALUES(titulo);

-- Cita de ejemplo
INSERT INTO citas (idCita, idUser, fecha_cita, motivo_cita, created_at, updated_at) VALUES
(1, 2, DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Consulta sobre servicios de desarrollo web - presupuesto para web 2.0', NOW(), NOW())
ON DUPLICATE KEY UPDATE motivo_cita = VALUES(motivo_cita);
-- Contraseña: password

-- Insertar algunas noticias de ejemplo
INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES
('Bienvenidos a InnovaCode', 'https://via.placeholder.com/800x400?text=Bienvenidos', 'Esta es la primera noticia de nuestro sitio web. Aquí encontrarás las últimas novedades sobre tecnología y desarrollo.', CURDATE(), 1),
('Nuevas tecnologías 2025', 'https://via.placeholder.com/800x400?text=Tecnologias+2025', 'Las tecnologías emergentes que marcarán el 2025. Descubre las últimas tendencias en desarrollo web y programación.', CURDATE(), 1),
('Curso de PHP avanzado', 'https://via.placeholder.com/800x400?text=PHP+Avanzado', 'Aprende PHP desde cero hasta nivel avanzado con nuestros cursos especializados.', CURDATE(), 1);