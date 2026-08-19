@extends('layouts.dashboardSitio')
@section('title', 'Redes Sociales y Sitio Web')

@push('styles')
        @vite(['resources/css/dashboard_sitio.css'])
        <style>
            .social-input-group {
                position: relative;
                display: flex;
                align-items: center;
            }
            .social-input-icon {
                position: absolute;
                left: 14px;
                font-size: 1.2rem;
                color: var(--neutro-500);
                pointer-events: none;
            }
            .social-input-field {
                padding-left: 44px !important;
                padding-right: 44px !important;
            }
            .btn-clear-field {
                position: absolute;
                right: 12px;
                background: none;
                border: none;
                color: #94a3b8;
                font-size: 1.1rem;
                cursor: pointer;
                padding: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: color 0.2s ease;
            }
            .btn-clear-field:hover {
                color: #ef4444;
            }
        </style>
@endpush

@section('contenido')

<div class="pagina">
    <div class="form-container">      

        <!-- Cabecera -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Redes Sociales y Sitio Web</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Gestiona los enlaces de redes sociales y el sitio web de tu destino turístico <strong>{{ $sitio->nombre }}</strong>.</p>
            </div>
            <a href="{{ route('dashboard.sitio.inicio') }}" class="step-link" style="font-size: 14.5px;">
                <i class="bi bi-arrow-left-short" style="font-size: 20px; line-height: 1;"></i> Volver al panel
            </a>
        </div>

        @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente)
            <div class="alert alert-warning mb-4 d-flex align-items-center" role="alert" style="background-color: #fef3c7; border: 1px solid #fde68a; color: #92400e; border-radius: 12px; padding: 16px 20px;">
                <i class="bi bi-clock-history fs-4 me-3" style="color: #d97706;"></i>
                <div>
                    <strong>Solicitud en revisión:</strong> Ya tienes una solicitud de actualización de redes sociales pendiente de aprobación. No se pueden realizar modificaciones hasta que la solicitud actual sea procesada.
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4" style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-radius: 12px; padding: 16px 20px;">
                <strong style="display: block; margin-bottom: 6px;"><i class="bi bi-exclamation-triangle-fill me-1"></i> Por favor corrige los siguientes errores:</strong>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="form-redes-sociales" class="form-card" action="{{ route('redes.update') }}" method="POST">
            @csrf
            @method('put')

            <div class="form-section-title">                
                Enlaces de contacto y redes sociales
            </div>

            <p class="hint mb-4" style="margin-bottom: 20px;">
                Ingresa las URLs completas de tus perfiles oficiales. Puedes dejar un campo en blanco o hacer clic en la <strong>X</strong> para eliminar esa red social del perfil del sitio.
            </p>

            {{-- Facebook --}}
            <div class="form-group">
                <label for="facebook">
                    Facebook
                </label>
                <p class="hint">Enlace a la página oficial de Facebook</p>
                <div class="social-input-group">
                    <i class="bi bi-facebook social-input-icon" style="color: #1877F2;"></i>
                    <input 
                        type="url" 
                        id="facebook" 
                        name="facebook" 
                        class="social-input-field"
                        maxlength="255" 
                        placeholder="Ej: https://facebook.com/lapaztravel" 
                        value="{{ old('facebook', optional($perfil)->facebook) }}"
                        @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                    >
                    @if(empty($tieneSolicitudPendiente))
                        <button type="button" class="btn-clear-field" onclick="clearField('facebook')" title="Quitar enlace">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Instagram --}}
            <div class="form-group">
                <label for="instagram">
                    Instagram
                </label>
                <p class="hint">Enlace al perfil de Instagram</p>
                <div class="social-input-group">
                    <i class="bi bi-instagram social-input-icon" style="color: #E4405F;"></i>
                    <input 
                        type="url" 
                        id="instagram" 
                        name="instagram" 
                        class="social-input-field"
                        maxlength="255" 
                        placeholder="Ej: https://instagram.com/lapaztravel" 
                        value="{{ old('instagram', optional($perfil)->instagram) }}"
                        @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                    >
                    @if(empty($tieneSolicitudPendiente))
                        <button type="button" class="btn-clear-field" onclick="clearField('instagram')" title="Quitar enlace">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    @endif
                </div>
            </div>

            {{-- TikTok --}}
            <div class="form-group">
                <label for="tiktok">
                    TikTok
                </label>
                <p class="hint">Enlace a la cuenta de TikTok</p>
                <div class="social-input-group">
                    <i class="bi bi-tiktok social-input-icon" style="color: #000000;"></i>
                    <input 
                        type="url" 
                        id="tiktok" 
                        name="tiktok" 
                        class="social-input-field"
                        maxlength="255" 
                        placeholder="Ej: https://tiktok.com/@lapaztravel" 
                        value="{{ old('tiktok', optional($perfil)->tiktok) }}"
                        @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                    >
                    @if(empty($tieneSolicitudPendiente))
                        <button type="button" class="btn-clear-field" onclick="clearField('tiktok')" title="Quitar enlace">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    @endif
                </div>
            </div>

            {{-- YouTube --}}
            <div class="form-group">
                <label for="youtube">
                    YouTube
                </label>
                <p class="hint">Enlace al canal de YouTube</p>
                <div class="social-input-group">
                    <i class="bi bi-youtube social-input-icon" style="color: #FF0000;"></i>
                    <input 
                        type="url" 
                        id="youtube" 
                        name="youtube" 
                        class="social-input-field"
                        maxlength="255" 
                        placeholder="Ej: https://youtube.com/@lapaztravel" 
                        value="{{ old('youtube', optional($perfil)->youtube) }}"
                        @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                    >
                    @if(empty($tieneSolicitudPendiente))
                        <button type="button" class="btn-clear-field" onclick="clearField('youtube')" title="Quitar enlace">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Sitio Web --}}
            <div class="form-group">
                <label for="sitio_web">
                    Sitio Web
                </label>
                <p class="hint">Página web principal o sitio oficial</p>
                <div class="social-input-group">
                    <i class="bi bi-globe2 social-input-icon" style="color: #0284C7;"></i>
                    <input 
                        type="url" 
                        id="sitio_web" 
                        name="sitio_web" 
                        class="social-input-field"
                        maxlength="255" 
                        placeholder="Ej: https://misitioweb.com" 
                        value="{{ old('sitio_web', optional($perfil)->sitio_web) }}"
                        @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif
                    >
                    @if(empty($tieneSolicitudPendiente))
                        <button type="button" class="btn-clear-field" onclick="clearField('sitio_web')" title="Quitar enlace">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Botones -->
            <div class="btn-actions" style="margin-top: 28px;">
                <a class="btn btn-dark" href="{{ route('dashboard.sitio.inicio') }}">                    
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary" @if(!empty($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled style="opacity: 0.55; cursor: not-allowed;" @endif>
                    <i class="bi bi-send-fill me-1"></i> Guardar solicitud
                </button>                               
            </div>

        </form>
    </div>
</div>
    
@endsection

@push('scripts')
    <script>
        function clearField(fieldId) {
            const input = document.getElementById(fieldId);
            if (input) {
                input.value = '';
                input.focus();
            }
        }
    </script>
@endpush
