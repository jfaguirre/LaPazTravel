<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200/80 shadow-sm transition-all">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('su.dashboard') }}" class="group relative flex items-center gap-2 transition-transform duration-200 hover:scale-105">
                        <x-application-logo class="relative block h-9 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <!-- Navigation Links (Hover: Píldora Lateral Brillante + Desplazamiento de Icono) -->
                <div class="hidden sm:flex sm:items-center sm:gap-3">
                    <!-- Dashboard -->
                    <a href="{{ route('su.dashboard') }}" 
                       class="relative group px-3.5 py-2 inline-flex items-center gap-2.5 text-sm font-semibold transition-all duration-200 no-underline {{ request()->routeIs('su.dashboard') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                        <!-- Indicador Lateral Brillante -->
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-full bg-indigo-600 transition-all duration-200 shadow-[0_0_8px_rgba(79,70,229,0.5)] {{ request()->routeIs('su.dashboard') ? 'opacity-100 scale-100' : 'opacity-0 scale-50 group-hover:opacity-100 group-hover:scale-100' }}"></span>

                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5 {{ request()->routeIs('su.dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>{{ __('Dashboard') }}</span>
                    </a>

                    <!-- Control de Sitios -->
                    <a href="{{ route('su.sitios.index') }}" 
                       class="relative group px-3.5 py-2 inline-flex items-center gap-2.5 text-sm font-semibold transition-all duration-200 no-underline {{ request()->routeIs('su.sitios.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                        <!-- Indicador Lateral Brillante -->
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-full bg-indigo-600 transition-all duration-200 shadow-[0_0_8px_rgba(79,70,229,0.5)] {{ request()->routeIs('su.sitios.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-50 group-hover:opacity-100 group-hover:scale-100' }}"></span>

                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5 {{ request()->routeIs('su.sitios.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                        <span>{{ __('Control de Sitios') }}</span>
                    </a>

                    <!-- Control de Usuarios -->
                    <a href="{{ route('su.usuarios.index') }}" 
                       class="relative group px-3.5 py-2 inline-flex items-center gap-2.5 text-sm font-semibold transition-all duration-200 no-underline {{ request()->routeIs('su.usuarios.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                        <!-- Indicador Lateral Brillante -->
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-full bg-indigo-600 transition-all duration-200 shadow-[0_0_8px_rgba(79,70,229,0.5)] {{ request()->routeIs('su.usuarios.*') ? 'opacity-100 scale-100' : 'opacity-0 scale-50 group-hover:opacity-100 group-hover:scale-100' }}"></span>

                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5 {{ request()->routeIs('su.usuarios.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>{{ __('Control de Usuarios') }}</span>
                    </a>
                </div>
            </div>

            <!-- Settings & Profile -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <!-- Badge de Rol: Super Admin (Color Rose/Fuchsia) -->
                <span class="inline-flex items-center gap-x-1.5 rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-600/20 shadow-xs">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                    Super Admin
                </span>

                <div class="h-5 w-px bg-gray-200"></div>

                <!-- Dropdown de Usuario -->
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="group flex items-center gap-3 p-1.5 rounded-full hover:bg-gray-100/80 transition duration-150 focus:outline-none">
                            <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-sm ring-2 ring-white group-hover:ring-indigo-100 transition-all">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>

                            <div class="text-left hidden md:block">
                                <div class="text-xs font-semibold text-gray-800 leading-tight group-hover:text-indigo-600 transition-colors">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-gray-400 leading-tight">Administrador</div>
                            </div>

                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Header del Dropdown -->
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                            <p class="text-xs text-gray-500">Conectado como</p>
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 no-underline">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Mi Perfil') }}
                            </x-dropdown-link>
                        </div>

                        <div class="border-t border-gray-100 my-1"></div>

                        <!-- Logout Option -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" 
                                    class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50/80 transition-colors no-underline"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 bg-white shadow-lg">
        <div class="p-3 space-y-1">
            <a href="{{ route('su.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium no-underline {{ request()->routeIs('su.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                {{ __('Dashboard') }}
            </a>

            <a href="{{ route('su.sitios.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium no-underline {{ request()->routeIs('su.sitios.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
                {{ __('Control de Sitios') }}
            </a>

            <a href="{{ route('su.usuarios.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium no-underline {{ request()->routeIs('su.usuarios.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                {{ __('Control de Usuarios') }}
            </a>
        </div>

        <!-- Opciones Móvil -->
        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-9 w-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <div class="font-semibold text-sm text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1 pt-2 border-t border-gray-200/60">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-2 rounded-lg py-2 no-underline">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="flex items-center gap-2 rounded-lg py-2 text-red-600 no-underline"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>