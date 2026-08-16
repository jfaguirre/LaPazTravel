@extends('layouts.dashboardSitio')

@section('title', 'Panel de Control - ' . $sitio->nombre)

@section('contenido')
<style>
    /* Override global main-content styling to be tighter */
    @media (min-width: 768px) {
        .main-content {
            padding: 16px 20px !important;
            background-color: #f1f5f9 !important; /* Unified background */
        }
    }

    .dashboard-container {
        padding: 12px;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Hero Welcome Card */
    .hero-card {
        background: linear-gradient(135deg, #0F52BA 0%, #1E6FE0 100%);
        border-radius: 14px;
        padding: 18px 24px;
        color: white;
        margin-bottom: 16px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(15, 82, 186, 0.1);
        border: none;
    }
    
    .hero-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-card__badge {
        widows: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 6px;                        
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 10px;                
    }

    .hero-card__badge .contenido {
        padding: 4px 10px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .hero-card__badge .icono-portada-edit a {        
        color: var(--primario-50);
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        padding: 2px 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        
    }

    .hero-card__badge .icono-portada-edit a:hover {                       
        opacity: 0.8;        
    }

    .hero-card__badge .icono-portada-edit i {        
        font-size: 18px;
    }

    .hero-card__title {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 6px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        letter-spacing: -0.5px;
    }

    .hero-card__desc {
        font-size: 0.92rem;
        opacity: 0.92;
        max-width: 800px;
        line-height: 1.5;
        margin-bottom: 0;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 12px 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.01);
        border: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.04);
        border-color: #CBD5E1;
    }

    .stat-card__icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .icon-visits { background: #EFF6FF; color: #1E6FE0; }
    .icon-posts { background: #ECFDF5; color: #10B981; }
    .icon-categories { background: #FFF7ED; color: #F97316; }
    .icon-services { background: #EEF2F6; color: #6366F1; }
    .icon-rules { background: #FEF2F2; color: #EF4444; }

    .stat-card__content {
        display: flex;
        flex-direction: column;
    }

    .stat-card__value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0F172A;
        line-height: 1.2;
    }

    .stat-card__label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 1px;
    }

    /* Content Grid */
    .dashboard-grid-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 992px) {
        .dashboard-grid-layout {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    .panel-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.01);
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: border-color 0.25s;
    }

    .panel-card:hover {
        border-color: #CBD5E1;
    }

    .panel-card__title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid #F1F5F9;
        padding-bottom: 8px;
    }

    .panel-card__title i {
        color: #0F52BA;
    }

    /* Info list */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-grow: 1;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .info-item__icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: #F1F5F9;
        color: #64748B;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.92rem;
        flex-shrink: 0;
    }

    .info-item__content {
        display: flex;
        flex-direction: column;
    }

    .info-item__label {
        font-size: 0.68rem;
        font-weight: 800;
        color: #94A3B8;
        text-transform: uppercase;
        margin-bottom: 1px;
        letter-spacing: 0.3px;
    }

    .info-item__value {
        font-size: 0.85rem;
        color: #334155;
        font-weight: 600;
        line-height: 1.3;
    }

    /* Social Icons */
    .social-links {
        display: flex;
        gap: 10px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #F1F5F9;
    }

    .social-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #64748B;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .social-btn:hover {
        color: white;
        transform: scale(1.08) translateY(-1px);
    }

    .social-facebook:hover { background: #1877F2; border-color: #1877F2; }
    .social-instagram:hover { background: #E1306C; border-color: #E1306C; }
    .social-tiktok:hover { background: #000000; border-color: #000000; }
    .social-youtube:hover { background: #FF0000; border-color: #FF0000; }
    .social-web:hover { background: #0F52BA; border-color: #0F52BA; }

    .social-btn.disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .social-btn.disabled:hover {
        background: #F8FAFC;
        color: #64748B;
        transform: none;
        border-color: #E2E8F0;
    }

    /* List items */
    .item-badge-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
    }

    .custom-pill {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .bullet-list {
        list-style: none;
        padding: 0;
        margin: 0 0 12px 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .bullet-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 0.85rem;
        color: #334155;
        font-weight: 600;
        line-height: 1.3;
    }

    .bullet-item i {
        font-size: 0.95rem;
        margin-top: 1px;
    }

    .bullet-item.success i { color: #10B981; }
    .bullet-item.warning i { color: #F59E0B; }

    .empty-state-text {
        font-size: 0.82rem;
        color: #94A3B8;
        font-style: italic;
        margin-bottom: 12px;
    }

    .panel-card__footer {
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid #F1F5F9;
        display: flex;
        justify-content: flex-end;
    }

    .btn-edit-shortcut {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: #F1F5F9;
        color: #475569;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-edit-shortcut:hover {
        background: #E2E8F0;
        color: #0F172A;
    }

    /* Modal Estilos Custom Portada */
    .portada-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        animation: fadeIn 0.25s ease-out;
    }

    .portada-modal-dialog {
        background: #ffffff;
        width: 100%;
        max-width: 620px;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
    }

    .portada-modal-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .portada-modal-close {
        background: none;
        border: none;
        font-size: 1.6rem;
        color: #64748b;
        cursor: pointer;
        line-height: 1;
        transition: color 0.2s;
    }
    .portada-modal-close:hover { color: #0f172a; }

    .portada-modal-body {
        padding: 20px;
        overflow-y: auto;
    }

    .info-box {
        display: flex;
        gap: 12px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.88rem;
        color: #0369a1;
    }

    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px 16px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .upload-zone:hover {
        border-color: #0F52BA;
        background: #f0f7ff;
    }
    .upload-icon {
        font-size: 2.2rem;
        color: #0F52BA;
        margin-bottom: 6px;
        display: block;
    }
    .upload-text {
        margin: 0;
        font-size: 0.9rem;
        color: #334155;
    }
    .upload-hint {
        font-size: 0.78rem;
        color: #64748b;
        display: block;
        margin-top: 4px;
    }

    .hero-card-preview {
        border-radius: 12px;
        padding: 14px 18px;
        color: white;
        position: relative;
        overflow: hidden;
        min-height: 130px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: background 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .preview-badge span {
        font-size: 0.65rem;
        font-weight: 700;
        background: rgba(255,255,255,0.25);
        padding: 2px 8px;
        border-radius: 10px;
        letter-spacing: 0.5px;
    }
    .preview-title {
        font-size: 1.2rem;
        font-weight: 800;
        margin: 6px 0 2px 0;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    .preview-desc {
        font-size: 0.8rem;
        opacity: 0.9;
        margin: 0;
    }

    .portada-modal-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-cancelar {
        background: #e2e8f0;
        color: #334155;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-cancelar:hover { background: #cbd5e1; }

    .btn-enviar-solicitud {
        background: #0F52BA;
        color: #ffffff;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
    }
    .btn-enviar-solicitud:hover:not(:disabled) { background: #1E6FE0; }
    .btn-enviar-solicitud:disabled { opacity: 0.55; cursor: not-allowed; }

    .alert-banner.warning {
        background: #fffbebf5;
        border: 1px solid #fde68a;
        color: #b45309;
        padding: 10px 14px;
        border-radius: 8px;
        margin-bottom: 14px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

<div class="dashboard-container">
    <!-- Bienvenida -->
    @php
        $portadaUrl = null;
        if ($sitio->perfil && $sitio->perfil->foto_portada) {
            $path = $sitio->perfil->foto_portada;
            $portadaUrl = \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', 'uploads/']) 
                ? asset($path) 
                : asset('storage/' . $path);
        }
    @endphp
    
    <div class="hero-card" style="background: {{ $portadaUrl ? 'linear-gradient(rgba(15, 82, 186, 0.45), rgba(15, 82, 186, 0.75)), url(' . $portadaUrl . ')' : 'linear-gradient(135deg, #0F52BA 0%, #1E6FE0 100%)' }}; background-size: cover; background-position: center;">
        <div class="hero-card__badge">            
            <div class="contenido">
                <i class="bi bi-patch-check-fill text-success"></i>
                <span>SITIO ACTIVO Y VERIFICADO</span>
            </div>            

            {{-- Editar portada --}}
            <div class="icono-portada-edit">
                <a href="#" onclick="openPortadaModal(event)" title="Editar foto de portada">
                    <span>Editar</span>
                    <i class="bi bi-pencil-square"></i>
                </a>                
            </div>
        </div>

        <h1 class="hero-card__title">{{ $sitio->nombre }}</h1>
        <p class="hero-card__desc">{{ $sitio->descripcion_corta ?? 'No se ha agregado una descripción corta del sitio todavía. Puedes configurarla en el botón de edición.' }}</p>
    </div>

    <!-- Grid -->
    <div class="stats-grid">
        <!-- Visitas -->
        <div class="stat-card">
            <div class="stat-card__icon icon-visits">
                <i class="bi bi-eye-fill"></i>
            </div>
            <div class="stat-card__content">
                <span class="stat-card__value">{{ number_format($sitio->visitas) }}</span>
                <span class="stat-card__label">Visitas</span>
            </div>
        </div>

        <!-- Publicaciones -->
        <div class="stat-card">
            <div class="stat-card__icon icon-visits">
                <i class="bi bi-journal-richtext"></i>
            </div>
            <div class="stat-card__content">
                <span class="stat-card__value">{{ count($sitio->publicaciones) }}</span>
                <span class="stat-card__label">Publicaciones</span>
            </div>
        </div>

        <!-- Categorias -->
        <div class="stat-card">
            <div class="stat-card__icon icon-visits">
                <i class="bi bi-tags-fill"></i>
            </div>
            <div class="stat-card__content">
                <span class="stat-card__value">{{ $sitio->perfil ? count($sitio->perfil->categorias) : 0 }}</span>
                <span class="stat-card__label">Categorías</span>
            </div>
        </div>

        <!-- Servicios -->
        <div class="stat-card">
            <div class="stat-card__icon icon-visits">
                <i class="bi bi-grid-fill"></i>
            </div>
            <div class="stat-card__content">
                <span class="stat-card__value">{{ $sitio->perfil ? count($sitio->perfil->servicios) : 0 }}</span>
                <span class="stat-card__label">Servicios</span>
            </div>
        </div>

        <!-- Reglas -->
        <div class="stat-card">
            <div class="stat-card__icon icon-visits">
                <i class="bi bi-shield-fill-check"></i>
            </div>
            <div class="stat-card__content">
                <span class="stat-card__value">{{ $sitio->perfil ? count($sitio->perfil->reglas) : 0 }}</span>
                <span class="stat-card__label">Reglas</span>
            </div>
        </div>
    </div>

    <!-- Grid -->
    <div class="dashboard-grid-layout">
        <!-- Col 1: Ubicacion y contacto -->
        <div class="panel-card">
            <h2 class="panel-card__title">
                <i class="bi bi-geo-alt-fill"></i> Contacto y Ubicación
            </h2>
            
            <div class="info-list">
                @if($sitio->perfil)
                    <div class="info-item">
                        <div class="info-item__icon"><i class="bi bi-fingerprint"></i></div>
                        <div class="info-item__content">
                            <span class="info-item__label">Identificador</span>
                            <span class="info-item__value">{{ $sitio->perfil->identificador ?? 'Sin asignar' }}</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-item__icon"><i class="bi bi-telephone-fill"></i></div>
                        <div class="info-item__content">
                            <span class="info-item__label">Teléfono de contacto</span>
                            <span class="info-item__value">{{ $sitio->perfil->telefono ?? 'Sin registrar' }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-item__icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="info-item__content">
                            <span class="info-item__label">Correo Institucional</span>
                            <span class="info-item__value">{{ $sitio->perfil->correo_institucional ?? 'Sin registrar' }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-item__icon"><i class="bi bi-map-fill"></i></div>
                        <div class="info-item__content">
                            <span class="info-item__label">Dirección física</span>
                            <span class="info-item__value">{{ $sitio->perfil->direccion ?? 'Sin registrar' }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-item__icon"><i class="bi bi-building"></i></div>
                        <div class="info-item__content">
                            <span class="info-item__label">Ubicación Administrativa</span>
                            <span class="info-item__value">
                                @if($sitio->perfil->departamento || $sitio->perfil->municipio || $sitio->perfil->distrito)
                                    {{ $sitio->perfil->departamento->departamento ?? '' }}{{ $sitio->perfil->municipio ? ', ' . $sitio->perfil->municipio->municipio : '' }}{{ $sitio->perfil->distrito ? ', ' . $sitio->perfil->distrito->distrito : '' }}
                                @else
                                    Sin especificar ubicación política
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-item__icon"><i class="bi bi-compass-fill"></i></div>
                        <div class="info-item__content">
                            <span class="info-item__label">Coordenadas GPS</span>
                            <span class="info-item__value">
                                @if($sitio->perfil->latitud && $sitio->perfil->longitud)
                                    Lat: {{ $sitio->perfil->latitud }} | Long: {{ $sitio->perfil->longitud }}
                                @else
                                    Sin coordenadas gps registradas
                                @endif
                            </span>
                        </div>
                    </div>
                @else
                    <div class="empty-state-text">
                        No se ha creado un perfil detallado de contacto para este sitio.
                    </div>
                @endif
            </div>
            
            <!-- Redes sociales -->
            <div class="social-links">
                @if($sitio->perfil && $sitio->perfil->facebook)
                    <a href="{{ $sitio->perfil->facebook }}" target="_blank" class="social-btn social-facebook" title="Facebook"><i class="bi bi-facebook"></i></a>
                @else
                    <span class="social-btn disabled" title="Facebook no registrado"><i class="bi bi-facebook"></i></span>
                @endif
                
                @if($sitio->perfil && $sitio->perfil->instagram)
                    <a href="{{ $sitio->perfil->instagram }}" target="_blank" class="social-btn social-instagram" title="Instagram"><i class="bi bi-instagram"></i></a>
                @else
                    <span class="social-btn disabled" title="Instagram no registrado"><i class="bi bi-instagram"></i></span>
                @endif

                @if($sitio->perfil && $sitio->perfil->tiktok)
                    <a href="{{ $sitio->perfil->tiktok }}" target="_blank" class="social-btn social-tiktok" title="TikTok"><i class="bi bi-tiktok"></i></a>
                @else
                    <span class="social-btn disabled" title="TikTok no registrado"><i class="bi bi-tiktok"></i></span>
                @endif

                @if($sitio->perfil && $sitio->perfil->youtube)
                    <a href="{{ $sitio->perfil->youtube }}" target="_blank" class="social-btn social-youtube" title="YouTube"><i class="bi bi-youtube"></i></a>
                @else
                    <span class="social-btn disabled" title="YouTube no registrado"><i class="bi bi-youtube"></i></span>
                @endif

                @if($sitio->perfil && $sitio->perfil->sitio_web)
                    <a href="{{ $sitio->perfil->sitio_web }}" target="_blank" class="social-btn social-web" title="Sitio Web"><i class="bi bi-globe2"></i></a>
                @else
                    <span class="social-btn disabled" title="Sitio Web no registrado"><i class="bi bi-globe2"></i></span>
                @endif
            </div>

            <div class="panel-card__footer">
                <a href="{{ route('perfil.ubicacion.agregar') }}" class="btn-edit-shortcut">
                    <i class="bi bi-pencil-fill"></i> Editar Contacto y Mapa
                </a>
            </div>
        </div>

        <!-- Col 2: contenido y perfil -->
        <div class="panel-card">
            <h2 class="panel-card__title">
                <i class="bi bi-card-checklist"></i> Perfil Turístico
            </h2>

            <!-- Categorias -->
            <div class="info-item__label" style="margin-bottom: 8px;">Categorías del Sitio</div>
            @if($sitio->perfil && count($sitio->perfil->categorias) > 0)
                <div class="item-badge-list">
                    @foreach($sitio->perfil->categorias as $categoria)
                        <span class="custom-pill" style="background-color: {{ $categoria->color ?? '#CBD5E1' }}22; color: {{ $categoria->color ?? '#475569' }}; border: 1px solid {{ $categoria->color ?? '#CBD5E1' }}44;">
                            <i class="bi bi-tag-fill"></i> {{ $categoria->nombre }}
                        </span>
                    @endforeach
                </div>
            @else
                <div class="empty-state-text">Sin categorías asociadas.</div>
            @endif

            <!-- Servicios -->
            <div class="info-item__label" style="margin-bottom: 10px;">Servicios Ofrecidos</div>
            @if($sitio->perfil && count($sitio->perfil->servicios) > 0)
                <ul class="bullet-list">
                    @foreach($sitio->perfil->servicios as $servicio)
                        <li class="bullet-item success">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ $servicio->servicio }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state-text">No se han registrado servicios para este sitio turístico.</div>
            @endif

            <!-- REglas -->
            <div class="info-item__label" style="margin-bottom: 10px;">Reglas e Instrucciones del Sitio</div>
            @if($sitio->perfil && count($sitio->perfil->reglas) > 0)
                <ul class="bullet-list">
                    @foreach($sitio->perfil->reglas as $regla)                    
                        <li class="bullet-item {{ $regla->pivot->permitido ? 'success' : 'danger' }}">
                            <i class="bi {{ $regla->pivot->permitido ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}" style="color: {{ $regla->pivot->permitido ? '#10b981' : '#ef4444' }};"></i>
                            <span>{{ $regla->regla }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state-text">No se han especificado normas o reglas de seguridad.</div>
            @endif

            <div class="panel-card__footer">
                <a href="{{ route('categoria.inicio') }}" class="btn-edit-shortcut" style="margin-right: 8px;">
                    <i class="bi bi-tags-fill"></i> Categorías
                </a>
                <a href="{{ route('servicio.inicio') }}" class="btn-edit-shortcut" style="margin-right: 8px;">
                    <i class="bi bi-grid-fill"></i> Servicios
                </a>
                <a href="{{ route('regla.inicio') }}" class="btn-edit-shortcut">
                    <i class="bi bi-shield-fill-check"></i> Reglas
                </a>
            </div>            
        </div>

        <!-- Mensajes de Estado -->
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert" style="margin-bottom: 24px; border-radius: var(--radius-md); padding: 12px 20px; border: 1px solid rgba(22, 163, 74, 0.2); background-color: var(--success-bg); color: var(--success);">
                    <i class="bi bi-check-circle-fill me-2" style="font-size: 18px; line-height: 1;"></i>
                    <div style="font-weight: 600; font-size: 14.5px;">{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert" style="margin-bottom: 24px; border-radius: var(--radius-md); padding: 12px 20px; border: 1px solid rgba(220, 38, 38, 0.2); background-color: var(--error-bg); color: var(--error);">
                    <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 18px; line-height: 1;"></i>
                    <div style="font-weight: 600; font-size: 14.5px;">{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;"></button>
                </div>
            @endif

    </div>
</div>

<!-- Modal para Editar Foto de Portada -->
<div id="modalPortada" class="portada-modal-backdrop" style="display: none;" onclick="if(event.target === this) closePortadaModal()">
    <div class="portada-modal-dialog">
        <div class="portada-modal-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-image-fill text-primary" style="font-size: 1.3rem;"></i>
                <h5 class="m-0 fw-bold text-dark">Editar Imagen de Portada</h5>
            </div>
            <button type="button" class="portada-modal-close" onclick="closePortadaModal()">&times;</button>
        </div>
        
        <form action="{{ route('portada.update') }}" method="POST" enctype="multipart/form-data" id="form-portada-update">
            @csrf
            @method('PUT')

            <div class="portada-modal-body">
                @if(isset($tieneSolicitudPendiente) && $tieneSolicitudPendiente)
                    <div class="alert-banner warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>Tienes una solicitud de actualización pendiente de aprobación. No podrás enviar una nueva solicitud hasta que sea revisada.</span>
                    </div>
                @endif

                <div class="info-box mb-3">
                    <i class="bi bi-info-circle-fill text-info" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong>Requisitos y recomendaciones para la portada:</strong>
                        <ul class="m-0 pl-3 text-muted" style="font-size: 0.82rem; line-height: 1.4;">
                            <li>Formatos admitidos: <strong>JPG, JPEG, PNG o WEBP</strong>.</li>
                            <li>Tamaño máximo del archivo: <strong>5 MB</strong>.</li>
                            <li>Resolución mínima recomendada: <strong>800 x 300 píxeles</strong> (Proporción landscape ~3:1).</li>
                            <li>La imagen se adaptará automáticamente al contenedor.</li>
                        </ul>
                    </div>
                </div>

                <!--  Arrastrar Drag & Drop -->
                <div class="upload-zone" id="drop-zone-portada" onclick="document.getElementById('input-foto-portada').click()">
                    <i class="bi bi-cloud-arrow-up-fill upload-icon"></i>
                    <p class="upload-text"><strong>Haz clic aquí</strong> o arrastra la nueva imagen de portada</p>
                    <span class="upload-hint">Formatos: JPG, PNG, WEBP (Máx. 5MB)</span>
                    <input type="file" name="foto_portada" id="input-foto-portada" accept="image/jpeg,image/png,image/jpg,image/webp" style="display: none;" onchange="handlePortadaFileSelect(this)">
                </div>

                <!-- Mensaje de Error JS -->
                <div id="portada-file-error" class="text-danger mt-2 fw-bold" style="display: none; font-size: 0.85rem;"></div>

                <!-- Previsualización en Tiempo Real -->
                <div class="preview-container mt-3">
                    <label class="fw-bold text-dark d-block mb-1" style="font-size: 0.85rem;">Vista previa de ajuste:</label>
                    <div class="hero-card-preview" id="hero-preview-box" style="background: {{ $portadaUrl ? 'linear-gradient(rgba(15, 82, 186, 0.45), rgba(15, 82, 186, 0.75)), url(' . $portadaUrl . ')' : 'linear-gradient(135deg, #0F52BA 0%, #1E6FE0 100%)' }}; background-size: cover; background-position: center;">
                        <div class="preview-badge">
                            <span>SITIO ACTIVO Y VERIFICADO</span>
                        </div>
                        <h3 class="preview-title">{{ $sitio->nombre }}</h3>
                        <p class="preview-desc">{{ \Illuminate\Support\Str::limit($sitio->descripcion_corta ?? 'Descripción corta del sitio...', 90) }}</p>
                    </div>
                </div>
            </div>

            <div class="portada-modal-footer">
                <button type="button" class="btn-cancelar" onclick="closePortadaModal()">Cancelar</button>
                <button type="submit" class="btn-enviar-solicitud" id="btn-submit-portada" @if(isset($tieneSolicitudPendiente) && $tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-send-fill me-1"></i> Enviar Solicitud de Aprobación
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openPortadaModal(e) {
    if (e) e.preventDefault();
    document.getElementById('modalPortada').style.display = 'flex';
}

function closePortadaModal() {
    document.getElementById('modalPortada').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone-portada');
    if (dropZone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropZone.style.borderColor = '#0F52BA';
                dropZone.style.background = '#eef6ff';
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropZone.style.borderColor = '#cbd5e1';
                dropZone.style.background = '#f8fafc';
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                const input = document.getElementById('input-foto-portada');
                input.files = files;
                handlePortadaFileSelect(input);
            }
        });
    }
});

function handlePortadaFileSelect(input) {
    const file = input.files[0];
    const errorDiv = document.getElementById('portada-file-error');
    const submitBtn = document.getElementById('btn-submit-portada');
    const previewBox = document.getElementById('hero-preview-box');

    errorDiv.style.display = 'none';
    errorDiv.textContent = '';

    if (!file) return;

    // Validar tipo de archivo
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        errorDiv.textContent = 'Formato no permitido. Selecciona una imagen JPG, PNG o WEBP.';
        errorDiv.style.display = 'block';
        input.value = '';
        if (submitBtn) submitBtn.disabled = true;
        return;
    }

    // Validar tamaño (5MB = 5242880 bytes)
    if (file.size > 5 * 1024 * 1024) {
        errorDiv.textContent = 'La imagen supera el peso máximo permitido de 5 MB.';
        errorDiv.style.display = 'block';
        input.value = '';
        if (submitBtn) submitBtn.disabled = true;
        return;
    }

    // Validar dimensiones y vista previa
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            if (this.width < 800 || this.height < 300) {
                errorDiv.textContent = `Atención: La imagen mide ${this.width}x${this.height}px. Para evitar distorsión en la portada se recomienda un mínimo de 800x300px.`;
                errorDiv.style.display = 'block';
            }
            
            // Actualizar vista previa
            previewBox.style.background = `linear-gradient(rgba(15, 82, 186, 0.45), rgba(15, 82, 186, 0.75)), url(${e.target.result})`;
            previewBox.style.backgroundSize = 'cover';
            previewBox.style.backgroundPosition = 'center';

            const tienePendiente = @json($tieneSolicitudPendiente ?? false);
            if (submitBtn && !tienePendiente) {
                submitBtn.disabled = false;
            }
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>
@endsection