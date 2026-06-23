@extends('layouts.plantillaBase')

@section('titulo', 'Mapa - La Paz Travel')

@section('contenedor_principal')
    <h2>Mapa de La Paz Travel</h2>
    <p>Explora los mejores destinos turísticos, encuentra ofertas exclusivas y planifica tu próxima aventura con nosotros.</p>
    <br>
    <a class="mapa" href="/"><img src="../images/la-paz-este.png" alt="La paz este"></a>
    <a class="mapa" href="/"><img src="../images/la-paz-centro.jpg" alt="La paz centro"></a>
    <a class="mapa" href="/"><img src="../images/la-paz-oeste.png" alt="La paz oeste"></a>
@endsection
