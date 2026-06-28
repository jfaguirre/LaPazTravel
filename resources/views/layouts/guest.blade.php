<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('assets/css/principal.css') }}">
    
        <title>
            @hasSection('title')
                @yield('title')
            @else
                @yield('titulo', 'La Paz Travel')
            @endif
        </title>
        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])

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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
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