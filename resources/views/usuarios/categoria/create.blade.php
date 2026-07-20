@extends('layouts.app')
@section('title', 'Crear categoría')

@push('styles')
        @vite(['resources/css/categoria.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      
        <form id="form-categoria" class="form-card" action="{{ route('categoria.store') }}" method="POST" enctype="multipart/form-data">
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

        <!-- Listado de Categorías Registradas -->
        @if(isset($categorias) && $categorias->count() > 0)
            <div class="registered-section" style="margin-top: 40px;">
                <div class="form-section-title">
                    <i class="bi bi-list-stars"></i> Categorías Registradas
                </div>
                <div class="registered-list-card" style="background: var(--blanco); border-radius: var(--radius-lg); padding: 24px; box-shadow: var(--sombra-card); border: 1px solid var(--border); overflow-x: auto;">
                    <table class="table-custom" style="width: 100%; border-collapse: collapse; text-align: left; min-width: 400px;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border); font-size: 14px; font-weight: 600; color: var(--neutro-700);">
                                <th style="padding: 12px 8px; width: 60px;">Icono</th>
                                <th style="padding: 12px 8px;">Nombre</th>
                                <th style="padding: 12px 8px;">Color</th>
                                <th style="padding: 12px 8px; width: 100px;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $cat)
                                <tr style="border-bottom: 1px solid var(--border); font-size: 14px; color: var(--neutro-800);">
                                    <td style="padding: 12px 8px; vertical-align: middle;">
                                        <div class="icon-display-wrapper" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; background-color: var(--bg-app); border: 1px solid var(--border); overflow: hidden; padding: 4px;">
                                            @if(Str::startsWith($cat->icono, 'bi-'))
                                                <i class="bi {{ $cat->icono }}" style="font-size: 18px; color: {{ $cat->color ?? 'var(--neutro-700)' }};"></i>
                                            @else
                                                <img src="{{ asset($cat->icono) }}" alt="Icono" class="custom-icon" style="width: 20px; height: 20px; object-fit: contain;">
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 12px 8px; font-weight: 600;">{{ $cat->nombre }}</td>
                                    <td style="padding: 12px 8px;">
                                        @if($cat->color)
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <span style="display: inline-block; width: 14px; height: 14px; border-radius: 50%; background-color: {{ $cat->color }}; border: 1px solid var(--border);"></span>
                                                <span>{{ $cat->color }}</span>
                                            </div>
                                        @else
                                            <span style="color: var(--neutro-400);">No especificado</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px 8px;">
                                        <span class="badge" style="font-size: 11px; padding: 4px 8px; border-radius: 20px; font-weight: 600; display: inline-block; text-align: center; background-color: {{ $cat->estado === 'ACTIVO' ? '#d4edda' : '#f8d7da' }}; color: {{ $cat->estado === 'ACTIVO' ? '#155724' : '#721c24' }};">
                                            {{ $cat->estado }}
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

    function syncColor(value, targetId) {
        document.getElementById(targetId).value = value;
    }
</script>
@endpush
