<h1>{{ $sitio->nombre }}</h1>
<p>{{ $sitio->descripcion_corta }}</p>
<a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}"  href="{{ route('inicio') }}">Inicio</a>