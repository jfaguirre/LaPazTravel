<img src="https://www.itca.edu.sv/wp-content/uploads/2025/01/LogoITCA_Web.png" width="300">

<h1>Sistema de turismo La Paz</h1>
<p>Sistema de turismo originario del Departamento de La Paz; dedicado al turismo y proyeccion cultural de la región.</p>


<h3>Instalación de recursos para el proyecto</h3>

### 1. Instala composer y node js en tu PC:

```bash
https://getcomposer.org/
```

```bash
https://nodejs.org/es/download

```

### 2. Clona el repositorio

```bash
git clone https://github.com/jfaguirre/PazTravel.git
```

### 3. Entra al directorio del proyecto local desde la termina:

```bash
cd LaPazTravel
```

### 4. Instala las dependencias de PHP

```bash
composer install
```

### 5. Crea el archivo de configuración

```bash
copy .env.example .env
```

### 6. Configura las variables de entorno

Abrir el archivo `.env` y configurar la conexión a la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lapaz_db
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Generara la clave de la aplicación

```bash
php artisan key:generate
```

### 8. Ejecuta las migraciones

```bash
php artisan migrate
```

### 9. Instala las dependencias de JavaScript

```bash
npm install
```

### 10. Compila los recursos (modo desarrollo):

```bash
npm run dev
```

### 11. Inicia el servidor

```bash
php artisan serve
```

## Recursos instalados

Instalación de Laravel/breeze para la implementación del sistema completo de autenticación de usuarios

```bash
composer require laravel/breeze --dev
```

```bash
php artisan breeze:install
```



