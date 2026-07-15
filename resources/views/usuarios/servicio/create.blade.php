@extends('layouts.app')
@section('title', 'Crear servicio')

@push('styles')
        @vite(['resources/css/servicio.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      
        <form id="form-servicio" class="form-card" action="{{ route('servicio.store') }}" method="POST">
            @csrf
            <div class="form-section-title">                
                <i class="bi bi-briefcase-fill"></i> Nuevo Servicio Disponibles
            </div>

            <!-- Servicio -->
            <div class="form-group">
                <label for="servicio">
                    Nombre del servicio <span class="required">*</span>
                </label>
                <p class="hint">Ej: Wi-Fi gratuito, Parqueo, Baños públicos, Guía bilingüe</p>
                <input 
                    type="text" 
                    id="servicio" 
                    name="servicio" 
                    maxlength="50" 
                    placeholder="Servicio (máx 50 caracteres)" 
                    required
                    oninput="updateCounter(this, 'counter-servicio')"                    
                >
                <div class="char-counter" id="counter-servicio">0 / 50</div>
            </div>

            <!-- Icono -->
            <div class="form-group">
                <label>
                    Selecciona un Icono <span class="required">*</span>
                </label>
                <p class="hint">Selecciona el icono que mejor represente a este servicio</p>
                <input type="hidden" id="icono" name="icono" required value="bi-wifi">
                
                <div class="icon-selector-grid">
                    <div class="icon-option active" data-icon="bi-wifi" onclick="selectIcon(this, 'bi-wifi')">
                        <i class="bi bi-wifi"></i>
                        <span>Wi-Fi</span>
                    </div>
                    <div class="icon-option" data-icon="bi-car" onclick="selectIcon(this, 'bi-car')">
                        <i class="bi bi-car"></i>
                        <span>Parqueo</span>
                    </div>
                    <div class="icon-option" data-icon="bi-water" onclick="selectIcon(this, 'bi-water')">
                        <i class="bi bi-droplet"></i>
                        <span>Agua Potable</span>
                    </div>
                    <div class="icon-option" data-icon="bi-telephone" onclick="selectIcon(this, 'bi-telephone')">
                        <i class="bi bi-telephone"></i>
                        <span>Llamadas</span>
                    </div>
                    <div class="icon-option" data-icon="bi-cup-hot" onclick="selectIcon(this, 'bi-cup-hot')">
                        <i class="bi bi-cup-hot"></i>
                        <span>Cafetería</span>
                    </div>
                    <div class="icon-option" data-icon="bi-credit-card" onclick="selectIcon(this, 'bi-credit-card')">
                        <i class="bi bi-credit-card"></i>
                        <span>Pagos Tarjeta</span>
                    </div>
                    <div class="icon-option" data-icon="bi-shield" onclick="selectIcon(this, 'bi-shield')">
                        <i class="bi bi-shield"></i>
                        <span>Seguridad</span>
                    </div>
                    <div class="icon-option" data-icon="bi-translate" onclick="selectIcon(this, 'bi-translate')">
                        <i class="bi bi-translate"></i>
                        <span>Traducción</span>
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="form-group">
                <label for="estado">
                    Estado <span class="required">*</span>
                </label>
                <p class="hint">Define si el servicio estará activo inmediatamente</p>
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
                    Guardar Servicio
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
</script>
@endpush
