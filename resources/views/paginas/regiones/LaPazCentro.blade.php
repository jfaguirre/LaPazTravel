

@extends('layouts.guest')

@section('title', 'La Paz Centro - La Paz Travel')

@section('contenido')
    <h1>La paz centro</h1>
    <br>
    <div class="box">
        <!-- un mensaje cualquiera -->
        <p class ="box-content">
            PARRAFO DE DE LA PAZ CENTRO
            <br>
            El departamento de La Paz, en El Salvador, es un destino que cautiva 
            por su impresionante contraste de ecosistemas, 
            ofreciendo una experiencia turística completa para los amantes de la naturaleza. 
            Desde las rutas de ecoturismo en el Callejón del Diablo, con sus más de 10 kilómetros de senderos entre rocas, 
            ríos cristalinos y pozas naturales, hasta la serenidad del estero de Jaltepeque, donde los manglares y 
            su biodiversidad ofrecen un paisaje de ensueño. El turismo aquí se vive a través de espacios renovados 
            y accesibles, como el Parque Recreativo Costa del Sol, que con su certificación "Family Friendly" ha sido 
            transformado en un referente de turismo familiar seguro y moderno. Por otro lado, lugares como el Parque 
            Recreativo Ichanmichen, con sus piscinas naturales de aguas cristalinas y sus pozas llenas de mitología local, 
            invitan a la relajación y la conexión con las tradiciones. La Paz es, sin duda, un paraíso donde la aventura y 
            la paz se fusionan.
        </p>
    </div>
    <br>
    <!-- Tarjetas de lugares turísticos -->
    <!--  la clase deck contendra las tarjetas que tendran que ser 
        editadas para que muestren la información correctamente segun lo establecido en la base de datos -->
    <div class="muestras">
        <div class="deck">
            @foreach($sitiosP as $s)
                @if ($s->municipio->municipio == 'La Paz Centro')
                    <div class="cart">
                        <a class="solo" href="#">
                            <div class="card-content">
                                <h2>{{ $s->sitio->nombre }}</h2>
                                Ubicación:{{ $s->municipio->municipio }}, {{ $s->distrito->distrito }}
                                <br>
                                <br>
                                <p class="">
                                    {{ $s->sitio->descripcion_corta }}
                                </p>
                                
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
    

@endsection



