<nav class="navbar navbar-expand-lg navbar-dark" 

    style="background-color: var(--primario-claro);">
    <div class="container-fluid">
        
        <!-- Logo / Marca -->
        <a class="navbar-brand fw-bold" href="{{ route('inicio') }}">
            La Paz Travel
        </a>

        
        <!-- Botón hamburguesa -->
        <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarPrincipal" 
                aria-controls="navbarPrincipal" 
                aria-expanded="false" 
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido colapsable -->
        <div class="collapse navbar-collapse" id="navbarPrincipal">
            
            <!-- Menú -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}" 
                    href="{{ route('inicio') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('la-paz-centro') ? 'active' : '' }}" 
                    href="{{ route('la-paz-centro') }}">La Paz Centro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('la-paz-este') ? 'active' : '' }}" 
                    href="{{ route('la-paz-este') }}">La Paz Este</a>
                </li>
            </ul>

            <!-- Búsqueda -->
            <form class="d-flex me-3" role="search" action="#" method="GET">
                <input class="form-control me-2" type="search" name="q"
                       placeholder="Buscar..." aria-label="Buscar">
                <button class="btn btn-outline-light" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <!-- Login / Dashboard -->
            <div class="d-flex gap-2">
                @auth
                    <a class="btn btn-light" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name ?? 'Usuario' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Mi perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-outline-light" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Log in
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>