@extends('layouts.app')
@section('title', 'Crear sitio')

@push('styles')
        @vite(['resources/css/dashboard_sitio.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      
        <form id="form-datos-basicos" class="form-card" action="{{ route('sitio.store') }}" method="POST">
            @csrf
            <div class="form-section-title">                
                Datos generales
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
                ></textarea>
                <div class="char-counter" id="counter-desc">0 caracteres</div>
            </div>

            <div class="d-grid gap-2 d-md-block">
                <a class="btn btn-dark btn-sm" href="{{ route('dashboard') }}">
                    <i class="bi bi-arrow-left-circle m-0 p-0"></i>
                    Regresar
                </a>
                <button type="submit" class="btn btn-primary btn-sm">Guardar datos</button>                               
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
            counter.textContent = current + ' / ' + max;
            
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
    </script>
    
@endpush