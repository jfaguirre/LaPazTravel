@extends('layouts.app')
@section('title', 'Crear sitio')

@push('styles')
        @vite(['resources/css/dashboard_sitio.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      
        <form id="form-datos-basicos" class="form-card" action="{{ route('informacion.store') }}" method="POST">
            @csrf
            <div class="form-section-title">                
                Datos generales
            </div>

            {{-- Nombre del sitio --}}
            <div class="form-group">
                <label for="nombre">
                    Nombre del sitio <span class="required">*</span>
                </label>
                <p class="hint">Ingresa el nombre oficial o más conocido del destino turístico</p>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    maxlength="50" 
                    placeholder="Ej: Cascada El Salto" 
                    value="{{ old('nombre', $sitio->nombre ?? '') }}"
                    required
                    oninput="updateSlug(this.value); updateCounter(this, 'counter-nombre')"                    
                >
                <div class="char-counter" id="counter-nombre">0 / 50</div>
                @error('nombre')
                    <span class="text-danger" style="color: #dc2626; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="form-group">
                <label for="slug">
                    Slug <span class="required">*</span>
                </label>
                <p class="hint">Identificador único en URL. Se genera automáticamente desde el nombre.</p>
                <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    maxlength="50" 
                    placeholder="cascada-el-salto" 
                    value="{{ old('slug', $sitio->slug ?? '') }}"
                    required
                    readonly
                    oninput="updateCounter(this, 'counter-slug')"
                >
                <div class="slug-preview" id="slug-preview">
                    <i class="bi bi-globe2"></i> https://lapaztravel.com/<span id="slug-text"></span>
                </div>
                <div class="char-counter" id="counter-slug">0 / 50</div>
                @error('slug')
                    <span class="text-danger" style="color: #dc2626; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Descripción corta --}}
            <div class="form-group">
                <label for="descripcion_corta">
                    Descripción corta <span class="required">*</span>
                </label>
                <p class="hint">Un resumen atractivo de 1 a 3 oraciones sobre el destino</p>
                <textarea 
                    id="descripcion_corta" 
                    name="descripcion_corta" 
                    placeholder="Describe brevemente qué hace especial a este lugar, qué pueden esperar los visitantes..."
                    required
                    maxlength="200" 
                    oninput="updateCounter(this, 'counter-desc')"
                >{{ old('descripcion_corta', $sitio->descripcion_corta ?? '') }}</textarea>
                <div class="char-counter" id="counter-desc">0 / 200</div>
                @error('descripcion_corta')
                    <span class="text-danger" style="color: #dc2626; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>            

            {{-- Telefono --}}
            <div class="form-group">                
                <label for="telefono">
                    Teléfono del sitio
                </label>
                <p class="hint">Ingresa el teléfono oficial del sitio turístico</p>
                <input 
                    type="text" 
                    id="telefono" 
                    name="telefono" 
                    maxlength="9" 
                    placeholder="Ej: 23340866" 
                    value="{{ old('telefono', optional($sitio?->perfil)->telefono) }}"                      
                    oninput="updateCounter(this, 'counter-telefono')"                    
                >
                <div class="char-counter" id="counter-telefono">0 / 9</div>
                @error('telefono')
                    <span class="text-danger" style="color: #dc2626; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Correo institucional --}}
            <div class="form-group">
                <label for="correo">
                    Correo del sitio
                </label>
                <p class="hint">Ingresa el correo oficial del sitio turístico</p>
                <input 
                    type="text" 
                    id="correo" 
                    name="correo" 
                    maxlength="100" 
                    placeholder="Ej: info@miagencia.com, o personal, como usuario@gmail.com"
                    value="{{ old('correo', optional($sitio?->perfil)->correo_institucional) }}"                      
                    oninput="updateCounter(this, 'counter-correo')"                    
                >
                <div class="char-counter" id="counter-correo">0 / 100</div>
                @error('correo')
                    <span class="text-danger" style="color: #dc2626; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Ubicación del sitio --}}
            <div class="form-group">
                <label>
                    Ubicación del sitio
                </label>
                <livewire:ubicacion />
            </div>

            {{-- Dirección del sitio --}}
            <div class="form-group">
                <label for="direccion">
                    Dirección física del sitio
                </label>
                <p class="hint">Ingresa la dirección completa oficial del sitio turístico</p>
                <input 
                    type="text" 
                    id="direccion" 
                    name="direccion" 
                    maxlength="150" 
                    placeholder="Ej: Carretera El Litoral. Km 57. Canton El Salto. Caserio San Jose"
                    value="{{ old('direccion', optional($sitio?->perfil)->direccion) }}"                      
                    oninput="updateCounter(this, 'counter-direccion')"                    
                >
                <div class="char-counter" id="counter-direccion">0 / 150</div>
                @error('direccion')
                    <span class="text-danger" style="color: #dc2626; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botones -->
            <div class="btn-actions">                
                <a class="btn btn-dark" href="{{ route('dashboard') }}">                     
                    Cancelar
                </a>                
                <button type="submit" class="btn btn-primary">
                    Crear sitio
                </button>                               
            </div>

        </form>
    </div>
</div>
    
@endsection

@push('scripts')

    <script>
        function updateCounter(el, counterId) {
            const counter = document.getElementById(counterId);
            if (!counter || !el) return;
            const max = el.maxLength;
            const current = el.value ? el.value.length : 0;
            
            counter.textContent = current + ' / ' + max;
            
            counter.classList.remove('warning', 'danger');
            if (max > 0 && current >= max) {
                counter.classList.add('danger');
            } else if (max > 0 && current >= max * 0.85) {
                counter.classList.add('warning');
            }
        }

        function updateSlug(value) {
            const slugInput = document.getElementById('slug');
            const preview = document.getElementById('slug-preview');
            const slugText = document.getElementById('slug-text');
            
            if (!slugInput) return;

            let slug = value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .substring(0, 50);
            
            slugInput.value = slug;
            updateCounter(slugInput, 'counter-slug');
            
            if (preview && slugText) {
                if (slug.length > 0) {
                    preview.classList.add('visible');
                    slugText.textContent = slug;
                } else {
                    preview.classList.remove('visible');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputs = [
                { id: 'nombre', counterId: 'counter-nombre' },
                { id: 'slug', counterId: 'counter-slug' },
                { id: 'descripcion_corta', counterId: 'counter-desc' },
                { id: 'telefono', counterId: 'counter-telefono' },
                { id: 'correo', counterId: 'counter-correo' },
                { id: 'direccion', counterId: 'counter-direccion' }
            ];

            inputs.forEach(item => {
                const el = document.getElementById(item.id);
                if (el) {
                    updateCounter(el, item.counterId);
                }
            });

            const slugInput = document.getElementById('slug');
            const preview = document.getElementById('slug-preview');
            const slugText = document.getElementById('slug-text');
            if (slugInput && preview && slugText && slugInput.value.length > 0) {
                preview.classList.add('visible');
                slugText.textContent = slugInput.value;
            }
        });
    </script>
    
@endpush
