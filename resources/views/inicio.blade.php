{{-- use app\Models\Publicacion --}}

@extends('layouts.guest')

@section('title', 'inicio - La Paz Travel')

@section('contenido')
    <h1>Bienvenido a La Paz Travel</h1>
    <br>
    <div class="box">
        <!-- un mensaje cualquiera -->
        <p class ="box-content">
            parrafo de ejemplo de la paz, una tierra rica en cultura y naturaleza....
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
    @guest
    <div class="cta-register">
        <div class="cta-content">
            <h3>¿Listo para explorar la belleza de La Paz?</h3>
            <p>Regístrate hoy para acceder a guías personalizadas, guardar tus destinos favoritos y planificar el viaje perfecto.</p>
            <a href="{{ route('register') }}" class="btn-cta">Crear una cuenta gratis</a>
        </div>
    </div>
    <br>
    @endguest
    <!-- Mapa interactivo -->
    <!-- Panel de información -->
    <div class="info-panel" id="infoPanel">
        <div>
            <h3>Explora el Mapa</h3>
            <p>Pasa el cursor sobre una región para ver información</p>
        </div>
    </div>

    <!-- Tooltip  de momento es mas un indicador visual que otra cosa-->
    <div class="tooltip" id="tooltip">
        <div class="region-name" id="tooltipName"></div>
        <div class="region-info" id="tooltipInfo"></div>
    </div>
    
    <!-- Leyenda -->
    <div class="legend">
        <div class="legend-item" data-region="oeste">
            <div class="legend-color oeste"></div>
            <span class="legend-label">Oeste</span>
        </div>
        <div class="legend-item" data-region="centro">
            <div class="legend-color centro"></div>
            <span class="legend-label">Centro</span>
        </div>
        <div class="legend-item" data-region="este">
            <div class="legend-color este"></div>
            <span class="legend-label">Este</span>
        </div>
    </div>
    <div class="map-wrapper">
        <div class="map-container">
            <!-- Región Oeste -->
            <div class="region region-oeste" data-name="Región Oeste" data-info="Insertar informacion caracteristica de La Paz Oeste">
                <img src="{{ asset('..\assets\images\mapa-la-paz-oeste.png') }}" alt="Región Oeste">
            </div>

            <!-- Región Centro -->
            <div class="region region-centro" data-name="Región Centro" data-info="Insertar informacion caracteristica de La Paz Centro">
                <img src="{{ asset('..\assets\images\mapa-la-paz-centro.png') }}" alt="Región Centro">
            </div>

            <!-- Región Este -->
            <div class="region region-este" data-name="Región Este" data-info="Insertar informacion caracteristica de La Paz Este">
                <img src="{{ asset('..\assets\images\mapa-la-paz-este.png') }}" alt="Región Este">
            </div>
        </div>
    </div>
    <!-- Tarjetas de lugares turísticos -->
    <!--  la clase deck contendra las tarjetas que tendran que ser 
        editadas para que muestren la información correctamente segun lo establecido en la base de datos -->
    <h2 style="color: var(--primario);">conoce los sitios turisticos de la paz</h2>
    <div class="muestras">
        <div class="distritos">
            <div class="distrito">
                <a class="solo" href="#">
                    <div class="distrito-content">
                        <p>todos</p>
                    </div>
                </a>
            </div>
            <div class="distrito">
                <a class="solo" href="{{ route('la-paz-este') }}">
                    <div class="distrito-content">
                        <p>La paz este</p>
                    </div>
                </a>
            </div>
            <div class="distrito">
                <a class="solo" href="{{ route('la-paz-centro') }}">
                    <div class="distrito-content">
                        <p>La paz centro</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="deck">
            @foreach($sitiosP as $s)
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
            @endforeach
        </div>
    </div>



@endsection



