<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Panel de Administración')</title>
                
        <!-- Scripts y Estilos Vite -->
        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/css/main.css'
        ])

        <!-- Bootstrap Icons (Garantiza la carga de íconos bi-*) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @stack('styles')        
        
    </head>
    <body class="bg-light text-dark min-vh-100 d-flex flex-column">
        
        <!-- Navegación condicional por roles -->
        @include('layouts.navigation_su')

        <!-- Contenido de las páginas -->
        <main class="flex-grow-1">
            @yield('contenido')
        </main>

        @stack('scripts')
        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>