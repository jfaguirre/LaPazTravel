<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/principal.css') }}">
    <!-- Título dinámico con valor por defecto -->
    <title>@yield('titulo', 'La Paz Travel')</title>
    <!-- Stack para CSS adicional por vista -->
    @stack('styles')
</head>
<body>
    <!-- NAVBAR -->
    <header >
        <div >
            <h1>logo La Paz Travel</h1>
            <nav>
                <a href="/" ">Inicio</a>
                <a href="/about" >Acerca de</a>
                <a href="/contact" >Contacto</a>
                <a href="/formulario">probar formulario</a>
                <a href="/mapa">ver mapa</a>
            </nav>
        </div>
    </header>
    <!-- CUERPO PRINCIPAL para la mayoria del contenido de las vistas -->
    <main >
        <!-- CONTENEDOR principal -->
        <!-- Sección de contenido principal -->
        @yield('contenedor_principal')
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