

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
            <div class= "cart">
                <a class="solo" href="https://www.google.com/maps/place/Parque+Recreativo+Costa+del+Sol/@13.5833333,-88.1833333,15z/data=!4m6!3m5!1s0x8f633b7e9c8f8f8f:0x8f633b7e9c8f8f8f!8m2!3d13.5833333!4d-88.1833333!16s%2Fg%2F11c5v5v5v5?entry=ttu" target="_blank">
                    
                    <div class="card-content">
                        <h2>Costa del Sol</h2>
                        <img src="{{ asset('images/costa_del_sol.jpg') }}" alt="Imagen de costa del sol"><br>
                        <p class="">La Costa del Sol, en el departamento de La Paz, 
                            se ha consolidado como un destino turístico familiar gracias a la reciente renovación de su parque recreativo, 
                            que ahora ofrece modernas piscinas, palapas frente al mar y áreas de descanso para toda la familia. 
                            Con una inversión que supera los 8 millones de dólares, el espacio ha sido transformado para brindar 
                            un ambiente seguro y ordenado, 
                            obteniendo además la certificación "Family Friendly"</p>
                    </div>
                    
                </a>
            </div>

            <div class= "cart">
                <a class="solo" href="https://www.google.com/maps/place/Parque+Recreativo+Ichanmichen/@13.5833333,-88.1833333,15z/data=!4m6!3m5!1s0x8f633b7e9c8f8f8f:0x8f633b7e9c8f8f8f!8m2!3d13.5833333!4d-88.1833333!16s%2Fg%2F11c5v5v5v5?entry=ttu" target="_blank">
                    
                    <div class="card-content">
                        <h2>ichanmichen</h2>
                        <img src="{{ asset('images/ichanmichen.jpg') }}" alt="Imagen de ichanmichen"><br>
                        <p class="">ICHANMICHEN, en el departamento de La Paz, 
                            se ha consolidado como un destino turístico familiar gracias a la reciente renovación de su parque recreativo, 
                            que ahora ofrece modernas piscinas, palapas frente al mar y áreas de descanso para toda la familia. 
                            Con una inversión que supera los 8 millones de dólares, el espacio ha sido transformado para brindar 
                            un ambiente seguro y ordenado, 
                            obteniendo además la certificación "Family Friendly"</p>
                        
                    </div>
                </a>
            </div>
            <div class= "cart">
                <a class="solo" href="https://www.google.com/maps/place/Parque+Recreativo+Ichanmichen/@13.5833333,-88.1833333,15z/data=!4m6!3m5!1s0x8f633b7e9c8f8f8f:0x8f633b7e9c8f8f8f!8m2!3d13.5833333!4d-88.1833333!16s%2Fg%2F11c5v5v5v5?entry=ttu" target="_blank">
                    
                    <div class="card-content">
                        <h2>laguna de nahualapa</h2>
                        <img src="{{ asset('images/laguna-nahualapa.jpg') }}" alt="Imagen de laguna de nahualapa"><br>
                        <p class="">LAGUNA DE NAHUALAPA, en el departamento de La Paz, 
                            se ha consolidado como un destino turístico familiar gracias a la reciente renovación de su parque recreativo, 
                            que ahora ofrece modernas piscinas, palapas frente al mar y áreas de descanso para toda la familia. 
                            Con una inversión que supera los 8 millones de dólares, el espacio ha sido transformado para brindar 
                            un ambiente seguro y ordenado, 
                            obteniendo además la certificación "Family Friendly"</p>
                        
                    </div>
                </a>
            </div>
        </div>
    </div>
<!--  -->
    <h2>Guía de Iconos</h2>
    <div class="guia-iconos">
        
        
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                lugares de interés
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="bi bi-backpack fs-2"></i> camping</li>
                <li class="list-group-item"><i class="bi bi-binoculars fs-2"></i> mirador</li>
                <li class="list-group-item"><i class="bi bi-bank fs-2"></i> museo</li>
            </ul>
        </div>

        <div class="card" style="width: 18rem;">
            <div class="card-header">
                servicios
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="bi bi-bullseye fs-2"></i> camping</li>
                <li class="list-group-item"><i class="bi bi-binoculars fs-2"></i> mirador</li>
                <li class="list-group-item"><i class="bi bi-bank fs-2"></i>museo</li>
            </ul>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                actividades
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="bi bi-backpack fs-2"></i> camping</li>
                <li class="list-group-item"><i class="bi bi-cake2 fs-2"></i> mirador</li>
                <li class="list-group-item"><i class="bi bi-bank fs-2"></i> museo</li>
            </ul>
        </div>
    </div>
    

@endsection



