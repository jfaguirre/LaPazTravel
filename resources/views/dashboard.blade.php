@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
        @vite(['resources/css/dashboard_sitio.css'])
@endpush
    

@section('contenido')

<div id="page-dashboard" class="page">
    <div class="dashboard-card">
        <!-- Alertas de estado -->
        @if(session('success'))
            <div class="alert alert-success" style="padding: 12px; margin-bottom: 24px; border-radius: 8px; border: 1px solid #c3e6cb; background-color: #d4edda; color: #155724; font-size: 14px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="padding: 12px; margin-bottom: 24px; border-radius: 8px; border: 1px solid #f5c6cb; background-color: #f8d7da; color: #721c24; font-size: 14px; font-weight: 500;">
                {{ session('error') }}
            </div>
        @endif

        <div class="dashboard-grid">
            <div class="dashboard-left">
                <h1>Crea la ficha de tu sitio turístico</h1>
                <p>Registra la información principal de tu destino para que pueda ser explorado por miles de visitantes. Completa cada sección con datos precisos y reales. Una vez completada cada sección, podrás enviar la solicitud para que pueda ser revisada y aprobada.</p>
                
                @if(!$hasSitio)
                    <div class="form-actions" style="margin-top: 10px; justify-content: flex-start;">
                        <a href="{{ route('sitio.create') }}" class="btn btn-dark boton">
                            Iniciar ahora                
                        </a>
                    </div>
                @endif
            </div>

            <div class="dashboard-right">
                <!-- Sección de Avance -->
                <div class="dashboard-progress-section">
                    <div class="progress-header">
                        <h3>Avance del Sitio</h3>
                        <span class="progress-percentage">{{ round($percentage) }}% completado</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $percentage }}%;"></div>
                    </div>

                    <div class="steps-list">
                        <!-- Paso 1: Datos Generales -->
                        <div class="step-item">
                            <div class="step-info">
                                <div class="step-icon">
                                    <i class="bi bi-globe2"></i>
                                </div>
                                <div class="step-details">
                                    <h4>Datos generales</h4>
                                    <p>Nombre, slug y descripción</p>
                                </div>
                            </div>
                            <div class="step-actions">
                                @if($hasSitio)
                                    <span class="badge badge-completed">Completado</span>
                                    <a href="{{ route('sitio.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
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
                                    <i class="bi bi-tag"></i>
                                </div>
                                <div class="step-details">
                                    <h4>Categoría</h4>
                                    <p>Categorización de la atracción</p>
                                </div>
                            </div>
                            <div class="step-actions">
                                @if($hasCategoria)
                                    <span class="badge badge-completed">Completado</span>
                                    <a href="{{ route('categoria.create') }}" class="step-link">Editar/Añadir <i class="bi bi-pencil-square"></i></a>
                                @else
                                    <span class="badge badge-pending">Pendiente</span>
                                    @if($hasSitio)
                                        <a href="{{ route('categoria.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                                    @else
                                        <span style="font-size: 13px; color: var(--neutro-500);"><i class="bi bi-lock-fill"></i> Bloqueado</span>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Paso 3: Regla -->
                        <div class="step-item">
                            <div class="step-info">
                                <div class="step-icon">
                                    <i class="bi bi-shield-fill-exclamation"></i>
                                </div>
                                <div class="step-details">
                                    <h4>Reglas de Convivencia</h4>
                                    <p>Normas para visitantes</p>
                                </div>
                            </div>
                            <div class="step-actions">
                                @if($hasRegla)
                                    <span class="badge badge-completed">Completado</span>
                                    <a href="{{ route('regla.create') }}" class="step-link">Editar/Añadir <i class="bi bi-pencil-square"></i></a>
                                @else
                                    <span class="badge badge-pending">Pendiente</span>
                                    @if($hasSitio)
                                        <a href="{{ route('regla.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                                    @else
                                        <span style="font-size: 13px; color: var(--neutro-500);"><i class="bi bi-lock-fill"></i> Bloqueado</span>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Paso 4: Servicio -->
                        <div class="step-item">
                            <div class="step-info">
                                <div class="step-icon">
                                    <i class="bi bi-briefcase-fill"></i>
                                </div>
                                <div class="step-details">
                                    <h4>Servicios Disponibles</h4>
                                    <p>Comodidades y facilidades</p>
                                </div>
                            </div>
                            <div class="step-actions">
                                @if($hasServicio)
                                    <span class="badge badge-completed">Completado</span>
                                    <a href="{{ route('servicio.create') }}" class="step-link">Editar/Añadir <i class="bi bi-pencil-square"></i></a>
                                @else
                                    <span class="badge badge-pending">Pendiente</span>
                                    @if($hasSitio)
                                        <a href="{{ route('servicio.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                                    @else
                                        <span style="font-size: 13px; color: var(--neutro-500);"><i class="bi bi-lock-fill"></i> Bloqueado</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
    
@endsection

