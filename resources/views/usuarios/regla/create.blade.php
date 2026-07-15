@extends('layouts.app')
@section('title', 'Crear regla')

@push('styles')
        @vite(['resources/css/regla.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      
        <form id="form-regla" class="form-card" action="{{ route('regla.store') }}" method="POST">
            @csrf
            <div class="form-section-title">                
                <i class="bi bi-shield-fill-exclamation"></i> Nueva Regla de Convivencia
            </div>

            <!-- Regla -->
            <div class="form-group">
                <label for="regla">
                    Regla <span class="required">*</span>
                </label>
                <p class="hint">Ej: No fumar, Sin mascotas, Silencio nocturno, Respete la flora</p>
                <input 
                    type="text" 
                    id="regla" 
                    name="regla" 
                    maxlength="20" 
                    placeholder="Regla corta (máx 20 caracteres)" 
                    required
                    oninput="updateCounter(this, 'counter-regla')"                    
                >
                <div class="char-counter" id="counter-regla">0 / 20</div>
            </div>

            <!-- Icono -->
            <div class="form-group">
                <label>
                    Selecciona un Icono <span class="required">*</span>
                </label>
                <p class="hint">Selecciona el icono que mejor represente a esta regla</p>
                <input type="hidden" id="icono" name="icono" required value="bi-slash-circle">
                
                <div class="icon-selector-grid">
                    <div class="icon-option active" data-icon="bi-slash-circle" onclick="selectIcon(this, 'bi-slash-circle')">
                        <i class="bi bi-slash-circle"></i>
                        <span>Prohibido</span>
                    </div>
                    <div class="icon-option" data-icon="bi-volume-mute" onclick="selectIcon(this, 'bi-volume-mute')">
                        <i class="bi bi-volume-mute"></i>
                        <span>Silencio</span>
                    </div>
                    <div class="icon-option" data-icon="bi-camera-video-off" onclick="selectIcon(this, 'bi-camera-video-off')">
                        <i class="bi bi-camera-video-off"></i>
                        <span>No grabar</span>
                    </div>
                    <div class="icon-option" data-icon="bi-trash" onclick="selectIcon(this, 'bi-trash')">
                        <i class="bi bi-trash"></i>
                        <span>Basura</span>
                    </div>
                    <div class="icon-option" data-icon="bi-exclamation-triangle" onclick="selectIcon(this, 'bi-exclamation-triangle')">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Peligro</span>
                    </div>
                    <div class="icon-option" data-icon="bi-clock" onclick="selectIcon(this, 'bi-clock')">
                        <i class="bi bi-clock"></i>
                        <span>Horario</span>
                    </div>
                    <div class="icon-option" data-icon="bi-info-circle" onclick="selectIcon(this, 'bi-info-circle')">
                        <i class="bi bi-info-circle"></i>
                        <span>Info</span>
                    </div>
                    <div class="icon-option" data-icon="bi-person-badge" onclick="selectIcon(this, 'bi-person-badge')">
                        <i class="bi bi-person-badge"></i>
                        <span>Registro</span>
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="form-group">
                <label for="estado">
                    Estado <span class="required">*</span>
                </label>
                <p class="hint">Define si la regla estará activa inmediatamente</p>
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
                    Guardar Regla
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
