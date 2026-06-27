@extends('layouts.guest')

@section('titulo', 'Mapa - La Paz Travel')

@section('contenedor_principal')
    <h2>Mapa de La Paz Travel</h2>
    <p>Explora los mejores destinos turísticos, encuentra ofertas exclusivas y planifica tu próxima aventura con nosotros.</p>
    <br>
    
    <div class="mapa-interactivo">
        <!-- Contenedor del mapa unificado -->
        <div class="mapa-unificado">
            <div class="mapa-container">
                <!-- Las tres imágenes se muestran como un solo mapa -->
                <div class="mapa-fila">
                    <div class="mapa-columna">
                        <div class="zona z-oeste" data-zona="oeste">
                            <img src="{{ asset('assets/images/mapa-la-paz-oeste.png') }}" alt="La Paz Oeste">
                            <div class="zona-label">Oeste</div>
                        </div>
                    </div>
                    <div class="mapa-columna">
                        <div class="zona z-centro" data-zona="centro">
                            <img src="{{ asset('assets/images/mapa-la-paz-centro.png') }}" alt="La Paz Centro">
                            <div class="zona-label">Centro</div>
                        </div>
                    </div>
                    <div class="mapa-columna">
                        <div class="zona z-este" data-zona="este">
                            <img src="{{ asset('assets/images/mapa-la-paz-este.png') }}" alt="La Paz Este">
                            <div class="zona-label">Este</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Marcadores interactivos -->
            <div class="marcadores">
                <div class="marcador" style="left: 15%; top: 30%;" data-lugar="mercado-brujas">
                    <span class="punto"></span>
                    <span class="nombre">Mercado de las Brujas</span>
                </div>
                <div class="marcador" style="left: 45%; top: 45%;" data-lugar="plaza-murillo">
                    <span class="punto"></span>
                    <span class="nombre">Plaza Murillo</span>
                </div>
                <div class="marcador" style="left: 75%; top: 25%;" data-lugar="zona-sur">
                    <span class="punto"></span>
                    <span class="nombre">Zona Sur</span>
                </div>
            </div>
        </div>
        
        <!-- Panel de información -->
        <div class="info-panel" id="infoPanel">
            <div class="info-contenido">
                <h3 id="zonaTitulo">🌍 Explora La Paz</h3>
                <p id="zonaDescripcion">Haz clic en las zonas del mapa para descubrir más</p>
                <div id="zonaDetalles" style="display: none;">
                    <ul id="listaAtractivos"></ul>
                    <button class="btn-explorar" onclick="explorarZona()">
                        🗺️ Explorar esta zona
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <p class="mapa-instrucciones">🖱️ Haz clic en las zonas del mapa o en los marcadores para descubrir información</p>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/mapa.css') }}">
@endpush

@push('scripts')
    <script>
        // Datos de las zonas
        const zonasData = {
            'oeste': {
                titulo: '🌅 Zona Oeste',
                descripcion: 'La zona oeste de La Paz es conocida por su rica tradición cultural y arquitectura colonial. Aquí encontrarás los barrios más antiguos y pintorescos de la ciudad.',
                atractivos: [
                    'Mercado de las Brujas - Calle Linares',
                    'Calle Jaén - Museo de Arte',
                    'Iglesia de San Francisco - Siglo XVI',
                    'Mirador Killi Killi - Vista panorámica'
                ]
            },
            'centro': {
                titulo: '🏛️ Zona Centro',
                descripcion: 'El corazón histórico y político de La Paz. Aquí se concentran los principales edificios gubernamentales, culturales y financieros de la ciudad.',
                atractivos: [
                    'Plaza Murillo - Centro político',
                    'Catedral Metropolitana - Arquitectura neoclásica',
                    'Palacio de Gobierno - Sede presidencial',
                    'Museo Nacional de Arte - Colección colonial'
                ]
            },
            'este': {
                titulo: '🌆 Zona Este',
                descripcion: 'La zona más moderna y cosmopolita de La Paz. Caracterizada por su desarrollo urbano, centros comerciales y excelentes restaurantes.',
                atractivos: [
                    'Mallasa - Centro comercial',
                    'Zona Sur - Barrios residenciales',
                    'Teleférico Línea Verde - Transporte aéreo',
                    'Parque Urbano Central - Área verde'
                ]
            }
        };

        // Función para mostrar información de la zona
        function mostrarZona(zona) {
            const data = zonasData[zona];
            if (!data) return;

            // Actualizar panel de información
            document.getElementById('zonaTitulo').textContent = data.titulo;
            document.getElementById('zonaDescripcion').textContent = data.descripcion;
            
            // Mostrar atractivos
            const lista = document.getElementById('listaAtractivos');
            lista.innerHTML = '';
            data.atractivos.forEach(atractivo => {
                const li = document.createElement('li');
                li.textContent = atractivo;
                lista.appendChild(li);
            });
            
            document.getElementById('zonaDetalles').style.display = 'block';
            
            // Resaltar sección activa
            document.querySelectorAll('.zona').forEach(el => {
                el.classList.remove('activa');
            });
            
            const zonaActiva = document.querySelector(`.z-${zona}`);
            if (zonaActiva) {
                zonaActiva.classList.add('activa');
            }
        }

        // Función para explorar zona
        function explorarZona() {
            const zonaActiva = document.querySelector('.zona.activa');
            if (zonaActiva) {
                const zona = zonaActiva.dataset.zona;
                // Redirigir o mostrar más información
                alert(`Explorando la zona ${zonasData[zona].titulo}`);
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Clic en zonas del mapa
            document.querySelectorAll('.zona').forEach(zona => {
                zona.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const zonaId = this.dataset.zona;
                    mostrarZona(zonaId);
                });
            });

            // Clic en marcadores
            document.querySelectorAll('.marcador').forEach(marcador => {
                marcador.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const lugar = this.dataset.lugar;
                    alert(`📍 Información de: ${this.querySelector('.nombre').textContent}`);
                });
            });
        });
    </script>
@endpush