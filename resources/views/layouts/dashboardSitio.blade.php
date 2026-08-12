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
            'resources/css/main.css',
            'resources/css/dashboard_sitio.css',
            'resources/css/sidebar_sitio.css',
        ])

        @stack('styles')

    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <!-- Header -->
            <header class="header">
                <button class="header__menu-btn" id="menu-btn" aria-label="Menu de navegación">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header__logo">
                    La Paz <span>Travel</span>
                </div>
                <div class="header__avatar" title="{{ auth()->user()->name }} {{ auth()->user()->lastName }}">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </header>

            <!-- Overlay -->
            <div class="overlay" id="overlay"></div>

            <!-- Sidebar -->
            @include('components.sidebar-sitio')

            <!-- Main Content Area -->
            <div class="main-content">
                @yield('contenido')
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const menuBtn = document.getElementById('menu-btn');
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');

                if (menuBtn && sidebar && overlay) {
                    menuBtn.addEventListener('click', function() {
                        menuBtn.classList.toggle('active');
                        sidebar.classList.toggle('active');
                        overlay.classList.toggle('active');
                    });

                    overlay.addEventListener('click', function() {
                        menuBtn.classList.remove('active');
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    });
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>



