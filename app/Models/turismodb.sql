CREATE DATABASE turismodb
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE turismodb;

-- ROLES
CREATE TABLE roles(
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol VARCHAR(50) NOT NULL UNIQUE
);

-- PERMISOS
CREATE TABLE permisos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    permiso VARCHAR(100) NOT NULL UNIQUE
);

-- TABLA AUX 
CREATE TABLE rol_permiso(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL,
    id_permiso INT NOT NULL,
    UNIQUE(id_rol,id_permiso),
    FOREIGN KEY(id_rol) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY(id_permiso) REFERENCES permisos(id) ON DELETE CASCADE
);

-- USUARIOS
CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) NULL,
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    ultimo_login TIMESTAMP NULL,
    estado ENUM('ACTIVO','INACTIVO','SUSPENDIDO') NOT NULL DEFAULT 'ACTIVO',
    id_rol INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(id_rol) REFERENCES roles(id)
);

-- DEPARTAMENTOS
CREATE TABLE departamentos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    departamento VARCHAR(100) NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT TRUE
);

-- DISTRITOS
CREATE TABLE distritos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    distrito VARCHAR(100) NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT TRUE,
    id_departamento INT NOT NULL,
    FOREIGN KEY(id_departamento) REFERENCES departamentos(id)
);

-- MUNICIPIOS
CREATE TABLE municipios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    municipio VARCHAR(100) NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT TRUE,
    id_distrito INT NOT NULL,
    FOREIGN KEY(id_distrito) REFERENCES distritos(id)
);

-- SITIOS
CREATE TABLE sitios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    descripcion_corta TEXT,
    visitas INT NOT NULL DEFAULT 0,
    estado ENUM('PENDIENTE','APROBADO','RECHAZADO','SUSPENDIDO') NOT NULL DEFAULT 'PENDIENTE',
    id_usuario INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(id_usuario) REFERENCES usuarios(id)
);

-- PERFIL SITIOS
CREATE TABLE perfil_sitio(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sitio INT NOT NULL UNIQUE,
    direccion TEXT,
    latitud DECIMAL(10,8),
    longitud DECIMAL(11,8),
    telefono VARCHAR(30),
    correo VARCHAR(120),
    sitio_web VARCHAR(255),
    facebook VARCHAR(255),
    instagram VARCHAR(255),
    tiktok VARCHAR(255),
    youtube VARCHAR(255),
    horarios JSON,
    precio_entrada DECIMAL(8,2),
    datos_json JSON,
    id_departamento INT,
    id_distrito INT,
    id_municipio INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(id_sitio) REFERENCES sitios(id) ON DELETE CASCADE,
    FOREIGN KEY(id_departamento) REFERENCES departamentos(id),
    FOREIGN KEY(id_distrito) REFERENCES distritos(id),
    FOREIGN KEY(id_municipio) REFERENCES municipios(id)
);

-- CATEGORIAS
CREATE TABLE categorias(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    icono VARCHAR(100),
    color VARCHAR(20)
);


-- SITIO CATEGORIA
CREATE TABLE sitio_categoria(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sitio INT NOT NULL,
    id_categoria INT NOT NULL,
    UNIQUE(id_sitio,id_categoria),
    FOREIGN KEY(id_sitio) REFERENCES sitios(id) ON DELETE CASCADE,
    FOREIGN KEY(id_categoria) REFERENCES categorias(id)
);

-- PUBLICACIONES
CREATE TABLE publicaciones(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    contenido LONGTEXT NOT NULL,
    imagen_portada VARCHAR(255),
    estado ENUM('BORRADOR','PUBLICADO','OCULTO') NOT NULL DEFAULT 'BORRADOR',
    id_sitio INT NOT NULL,
    id_usuario INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(id_sitio) REFERENCES sitios(id) ON DELETE CASCADE,
    FOREIGN KEY(id_usuario) REFERENCES usuarios(id)
);

-- IMAGENES DEL SITIO
CREATE TABLE imagenes_sitio(
    id INT AUTO_INCREMENT PRIMARY KEY,
    ruta VARCHAR(255) NOT NULL,
    titulo VARCHAR(150),
    principal BOOLEAN DEFAULT FALSE,
    orden INT DEFAULT 1,
    id_sitio INT NOT NULL,
    FOREIGN KEY(id_sitio) REFERENCES sitios(id) ON DELETE CASCADE
);

-- IMAGENES PUBLICACIONES
CREATE TABLE imagenes_publicacion(
    id INT AUTO_INCREMENT PRIMARY KEY,
    ruta VARCHAR(255) NOT NULL,
    titulo VARCHAR(150),
    orden INT DEFAULT 1,
    id_publicacion INT NOT NULL,
    FOREIGN KEY(id_publicacion) REFERENCES publicaciones(id) ON DELETE CASCADE
);
