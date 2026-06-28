 {{--Menu guest --}}
<nav class="menu-guest">
    <section class="logo">
        <img src="" alt="La Paz Travel">
        <span>La Paz Travel</span>
    </section>
    <section class="menu">
        <a href="/">Inicio</a>
        <a href="#" >Acerca de</a>
        <a href="#" >Contacto</a>
        <a href="{{ route('formulario') }}">probar formulario</a>
        <a href="{{ route('mapa') }}">ver mapa</a>
        @if (Route::has('login'))    
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>           
            @endauth        
        @endif
    </section>    
</nav>            