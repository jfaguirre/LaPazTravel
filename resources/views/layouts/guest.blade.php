<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('assets/css/principal.css') }}">
    <!-- Título dinámico con valor por defecto -->
        <title>
            @yield('titulo', 'La Paz Travel')
        </title>
    </head>
    <body>
        <!-- NAVBAR -->
        <header >
            <div >
                <h1>logo La Paz Travel</h1>
                <div class ="burgerMenu">☰</div>
                <nav class = "menu" id="menu">
                    <a class="item" href="{{ route('index')}}" ">Inicio</a>
                    <a class="item" href="{{ route('about')}}" >Acerca de</a>
                    <a class="item" href="{{ route('index')}}" >Contacto</a>
                    <a class="item" href="{{ route('formularioPrueba')}}">probar formulario</a>
                    <a class="item" href="{{ route('index')}}">ver mapa</a><!-- no funciona aun -->
                </nav>
            </div>
        </header>
        <!-- CUERPO PRINCIPAL -->
        <main >
            <!-- CONTENEDOR principal -->
            <!-- Sección de contenido principal -->
            @yield('contenedor_principal')

        </main>
        <!-- FOOTER   -->
        <footer >
            <p>&copy; {{ date('Y') }} La Paz Travel. Todos los derechos reservados.</p>
        </footer>

        
        <!-- Scripts principal  -->
        @vite(['resources/js/menu.js'])
        <!-- Stack para scripts adicionales por vista -->
        @stack('scripts')

        </body>
</html>
