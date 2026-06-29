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
            'resources/js/menu.js'
        ])

    </head>
    <body>
        <!-- NAVBAR -->
        @include('layouts._partials.menu')
        <!-- CUERPO PRINCIPAL para la mayoria del contenido de las vistas -->
        <main >
            <!-- CONTENEDOR principal -->
            @yield('contenedor_principal')
        </main>
        <!-- FOOTER (común a todas las vistas)         -->
        <footer >
            <p>&copy; {{ date('Y') }} La Paz Travel. Todos los derechos reservados.</p>
        </footer>


        <!-- Stack para scripts adicionales por vista -->
        @stack('scripts')

    </body>
</html>
