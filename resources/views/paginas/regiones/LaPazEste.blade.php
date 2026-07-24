

@extends('layouts.guest')

@section('title', 'La Paz Este - La Paz Travel')

@section('contenido')
    <h1>La paz este</h1>
    <br>
    <div class="box">
        <!-- un mensaje cualquiera -->
        <p class ="box-content">
            PARRAFO DE DE LA PAZ ESTE
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
            <div class= "cart">
                <a class="solo" href="https://www.google.com/maps/place/Parque+Recreativo+Costa+del+Sol/@13.5833333,-88.1833333,15z/data=!4m6!3m5!1s0x8f633b7e9c8f8f8f:0x8f633b7e9c8f8f8f!8m2!3d13.5833333!4d-88.1833333!16s%2Fg%2F11c5v5v5v5?entry=ttu" target="_blank">
                    
                    <div class="card-content">
                        <h2>Isla Espíritu Santo</h2>
                        <img src="{{ asset('images/islá-espiritú-santo.jpg') }}" alt="Imagen de Isla Espíritu Santo"><br>
                        <p class="">Isla Espíritu Santo, en el departamento de La Paz, 
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
    

@endsection



