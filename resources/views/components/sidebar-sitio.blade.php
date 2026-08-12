@php
    $currentSitio = $sitio ?? null;
    if (!$currentSitio && auth()->check()) {
        $sitioId = session('id_sitio');
        if ($sitioId) {
            $currentSitio = \App\Models\Sitio::find($sitioId);
        } else {
            $currentSitio = \App\Models\Sitio::where('id_user', auth()->id())->first();
        }
    }
    $nombreSitio = $currentSitio ? $currentSitio->nombre : 'Mi Sitio';
    $inicialSitio = $currentSitio ? mb_substr($currentSitio->nombre, 0, 1) : 'S';
    $rolUsuario = auth()->check() ? 'Propietario' : 'Invitado';
@endphp

<aside class="sidebar" id="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar__header">
        <div class="sidebar__avatar">
            {{ $inicialSitio }}
        </div>
        <div class="sidebar__user-info">
            <div class="sidebar__user-name" title="{{ $nombreSitio }}">{{ $nombreSitio }}</div>
            <div class="sidebar__user-role">{{ $rolUsuario }}</div>
        </div>
    </div>

    <!-- Sidebar Nav -->
    <nav class="sidebar__nav">
        <div class="sidebar__nav-label">Principal</div>

        <a href="{{ route('dashboard.sitio.inicio') }}" class="sidebar__nav-item {{ request()->routeIs('dashboard.sitio.inicio') ? 'active' : '' }}">
            <i class="bi bi-house-fill sidebar__nav-icon"></i>
            Panel de Control
        </a>

        <a href="{{ route('dashboard.sitio.inicio') }}" class="sidebar__nav-item {{ request()->routeIs('sitio.edit') ? 'active' : '' }}">
            <i class="bi bi-info-circle-fill sidebar__nav-icon"></i>
            Información del Sitio
        </a>

        <a href="{{ route('ubicacion.inicio') }}" class="sidebar__nav-item {{ request()->routeIs('perfil.ubicacion.agregar') ? 'active' : '' }}">
            <i class="bi bi-geo-alt-fill sidebar__nav-icon"></i>
            Ubicación geográfica
        </a>

        <a href="{{ route('categoria.inicio') }}" class="sidebar__nav-item {{ request()->routeIs('perfil.categoria.agregar') ? 'active' : '' }}">
            <i class="bi bi-tags-fill sidebar__nav-icon"></i>
            Categorías
        </a>

        <a href="{{ route('regla.inicio') }}" class="sidebar__nav-item {{ request()->routeIs('regla.inicio') ? 'active' : '' }}">
            <i class="bi bi-shield-fill-check sidebar__nav-icon"></i>
            Reglas y Normas
        </a>

        <a href="{{ route('perfil.servicio.agregar') }}" class="sidebar__nav-item {{ request()->routeIs('perfil.servicio.agregar') ? 'active' : '' }}">
            <i class="bi bi-grid-fill sidebar__nav-icon"></i>
            Servicios del Sitio
        </a>

        <div class="sidebar__nav-label">Sistema</div>

        <a href="{{ route('dashboard') }}" class="sidebar__nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-square-fill sidebar__nav-icon"></i>
            Mis Sitios
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar__footer">
        <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
            @csrf
        </form>
        <button class="sidebar__logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right sidebar__nav-icon"></i>
            Cerrar sesión
        </button>
    </div>
</aside>
