<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">            
        <title> @yield('title')</title>
        
        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/main.css',
            'resources/css/inicio.css',            
            'resources/js/menu.js'
        ])

    </head>
    <body>

        @include('layouts._partials.menu')
        
        <main >        
            @yield('contenido')
        </main>
        

        <footer >
            <p>&copy; {{ date('Y') }} La Paz Travel. Todos los derechos reservados.</p>
        </footer>
        
    </body>
</html>
