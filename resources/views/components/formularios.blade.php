<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Formulario - La Paz Travel')</title>
    
    <!-- Scripts & Styles -->
    @vite([
        'resources/css/app.css',
        'resources/css/main.css',
        'resources/css/inicio.css',
        'resources/js/app.js'
    ])
    
    <!-- Stack para CSS adicional por vista -->
    @stack('styles')
</head>
<body class="form-body">
    <!-- CUERPO PRINCIPAL para la mayoria del contenido de las vistas -->
    <main class="form-main">
        <!-- CONTENEDOR principal -->
        <section class="box-form">
            <!-- Sección de contenido principal -->
            @yield('contenedor_formulario')
        </section>
    </main>
    
    <!-- Stack para scripts adicionales por vista -->
    @stack('scripts')
</body>
</html>