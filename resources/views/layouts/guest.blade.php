<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">            
        
        <!-- Bootstrap Icon (SOLO los iconos, vía CDN está bien) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        
        <!-- Scripts (esto carga Bootstrap CSS + JS + tus CSS) -->
        @vite([
            'resources/css/main.css',
            'resources/css/inicio.css',            
            'resources/js/guest.js',
        ])
        @stack('styles')
        <title> @yield('title')</title>
    </head>
    <body>
        <!-- el navbar esta en un archivo separado -->
        @include('layouts._partials.menu')
        
        <main>        
            @yield('contenido')
        </main>
        <footer>
            <p>&copy; {{ date('Y') }} La Paz Travel. Todos los derechos reservados.</p>
        </footer>
        @stack('scripts')
    </body>
</html>