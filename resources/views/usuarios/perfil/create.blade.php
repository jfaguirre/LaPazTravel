@extends('layouts.app')
@section('title', 'Crear Perfil del Sitio')

@push('styles')
    @vite(['resources/css/dashboard_sitio.css'])
@endpush
    
@section('contenido')
<div id="page-dashboard" class="page">
    <div class="dashboard-card">
        <!-- Título principal de la sección -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 16px; display:flex; justify-content:space-between; flex-wrap: wrap; gap:15px">
            <div class="contenido">
                <h1 style="font-size: 28px; font-weight: 800; color: var(--neutro-900); margin: 0;">Configuración de tu Sitio Turístico</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Completa los pasos requeridos para registrar tu destino en La Paz Travel.</p>
            </div>            
            <livewire:solicitar-aprobacion />
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

        <div class="dashboard-grid">
            <!-- Columna Izquierda: Formularios y Progreso -->
            <div class="dashboard-left">
                <!-- Sección de Progreso -->
                <div class="dashboard-progress-section">
                    <div class="progress-header">
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--neutro-800); margin: 0;">Progreso de Registro</h3>
                        <span class="progress-percentage">{{ $progreso }}% Completado</span>
                    </div>
                    <div class="progress-bar-container" style="margin-bottom: 24px;">
                        <div class="progress-bar-fill" style="width: {{ $progreso }}%;"></div>
                    </div>
                </div>

                <!-- Lista de Formularios (Pasos) -->               
                <livewire:progreso-solicitud />
                    {{-- <div class="steps-list">
                        @if($sitio->estado == 'BORRADOR')
                            <!-- Paso 1: Sitio -->
                            <div class="step-item">
                                <div class="step-info">
                                    <div class="step-icon">
                                        <span style="font-weight: 700;">1</span>
                                    </div>
                                    <div class="step-details">
                                        <h4>Sitio Turístico</h4>
                                        <p>Datos generales, ubicación y contacto.</p>
                                    </div>
                                </div>
                                <div class="step-actions">                            
                                    @if($hasSitio)
                                        <span class="badge badge-completed">Completado</span>
                                        <a href="{{ route('sitio.edit') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                                    @else
                                        <span class="badge badge-pending">Pendiente</span>
                                        <a href="{{ route('sitio.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                                    @endif                           
                                </div>
                            </div>

                            <!-- Paso 2: Categoría -->
                            <div class="step-item">
                                <div class="step-info">
                                    <div class="step-icon">
                                        <span style="font-weight: 700;">2</span>
                                    </div>
                                    <div class="step-details">
                                        <h4>Categoría</h4>
                                        <p>Clasificación y tipo de experiencia turística.</p>
                                    </div>
                                </div>
                                <div class="step-actions">                            
                                    @if($hasSitio)
                                        @if($hasCategoria)
                                            <span class="badge badge-completed">Completado</span>
                                            <a href="{{ route('perfil.categoria.agregar') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                                        @else
                                            <span class="badge badge-pending">Pendiente</span>
                                            <a href="{{ route('perfil.categoria.agregar') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                                        @endif
                                    @else
                                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                                            Bloqueado <i class="bi bi-lock-fill"></i>
                                        </span>
                                    @endif                           
                                </div>                        
                            </div>

                            <!-- Paso 3: Reglas -->
                            <div class="step-item">
                                <div class="step-info">
                                    <div class="step-icon">
                                        <span style="font-weight: 700;">3</span>
                                    </div>
                                    <div class="step-details">
                                        <h4>Reglas</h4>
                                        <p>Normativas de seguridad y pautas de visita.</p>
                                    </div>
                                </div>
                                <div class="step-actions">                            
                                    @if($hasSitio)
                                        @if($hasRegla)
                                            <span class="badge badge-completed">Completado</span>
                                            <a href="{{ route('perfil.regla.agregar') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                                        @else
                                            <span class="badge badge-pending">Pendiente</span>
                                            <a href="{{ route('perfil.regla.agregar') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                                        @endif
                                    @else
                                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                                            Bloqueado <i class="bi bi-lock-fill"></i>
                                        </span>
                                    @endif                           
                                </div>                        
                            </div>

                            <!-- Paso 4: Servicios -->
                            <div class="step-item">
                                <div class="step-info">
                                    <div class="step-icon">
                                        <span style="font-weight: 700;">4</span>
                                    </div>
                                    <div class="step-details">
                                        <h4>Servicios</h4>
                                        <p>Facilidades y comodidades disponibles.</p>
                                    </div>
                                </div>
                                <div class="step-actions">                            
                                    @if($hasSitio)
                                        @if($hasServicio)
                                            <span class="badge badge-completed">Completado</span>
                                            <a href="{{ route('perfil.servicio.agregar') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                                        @else
                                            <span class="badge badge-pending">Pendiente</span>
                                            <a href="{{ route('perfil.servicio.agregar') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                                        @endif
                                    @else
                                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                                            Bloqueado <i class="bi bi-lock-fill"></i>
                                        </span>
                                    @endif                           
                                </div> 
                            </div>
                        @endif
                        @if($sitio->estado == 'PENDIENTE')                            
                            <img src="{{ asset('assets/images/solicitud_enviada.svg') }}" alt="Ilustración de registro" style="max-width: 20%; height: auto; opacity: 0.95; transition: transform 0.3s ease; margin: 40px auto" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                            <h5>Solicitud enviada</h5>
                            <p>Puedes cancelar la solicitud en cualquier momento mientras este pendiente.</p>
                        @endif
                    </div> --}}
                

            </div>

            <!-- Columna Derecha: Imagen y Contexto Informativo -->
            <div class="dashboard-right" style="padding-left: 12px;">
                <div style="background-color: var(--primario-50); border-radius: var(--radius-md); padding: 24px; border: 1px solid var(--primario-100); margin-bottom: 24px;">
                    <h2 style="font-size: 20px; font-weight: 700; color: var(--primario-oscuro); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información Importante
                    </h2>
                    <p style="font-size: 14.5px; line-height: 1.6; color: var(--neutro-700); margin-bottom: 12px;">
                        Para publicar tu sitio turístico en nuestra plataforma, es fundamental que completes la información en cada una de las secciones indicadas.
                    </p>
                    <p style="font-size: 14.5px; line-height: 1.6; color: var(--neutro-700); margin: 0;">
                        Los detalles que ingreses sobre el <strong>Sitio</strong>, su <strong>Categoría</strong>, las <strong>Reglas</strong> y los <strong>Servicios</strong> permitirán a los turistas planificar mejor su viaje y disfrutar de una experiencia segura en el departamento de La Paz.
                    </p>
                </div>

                <div class="imagen" style="display: flex; justify-content: center; align-items: center; padding: 12px;">
                    <img src="{{ asset('assets/images/progreso.svg') }}" alt="Ilustración de registro" style="max-width: 80%; height: auto; opacity: 0.95; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
