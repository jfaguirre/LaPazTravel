@extends('layouts.app')
@section('title', 'Crear regla')

@push('styles')
        @vite(['resources/css/regla.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      
        <form id="form-regla" class="form-card" action="{{ route('regla.store') }}" method="POST" enctype="multipart/form-data">
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

            <!-- Icono Personalizado (SVG) -->
            <div class="form-group">
                <label for="icono_file">
                    O sube tu propio icono personalizado (SVG)
                </label>
                <p class="hint">Debe ser un archivo SVG (tamaño tipo icono, máximo 100 KB)</p>
                <input 
                    type="file" 
                    id="icono_file" 
                    name="icono_file" 
                    accept=".svg"
                    onchange="previewSVG(this)"
                >
                @error('icono_file')
                    <span class="text-error" style="color: var(--error); font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
                
                <!-- Contenedor de previsualización -->
                <div id="svg-preview-container" class="svg-preview-container" style="display: none; margin-top: 12px; padding: 12px; border: 2px dashed var(--border); border-radius: var(--radius-md); text-align: center; background-color: var(--bg-app);">
                    <p style="font-size: 12px; color: var(--neutro-500); margin-bottom: 6px;">Previsualización de tu icono:</p>
                    <div id="svg-preview-wrapper" class="svg-preview-wrapper" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; border-radius: 8px; background-color: var(--blanco); border: 1px solid var(--border); padding: 8px;">
                        <!-- El SVG previsualizado se inyectará aquí -->
                    </div>
                    <button type="button" class="btn btn-link" onclick="removeUploadedSVG()" style="color: var(--error); font-size: 12px; padding: 4px 8px; background: none; border: none; cursor: pointer; display: block; margin: 4px auto 0;">Eliminar archivo</button>
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

        <!-- Listado de Reglas Registradas -->
        @if(isset($reglas) && $reglas->count() > 0)
            <div class="registered-section" style="margin-top: 40px;">
                <div class="form-section-title">
                    <i class="bi bi-list-task"></i> Reglas Registradas
                </div>
                <div class="registered-list-card" style="background: var(--blanco); border-radius: var(--radius-lg); padding: 24px; box-shadow: var(--sombra-card); border: 1px solid var(--border); overflow-x: auto;">
                    <table class="table-custom" style="width: 100%; border-collapse: collapse; text-align: left; min-width: 400px;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border); font-size: 14px; font-weight: 600; color: var(--neutro-700);">
                                <th style="padding: 12px 8px; width: 60px;">Icono</th>
                                <th style="padding: 12px 8px;">Regla</th>
                                <th style="padding: 12px 8px; width: 100px;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reglas as $rg)
                                <tr style="border-bottom: 1px solid var(--border); font-size: 14px; color: var(--neutro-800);">
                                    <td style="padding: 12px 8px; vertical-align: middle;">
                                        <div class="icon-display-wrapper" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; background-color: var(--bg-app); border: 1px solid var(--border); overflow: hidden; padding: 4px;">
                                            @if(Str::startsWith($rg->icono, 'bi-'))
                                                <i class="bi {{ $rg->icono }}" style="font-size: 18px; color: var(--neutro-700);"></i>
                                            @else
                                                <img src="{{ asset($rg->icono) }}" alt="Icono" class="custom-icon" style="width: 20px; height: 20px; object-fit: contain;">
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 12px 8px; font-weight: 600;">{{ $rg->regla }}</td>
                                    <td style="padding: 12px 8px;">
                                        <span class="badge" style="font-size: 11px; padding: 4px 8px; border-radius: 20px; font-weight: 600; display: inline-block; text-align: center; background-color: {{ $rg->estado === 'ACTIVO' ? '#d4edda' : '#f8d7da' }}; color: {{ $rg->estado === 'ACTIVO' ? '#155724' : '#721c24' }};">
                                            {{ $rg->estado }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
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
        
        // Limpiar archivo subido si existiera
        document.getElementById('icono_file').value = '';
        document.getElementById('svg-preview-container').style.display = 'none';
        document.getElementById('svg-preview-wrapper').innerHTML = '';
    }

    function previewSVG(input) {
        const container = document.getElementById('svg-preview-container');
        const wrapper = document.getElementById('svg-preview-wrapper');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Verificar extensión
            if (file.name.split('.').pop().toLowerCase() !== 'svg') {
                alert('Por favor selecciona solo archivos con extensión .svg');
                input.value = '';
                removeUploadedSVG();
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                // Inyectar el SVG en el contenedor de previsualización
                wrapper.innerHTML = e.target.result;
                container.style.display = 'block';
                
                // Estandarizar tamaño del SVG cargado en la previsualización
                const svgElement = wrapper.querySelector('svg');
                if (svgElement) {
                    svgElement.setAttribute('width', '32');
                    svgElement.setAttribute('height', '32');
                    svgElement.style.width = '32px';
                    svgElement.style.height = '32px';
                }
                
                // Desmarcar los iconos predefinidos
                document.querySelectorAll('.icon-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                // Limpiar el hidden input
                document.getElementById('icono').value = '';
            };
            reader.readAsText(file);
        } else {
            removeUploadedSVG();
        }
    }

    function removeUploadedSVG() {
        document.getElementById('icono_file').value = '';
        document.getElementById('svg-preview-container').style.display = 'none';
        document.getElementById('svg-preview-wrapper').innerHTML = '';
        
        // Volver a seleccionar el primer icono predefinido como default
        const firstIcon = document.querySelector('.icon-option');
        if (firstIcon) {
            firstIcon.classList.add('active');
            document.getElementById('icono').value = firstIcon.getAttribute('data-icon');
        }
    }
</script>
@endpush
