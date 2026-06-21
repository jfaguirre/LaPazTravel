<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Título dinámico con valor por defecto -->
    <title>@yield('titulo', 'Formulario - La Paz Travel')</title>
    
    <!-- CSS principal -->
    <link rel="stylesheet" href="{{ asset('../css/formularios.css') }}">
    
    <!-- Stack para CSS adicional por vista -->
    @stack('styles')
</head>
<body>
    </header>
    <!-- CUERPO PRINCIPAL para la mayoria del contenido de las vistas -->
    <main >
        <!-- CONTENEDOR principal -->
        <section>
            
            <!-- Sección de contenido principal -->
            @yield('contenedor_formulario')
            
        </section>
    </main>
    <!-- FOOTER (común a todas las vistas)         -->
    <footer >
        <p>&copy; {{ date('Y') }} La Paz Travel. Todos los derechos reservados.</p>
    </footer>
    
    <!-- Scripts principales -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Stack para scripts adicionales por vista -->
    @stack('scripts')
    
</body>
</html>