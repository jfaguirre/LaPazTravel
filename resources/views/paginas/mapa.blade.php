@extends('layouts.plantillaBase')

@section('titulo', 'Mapa - La Paz Travel')

@section('contenedor_principal')
    <h2>Mapa de La Paz Travel</h2>
    <p>Explora los mejores destinos turísticos, encuentra ofertas exclusivas y planifica tu próxima aventura con nosotros.</p>
    <br>
    <div class="mapa-container">
        <a class="mapa" href="/"><img src="{{ asset('assets/images/la-paz-este.png') }}" alt="La paz este"></a>
        <a class="mapa" href="/"><img src="{{ asset('assets/images/la-paz-centro.jpg') }}" alt="La paz centro"></a>
        <a class="mapa" href="/"><img src="{{ asset('assets/images/la-paz-oeste.png') }}" alt="La paz oeste"></a>
    </div>
    <p>Haz clic en las imágenes para obtener más información sobre cada área de La Paz y descubrir qué hace que cada una sea única.</p>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/mapa.css') }}">
@endpush