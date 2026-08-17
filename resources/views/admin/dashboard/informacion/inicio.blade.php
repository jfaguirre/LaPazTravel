@extends('layouts.dashboardSitio')
@section('title', 'Editar sitio')

@push('styles')
        @vite(['resources/css/dashboard_sitio.css'])
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      

         <!-- Cabecera -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Información de contacto del sitio</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Ingresa los datos importatnes y básicos del sitio para que los usuarios puedan encontrarte más rapido en <strong>{{ $sitio->nombre }}</strong>.</p>
            </div>
            <a href="{{ route('dashboard.sitio.inicio') }}" class="step-link" style="font-size: 14.5px;">
                <i class="bi bi-arrow-left-short" style="font-size: 20px; line-height: 1;"></i> Volver al panel
            </a>
        </div>

        @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente)
            <div class="alert alert-warning mb-4 d-flex align-items-center" role="alert" style="background-color: #fef3c7; border: 1px solid #fde68a; color: #92400e; border-radius: 12px; padding: 16px 20px;">
                <i class="bi bi-clock-history fs-4 me-3" style="color: #d97706;"></i>
                <div>
                    <strong>Solicitud en revisión:</strong> Ya tienes una solicitud de actualización de información general y de contacto pendiente de aprobación. No se pueden realizar modificaciones hasta que la solicitud actual sea procesada.
                </div>
            </div>
        @endif

        <form id="form-datos-basicos" class="form-card" action="{{ route('informacion.update') }}" method="POST">
            @csrf
            @method('put')

            <div class="form-section-title">                
                Editar datos generales
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
                    value="{{ old('nombre', $sitio->nombre) }}"
                    required
                    oninput="updateSlug(this.value); updateCounter(this, 'counter-nombre')"
                    @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                >
                <div class="char-counter" id="counter-nombre">0 / 50</div>
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
                    value="{{ old('slug', $sitio->slug) }}"
                    required
                    readonly
                    oninput="updateCounter(this, 'counter-slug')"
                    @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                >
                <div class="slug-preview" id="slug-preview">
                    <i class="bi bi-globe2"></i> https://lapaztravel.com/<span id="slug-text"></span>
                </div>
                <div class="char-counter" id="counter-slug">0 / 50</div>
            </div>

            {{-- Descripcion --}}
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
                    @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                >{{ old('descripcion_corta', $sitio->descripcion_corta) }}</textarea>
                <div class="char-counter" id="counter-desc">0 caracteres</div>
            </div>

            {{-- Telefono --}}
            <div class="form-group">                
                <label for="telefono" class="{{ optional($sitio->perfil)->telefono ? '' : 'color-pendiente' }}">
                    Teléfono del sitio
                </label>

                <p class="hint">Ingresa el teléfono oficia del sitio turístico</p>
                <input 
                    type="text" 
                    id="telefono" 
                    name="telefono" 
                    maxlength="9" 
                    placeholder="Ej: 23340866" 
                    value="{{ old('telefono', optional($sitio->perfil)->telefono) }}"                      
                    oninput="updateCounter(this, 'counter-telefono')"
                    @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                >
                <div class="char-counter" id="counter-telefono">0 / 9</div>
            </div>

            {{-- Correo institucional --}}
            <div class="form-group">
                <label for="correo" class="{{ optional($sitio->perfil)->correo_institucional ? '' : 'color-pendiente' }}">
                    Correo del sitio
                </label>
                <p class="hint">Ingresa el correo oficia del sitio turístico</p>
                <input 
                    type="text" 
                    id="correo" 
                    name="correo" 
                    maxlength="100" 
                    placeholder="Ej: info@miagencia.com, o personal, como usuario@gmail.com"
                    value="{{ old('correo', optional($sitio->perfil)->correo_institucional) }}"                      
                    oninput="updateCounter(this, 'counter-correo')"
                    @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                >
                <div class="char-counter" id="counter-correo">0 / 100</div>
            </div>

             {{-- Direccion del sitio --}}
            <div class="form-group">
                <label for="direccion" class="{{ optional($sitio->perfil)->direccion ? '' : 'color-pendiente' }}">
                    Dirección fisica del sitio
                </label>
                <p class="hint">Ingresa la dirección completa oficia del sitio turístico</p>
                <input 
                    type="text" 
                    id="direccion" 
                    name="direccion" 
                    maxlength="150" 
                    placeholder="Ej: Carretera El Litoral. Km 57. Canton El Salto. Caserio San Jose"
                    value="{{ old('direccion', optional($sitio->perfil)->direccion) }}"                      
                    oninput="updateCounter(this, 'counter-direccion')"
                    @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                >
                <div class="char-counter" id="counter-direccion">0 / 150</div>
            </div>


            <!-- Botones -->
            <div class="btn-actions">
                <a class="btn btn-dark" href="{{ route('dashboard.sitio.inicio') }}">                    
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary" @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled style="opacity: 0.55; cursor: not-allowed;" @endif>
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
            const telefonoInput = document.getElementById('telefono');
            const correoInput = document.getElementById('correo');
            const direccionInput = document.getElementById('direccion');
            const slugInput = document.getElementById('slug');
            const descInput = document.getElementById('descripcion_corta');
            const preview = document.getElementById('slug-preview');
            const slugText = document.getElementById('slug-text');

            if (nombreInput) {
                updateCounter(nombreInput, 'counter-nombre');
            }

            if (telefonoInput) {
                updateCounter(telefonoInput, 'counter-telefono');
            }

            if (correoInput) {
                updateCounter(correoInput, 'counter-correo');
            }

            if (direccionInput) {
                updateCounter(direccionInput, 'counter-direccion');
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