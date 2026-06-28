
@if (Route::has('login'))
    <nav class="flex items-center justify-end gap-4">
        @auth
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Log in</a>           
        @endauth
    </nav>
@endif

<h1>Aqui tu contenido de la pagina de inicio</h1>


