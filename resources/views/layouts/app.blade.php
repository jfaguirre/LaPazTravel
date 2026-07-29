<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
                
        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/css/main.css'
        ])

        @stack('styles')        
        
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <!-- Navegación condicional por roles -->
            @if(Auth::check() && Auth::user()->hasRole('su'))
                @include('layouts.navigation_su')
            @else
                @include('layouts.navigation')
            @endif
           
            <!-- Contenido de las paginas -->
            <main>
                @yield('contenido')
            </main>

        </div>
    
    @stack('scripts')
    </body>
</html>