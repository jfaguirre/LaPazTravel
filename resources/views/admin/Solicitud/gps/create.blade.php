@extends('layouts.app')
@section('title', 'Mapa GPS - ' . $sitio->nombre)

@push('styles')
    @vite(['resources/css/dashboard_sitio.css'])
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let nom = "";
            const inputLat = document.getElementById('latitud');
            const inputLng = document.getElementById('longitud');
            const sitio = @json($sitio);
            const gps = @json($gps);

            // Centro de La Paz por defecto si aún no hay ubicación guardada
            const inicial = {
                lat: parseFloat(inputLat.value) || 13.5122,
                lng: parseFloat(inputLng.value) || -88.8695,            
            };
            
            if (gps && gps.latitud && gps.longitud) {            
                nom = String(sitio.nombre);
            } else {            
                nom = String("Sin agregar sitio");
            }
                    
            const mapa = L.map('mapa').setView([inicial.lat, inicial.lng], 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(mapa);

            // Mostrar en la burbuja al hacer clic
            const marcador = L.marker([inicial.lat, inicial.lng], { draggable: true }).addTo(mapa)
                .bindPopup('Latitud: ' + inicial.lat + '<br>Longitud: ' + inicial.lng + '<br>Sitio: ' + nom)
                .openPopup();
                            
            function fijar(lat, lng) {
                inputLat.value = lat.toFixed(6);
                inputLng.value = lng.toFixed(6);
            }       

            // Clic en el mapa mueve el marcador
            mapa.on('click', e => { marcador.setLatLng(e.latlng); fijar(e.latlng.lat, e.latlng.lng); });

            // O arrastrar el marcador directamente
            marcador.on('dragend', () => fijar(marcador.getLatLng().lat, marcador.getLatLng().lng));
        });
            
        function updateCounter(el, counterId) {
            const counter = document.getElementById(counterId);
            if (!counter) return;
            const max = el.maxLength;
            const current = el.value.length;
            
            counter.textContent = current + ' / ' + max;
            
            counter.classList.remove('warning', 'danger');
            if (current >= max) {
                counter.classList.add('danger');
            } else if (current >= max * 0.85) {
                counter.classList.add('warning');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const latitudInput = document.getElementById('latitud');
            const longitudInput = document.getElementById('longitud');            

            if (latitudInput) {
                updateCounter(latitudInput, 'counter-latitud');
            }

            if (longitudInput) {
                updateCounter(longitudInput, 'counter-longitud');
            }
        });
    </script>
@endpush

@section('contenido')
<div id="page-dashboard" class="page">
    <div class="dashboard-card" style="max-width: 900px; padding: 40px;">

        <!-- Cabecera -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Mapa de ubicación del sitio</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Coordenadas para mostrar la georreferencia de tu lugar turístico <strong>{{ $sitio->nombre }}</strong>.</p>
            </div>
            <a href="{{ route('perfil.create') }}" class="step-link" style="font-size: 14.5px;">
                <i class="bi bi-arrow-left-short" style="font-size: 20px; line-height: 1;"></i> Volver al panel
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        <form id="form-datos-basicos" class="form-card" action="{{ route('gps.store') }}" method="POST">
            @csrf

            @if($sitio->perfil && $sitio->perfil->latitud && $sitio->perfil->longitud)
                <div class="form-section-title">                
                    Editar coordenadas
                </div>
            @else
                <div class="form-section-title">                
                    Aún no tienes un mapa definido.
                </div>
            @endif

            {{-- Latitud del sitio --}}
            <div class="form-group">
                <label for="latitud">Latitud</label>
                <p class="hint">Ingresa la latitud de la ubicación de tu destino turístico.</p>
                <input 
                    type="text"
                    id="latitud" 
                    name="latitud" 
                    maxlength="50" 
                    placeholder="Ej: -16.495600" 
                    value="{{ old('latitud', $sitio->perfil?->latitud) }}"
                    required                    
                    readonly
                >
                <div class="char-counter" id="counter-latitud">0 / 50</div>
            </div>

            {{-- Longitud del sitio --}}
            <div class="form-group">
                <label for="longitud">Longitud</label>
                <p class="hint">Ingresa la longitud de la ubicación de tu destino turístico.</p>
                <input 
                    type="text" 
                    id="longitud" 
                    name="longitud" 
                    maxlength="50" 
                    placeholder="Ej: -68.133600" 
                    value="{{ old('longitud', $sitio->perfil?->longitud) }}"
                    required                    
                    readonly
                >
                <div class="char-counter" id="counter-longitud">0 / 50</div>
            </div>

            <div class="alert alert-primary" role="alert" style="margin-top: 20px;">
                Haz clic en el mapa o arrastra el marcador para asignar las coordenadas geográficas de tu sitio.
            </div>

            <div id="mapa" style="height: 400px; overflow: hidden; margin-top:20px; border-radius: var(--radius-md); border: 1px solid var(--border);"></div>

            <!-- Botones -->
            <div class="btn-actions" style="display: flex; align-items: center; justify-content: flex-end; gap: 16px; border-top: 2px solid var(--border); padding-top: 24px; margin-top: 32px;">
                <a class="btn btn-dark" href="{{ route('perfil.create') }}" style="background-color: var(--blanco); border: 2px solid var(--border); color: var(--neutro-700); padding: 10px 24px; border-radius: var(--radius-md); font-size: 15px; font-weight: 700; text-decoration: none;">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary" style="background-color: var(--primario); color: var(--blanco); border: none; padding: 12px 28px; border-radius: var(--radius-md); font-size: 15px; font-weight: 700; cursor: pointer;">
                    Guardar Cambios <i class="bi bi-check-lg ms-1"></i>
                </button>                               
            </div>
        </form>
    </div>
</div>
@endsection
