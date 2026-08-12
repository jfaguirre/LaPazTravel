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
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.2);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        margin-bottom: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
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
</style>

<div class="dashboard-container">
    <!-- Bienvenida -->
    @php
        $portadaUrl = $sitio->perfil && $sitio->perfil->foto_portada ? asset('storage/' . $sitio->perfil->foto_portada) : null;
    @endphp
    
    <div class="hero-card" style="background: {{ $portadaUrl ? 'linear-gradient(rgba(15, 82, 186, 0.45), rgba(15, 82, 186, 0.75)), url(' . $portadaUrl . ')' : 'linear-gradient(135deg, #0F52BA 0%, #1E6FE0 100%)' }}; background-size: cover; background-position: center;">
        <div class="hero-card__badge">
            <i class="bi bi-patch-check-fill text-success"></i>
            <span>SITIO ACTIVO Y VERIFICADO</span>
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
@endsection