@extends('layouts.app')
@section('title', 'Editar sitio')

@push('styles')
        @vite(['resources/css/dashboard_sitio.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      
        <form id="form-datos-basicos" class="form-card" action="{{ route('sitio.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-section-title">                
                Editar datos generales
            </div>

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
                    value="{{ old('nombre', $sitio->nombre) }}"
                    required
                    oninput="updateSlug(this.value); updateCounter(this, 'counter-nombre')"                    
                >
                <div class="char-counter" id="counter-nombre">0 / 50</div>
            </div>

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
                    value="{{ old('slug', $sitio->slug) }}"
                    required
                    disabled
                    oninput="updateCounter(this, 'counter-slug')"
                >
                <div class="slug-preview" id="slug-preview">
                    <i class="bi bi-globe2"></i> https://lapaztravel.com/<span id="slug-text"></span>
                </div>
                <div class="char-counter" id="counter-slug">0 / 50</div>
            </div>

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
                >{{ old('descripcion_corta', $sitio->descripcion_corta) }}</textarea>
                <div class="char-counter" id="counter-desc">0 caracteres</div>
            </div>


            <!-- Botones -->
            <div class="btn-actions">
                <a class="btn btn-dark" href="{{ route('perfil.create') }}">
                    <i class="bi bi-arrow-left-circle"></i>
                    Regresar
                </a>
                <button type="submit" class="btn btn-primary">
                    Guardar Cambios
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
            const max = el.maxLength;
            const current = el.value.length;
            
            if (counterId === 'counter-desc') {
                counter.textContent = current + ' caracteres';
            } else {
                counter.textContent = current + ' / ' + max;
            }
            
            counter.classList.remove('warning', 'danger');
            if (current >= max) {
                counter.classList.add('danger');
            } else if (current >= max * 0.85) {
                counter.classList.add('warning');
            }
        }

        function updateSlug(value) {
            const slugInput = document.getElementById('slug');
            const preview = document.getElementById('slug-preview');
            const slugText = document.getElementById('slug-text');
            
            // generacion del slug a partir del nombre
            let slug = value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .substring(0, 200);
            
            slugInput.value = slug;
            updateCounter(slugInput, 'counter-slug');
            
            if (slug.length > 0) {
                preview.classList.add('visible');
                slugText.textContent = slug;
            } else {
                preview.classList.remove('visible');
            }
        }

        // Inicializar contadores y preview al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const nombreInput = document.getElementById('nombre');
            const slugInput = document.getElementById('slug');
            const descInput = document.getElementById('descripcion_corta');
            const preview = document.getElementById('slug-preview');
            const slugText = document.getElementById('slug-text');

            if (nombreInput) {
                updateCounter(nombreInput, 'counter-nombre');
            }
            if (slugInput) {
                updateCounter(slugInput, 'counter-slug');
                if (slugInput.value.length > 0) {
                    preview.classList.add('visible');
                    slugText.textContent = slugInput.value;
                }
            }
            if (descInput) {
                updateCounter(descInput, 'counter-desc');
            }
        });
    </script>
    
@endpush
