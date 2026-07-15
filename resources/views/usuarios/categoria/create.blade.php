@extends('layouts.app')
@section('title', 'Crear categoría')

@push('styles')
        @vite(['resources/css/categoria.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      
        <form id="form-categoria" class="form-card" action="{{ route('categoria.store') }}" method="POST">
            @csrf
            <div class="form-section-title">                
                <i class="bi bi-tag-fill"></i> Nueva Categoría
            </div>

            <!-- Nombre -->
            <div class="form-group">
                <label for="nombre">
                    Nombre de la categoría <span class="required">*</span>
                </label>
                <p class="hint">Ej: Aventura, Naturaleza, Gastronomía, Historia</p>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    maxlength="100" 
                    placeholder="Escribe el nombre de la categoría" 
                    required
                    oninput="updateCounter(this, 'counter-nombre')"                    
                >
                <div class="char-counter" id="counter-nombre">0 / 100</div>
            </div>

            <!-- Icono -->
            <div class="form-group">
                <label>
                    Selecciona un Icono <span class="required">*</span>
                </label>
                <p class="hint">Selecciona el icono que mejor represente a esta categoría</p>
                <input type="hidden" id="icono" name="icono" required value="bi-tag">
                
                <div class="icon-selector-grid">
                    <div class="icon-option active" data-icon="bi-tag" onclick="selectIcon(this, 'bi-tag')">
                        <i class="bi bi-tag"></i>
                        <span>Etiqueta</span>
                    </div>
                    <div class="icon-option" data-icon="bi-tree" onclick="selectIcon(this, 'bi-tree')">
                        <i class="bi bi-tree"></i>
                        <span>Naturaleza</span>
                    </div>
                    <div class="icon-option" data-icon="bi-compass" onclick="selectIcon(this, 'bi-compass')">
                        <i class="bi bi-compass"></i>
                        <span>Aventura</span>
                    </div>
                    <div class="icon-option" data-icon="bi-egg-fried" onclick="selectIcon(this, 'bi-egg-fried')">
                        <i class="bi bi-egg-fried"></i>
                        <span>Comida</span>
                    </div>
                    <div class="icon-option" data-icon="bi-bank" onclick="selectIcon(this, 'bi-bank')">
                        <i class="bi bi-bank"></i>
                        <span>Historia</span>
                    </div>
                    <div class="icon-option" data-icon="bi-water" onclick="selectIcon(this, 'bi-water')">
                        <i class="bi bi-water"></i>
                        <span>Agua</span>
                    </div>
                    <div class="icon-option" data-icon="bi-camera" onclick="selectIcon(this, 'bi-camera')">
                        <i class="bi bi-camera"></i>
                        <span>Fotos</span>
                    </div>
                    <div class="icon-option" data-icon="bi-house" onclick="selectIcon(this, 'bi-house')">
                        <i class="bi bi-house"></i>
                        <span>Hospedaje</span>
                    </div>
                </div>
            </div>

            <!-- Color -->
            <div class="form-group">
                <label for="color">
                    Color representativo
                </label>
                <p class="hint">Elige un color para personalizar la apariencia de la categoría</p>
                <div class="color-input-wrapper">
                    <input 
                        type="color" 
                        id="color_picker" 
                        value="#0F52BA"
                        oninput="syncColor(this.value, 'color')"
                    >
                    <input 
                        type="text" 
                        id="color" 
                        name="color" 
                        value="#0F52BA" 
                        maxlength="20"
                        placeholder="#000000"
                        oninput="syncColor(this.value, 'color_picker')"
                    >
                </div>
            </div>

            <!-- Estado -->
            <div class="form-group">
                <label for="estado">
                    Estado <span class="required">*</span>
                </label>
                <p class="hint">Define si la categoría estará activa inmediatamente</p>
                <select id="estado" name="estado" required>
                    <option value="ACTIVO" selected>Activo</option>
                    <option value="INACTIVO">Inactivo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="btn-actions">
                <a class="btn btn-dark" href="{{ route('dashboard') }}">
                    <i class="bi bi-arrow-left-circle"></i>
                    Regresar
                </a>
                <button type="submit" class="btn btn-primary">
                    Guardar Categoría
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
        counter.textContent = current + ' / ' + max;
        
        counter.classList.remove('warning', 'danger');
        if (current >= max) {
            counter.classList.add('danger');
        } else if (current >= max * 0.85) {
            counter.classList.add('warning');
        }
    }

    function selectIcon(element, iconClass) {
        // Remover active de todas las opciones
        document.querySelectorAll('.icon-option').forEach(opt => {
            opt.classList.remove('active');
        });
        // Agregar active a la opción seleccionada
        element.classList.add('active');
        // Actualizar el valor del input hidden
        document.getElementById('icono').value = iconClass;
    }

    function syncColor(value, targetId) {
        document.getElementById(targetId).value = value;
    }
</script>
@endpush
