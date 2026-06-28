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

        {{-- Scripts --}}
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])

    </head>
    <body>    
        
        {{-- menu --}}
        @include('layouts.menu-guest')

        {{-- header --}}
        <header ></header>
        
        {{-- main --}}
        <main >           
            @yield('contenido')
            {{ $slot ?? '' }}
        </main>
        
        {{-- footer --}}
        <footer >
            <p>&copy; {{ date('Y') }} La Paz Travel. Todos los derechos reservados.</p>
        </footer>
                  
        @stack('scripts')

    </body>
</html>

