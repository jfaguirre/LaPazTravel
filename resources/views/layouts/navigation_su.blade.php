<aside :class="{
            'translate-x-0': open, 
            '-translate-x-full': !open,
            'md:w-64': !sidebarCollapsed,
            'md:w-20': sidebarCollapsed
       }" 
       class="fixed inset-y-0 left-0 z-50 flex flex-col h-screen bg-white text-slate-700 border-r border-blue-100 shadow-xl md:shadow-none transition-all duration-300 ease-in-out -translate-x-full md:translate-x-0 md:static md:z-auto shrink-0 select-none">
    
    <div class="h-16 flex items-center justify-between px-4 border-b border-blue-100 bg-gradient-to-r from-blue-50/80 to-white shrink-0">
        <a href="{{ route('super.dashboard') }}" class="flex items-center gap-3 overflow-hidden no-underline group">
            <div class="p-2 bg-blue-600 rounded-xl text-white shadow-md shadow-blue-600/20 group-hover:bg-blue-700 transition-colors shrink-0">
                <x-application-logo class="h-6 w-auto fill-current text-white" />
            </div>
            <div x-show="!sidebarCollapsed" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-2"
                 class="flex flex-col">
                <span class="font-black text-blue-950 text-sm tracking-tight leading-none">SUPERVISOR</span>
                <span class="text-[9px] font-extrabold text-blue-600 tracking-widest mt-0.5">EL SALVADOR</span>
            </div>
        </a>

        <button @click="sidebarCollapsed = !sidebarCollapsed" 
                type="button"
                class="hidden md:flex items-center justify-center p-1.5 rounded-lg text-slate-400 hover:text-blue-700 hover:bg-blue-100/60 transition-colors">
            <svg :class="{'rotate-180': sidebarCollapsed}" class="w-5 h-5 transition-transform duration-300 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>

        <button @click="open = false" type="button" class="md:hidden p-1.5 rounded-lg text-slate-400 hover:text-blue-700 hover:bg-blue-100/60 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="shrink-0 p-2.5 my-3 mx-2 rounded-2xl bg-blue-50/50 border border-blue-100/80 flex items-center transition-all duration-300"
         :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-start px-3 gap-3'">
        
        <div class="relative shrink-0 flex items-center justify-center">
            <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-blue-600/20">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <span class="absolute -top-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-500 ring-2 ring-white"></span>
        </div>
        
        <div x-show="!sidebarCollapsed" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-x-2"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="overflow-hidden">
            <p class="text-xs font-bold text-slate-800 truncate leading-tight">{{ Auth::user()->name }}</p>
            <span class="inline-flex items-center gap-1 text-[10px] text-blue-600 font-semibold truncate">
                Super Admin
            </span>
        </div>
    </div>

    <nav class="flex-1 px-3 py-1 space-y-1 overflow-y-auto min-h-0">
        <div x-show="!sidebarCollapsed" class="px-3 py-1.5 text-[10px] font-bold text-blue-900/40 uppercase tracking-wider">
            Navegación
        </div>

        <a href="{{ route('super.dashboard') }}" 
           :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-start px-3'"
           class="group py-2.5 flex items-center gap-3 rounded-xl text-xs font-semibold transition-all duration-200 no-underline {{ request()->routeIs('super.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}"
           :title="sidebarCollapsed ? '{{ __('Dashboard') }}' : ''">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('super.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Dashboard') }}</span>
        </a>

        <a href="{{ route('super.sitio.index') }}" 
           :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-start px-3'"
           class="group py-2.5 flex items-center gap-3 rounded-xl text-xs font-semibold transition-all duration-200 no-underline {{ request()->routeIs('super.sitio.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}"
           :title="sidebarCollapsed ? '{{ __('Control de sitio') }}' : ''">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('super.sitio.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Control de sitio') }}</span>
        </a>

        <a href="{{ route('super.usuario.index') }}" 
           :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-start px-3'"
           class="group py-2.5 flex items-center gap-3 rounded-xl text-xs font-semibold transition-all duration-200 no-underline {{ request()->routeIs('super.usuario.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}"
           :title="sidebarCollapsed ? '{{ __('Control de usuario') }}' : ''">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('super.usuario.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Control de usuario') }}</span>
        </a>

        <a href="{{ route('super.servicio.create') }}" 
           :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-start px-3'"
           class="group py-2.5 flex items-center gap-3 rounded-xl text-xs font-semibold transition-all duration-200 no-underline {{ request()->routeIs('super.servicios.*') || request()->routeIs('super.servicio.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}"
           :title="sidebarCollapsed ? '{{ __('Servicios') }}' : ''">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('super.servicios.*') || request()->routeIs('super.servicio.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Servicios') }}</span>
        </a>

        <a href="{{ route('super.categoria.create') }}" 
           :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-start px-3'"
           class="group py-2.5 flex items-center gap-3 rounded-xl text-xs font-semibold transition-all duration-200 no-underline {{ request()->routeIs('super.categorias.*') || request()->routeIs('super.categoria.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}"
           :title="sidebarCollapsed ? '{{ __('Categorías') }}' : ''">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('super.categorias.*') || request()->routeIs('super.categoria.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Categorías') }}</span>
        </a>

        <a href="{{ route('super.regla.create') }}" 
           :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-start px-3'"
           class="group py-2.5 flex items-center gap-3 rounded-xl text-xs font-semibold transition-all duration-200 no-underline {{ request()->routeIs('super.reglas.*') || request()->routeIs('super.regla.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}"
           :title="sidebarCollapsed ? '{{ __('Reglas') }}' : ''">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('super.reglas.*') || request()->routeIs('super.regla.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Reglas') }}</span>
        </a>

        <a href="#" 
           :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-3'"
           class="group py-2.5 flex items-center gap-3 rounded-xl text-xs font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 no-underline"
           :title="sidebarCollapsed ? '{{ __('Notificaciones') }}' : ''">
            <div class="flex items-center gap-3 truncate">
                <div class="relative shrink-0">
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110 text-slate-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
                    </svg>
                    <span x-show="sidebarCollapsed" class="absolute -top-0.5 -right-0.5 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                </div>
                <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Notificaciones') }}</span>
            </div>
            
            <span x-show="!sidebarCollapsed" 
                  class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-100 text-blue-700 transition-colors">
                3
            </span>
        </a>
    </nav>

    <div class="p-3 border-t border-blue-100 space-y-1 bg-white shrink-0 relative z-10">
        <a href="{{ route('profile.edit') }}" 
           :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-start px-3'"
           class="flex items-center gap-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition-colors no-underline"
           :title="sidebarCollapsed ? '{{ __('Mi Perfil') }}' : ''">
            <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Mi Perfil') }}</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-start px-3'"
                    class="w-full flex items-center gap-3 py-2 rounded-xl text-xs font-semibold text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors"
                    :title="sidebarCollapsed ? '{{ __('Cerrar Sesión') }}' : ''">
                <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" class="truncate">{{ __('Cerrar Sesión') }}</span>
            </button>
        </form>
    </div>
</aside>