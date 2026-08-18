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

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @stack('styles')        
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased overflow-hidden">
        
        <!-- Contenedor Flex Principal con alto de pantalla estricto (h-screen) -->
        <div x-data="{ 
                open: false, 
                sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' 
             }" 
             x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value))"
             class="h-screen w-screen flex overflow-hidden">
            
            <!-- Backdrop Móvil -->
            <div x-show="open" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="open = false" 
                 class="fixed inset-0 z-40 bg-blue-950/40 backdrop-blur-xs md:hidden"
                 style="display: none;"></div>

            <!-- Navegación lateral (Sidebar) -->
            @include('layouts.navigation_su')

            <!-- Contenido Principal Derecha (Con scroll independiente para el contenido) -->
            <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
                
                <!-- Navbar superior exclusivo para móviles -->
                <header class="md:hidden flex items-center justify-between h-16 px-4 bg-blue-600 text-white shadow-md shrink-0">
                    <button @click="open = true" type="button" class="p-2 rounded-lg text-white hover:bg-blue-700">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="font-bold text-white text-sm tracking-wider uppercase">ADMIN PANEL</span>
                    <div class="w-6"></div>
                </header>

                <!-- Contenido de la vista -->
                <main class="flex-grow p-4 sm:p-6 lg:p-8">
                    @yield('contenido')
                </main>
            </div>
        </div>

        @stack('scripts')
        <!-- SweetAlert2 CDN y Scripts globales -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>