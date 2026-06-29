
@if (Route::has('login'))
    <nav class="flex items-center justify-end gap-4">
        @auth
            @extends('layouts.guest')
            @section('titulo', 'principal - La Paz Travel')
            @section('contenedor_principal')
                <h2>Bienvenido a La Paz Travel</h2>
                <p>Explora los mejores destinos turísticos, encuentra ofertas exclusivas y planifica tu próxima aventura con nosotros.</p>
                <br>
                <a class="boton" href="{{ route('formularioPrueba')}}">probar formulario</a>
                <!-- <a  class="boton" href="/">ver mapa</a>--> <!-- no funciona aun -->
            @endsection
        @else      
            <p> no estas autenticado</p>  
        @endauth
    </nav>
@endif




