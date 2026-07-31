@extends('layouts.su')
@section('title', 'Administración de Sitios')

@section('contenido')
<div class="container py-4 py-lg-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i> 
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark mb-1 fw-bold">Control de Sitios</h1>
            <p class="text-muted mb-0">Listado, filtrado y gestión de todos los establecimientos registrados</p>
        </div>
    </div>

    <!-- Tarjeta Compacta de Filtros -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('super.sitio.index') }}" method="GET" id="filtroForm">
                
                <!-- Input Oculto de Estado -->
                <input type="hidden" name="estado" id="input_estado" value="{{ request('estado') }}">

                <!-- 1. Filtro por Estado (Botones Filtro Compactos) -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase d-block mb-2">
                        <i class="bi bi-funnel me-1"></i> Estado del Sitio
                    </label>
                    <div class="d-flex flex-wrap gap-2" id="container-estados">
                        @php $e = request('estado', ''); @endphp
                        
                        <button type="button" 
                                class="btn btn-sm {{ $e === '' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3 fw-semibold shadow-sm btn-estado"
                                data-estado="" 
                                data-default-class="btn-outline-secondary" 
                                data-active-class="btn-dark">
                            <i class="bi bi-grid-fill me-1"></i> Todos
                        </button>

                        <button type="button" 
                                class="btn btn-sm {{ $e === 'PENDIENTE' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} rounded-pill px-3 fw-semibold shadow-sm btn-estado"
                                data-estado="PENDIENTE" 
                                data-default-class="btn-outline-warning text-dark" 
                                data-active-class="btn-warning text-dark">
                            <i class="bi bi-hourglass-split me-1"></i> Pendientes
                        </button>

                        <button type="button" 
                                class="btn btn-sm {{ $e === 'APROBADO' ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3 fw-semibold shadow-sm btn-estado"
                                data-estado="APROBADO" 
                                data-default-class="btn-outline-success" 
                                data-active-class="btn-success">
                            <i class="bi bi-check-circle-fill me-1"></i> Aprobados
                        </button>

                        <button type="button" 
                                class="btn btn-sm {{ $e === 'RECHAZADO' ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill px-3 fw-semibold shadow-sm btn-estado"
                                data-estado="RECHAZADO" 
                                data-default-class="btn-outline-danger" 
                                data-active-class="btn-danger">
                            <i class="bi bi-x-circle-fill me-1"></i> Rechazados
                        </button>

                        <button type="button" 
                                class="btn btn-sm {{ $e === 'SUSPENDIDO' ? 'btn-secondary' : 'btn-outline-secondary' }} rounded-pill px-3 fw-semibold shadow-sm btn-estado"
                                data-estado="SUSPENDIDO" 
                                data-default-class="btn-outline-secondary" 
                                data-active-class="btn-secondary">
                            <i class="bi bi-dash-circle-fill me-1"></i> Suspendidos
                        </button>
                    </div>
                </div>

                <hr class="text-muted opacity-25 my-3">

                <!-- 2. Fila Grid Compacta: Búsqueda + Desplegables de Ubicación -->
                <div class="row g-2 align-items-end">
                    
                    <!-- Buscar Texto -->
                    <div class="col-12 col-md-3">
                        <label for="search" class="form-label small fw-bold text-muted text-uppercase mb-1">Buscar</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0" id="search" name="search" value="{{ request('search') }}" placeholder="Nombre, propietario, email...">
                        </div>
                    </div>

                    <!-- Departamento -->
                    <div class="col-12 col-md-3">
                        <label for="select_departamento" class="form-label small fw-bold text-muted text-uppercase mb-1">
                            <i class="bi bi-geo-alt me-1"></i> Departamento
                        </label>
                        <select class="form-select form-select-sm bg-light" id="select_departamento" name="departamento">
                            <option value="">Todos los Departamentos</option>
                            @foreach($departamentos as $dep)
                                <option value="{{ $dep->id }}" {{ request('departamento') == $dep->id ? 'selected' : '' }}>
                                    {{ $dep->departamento }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Municipio -->
                    <div class="col-12 col-md-2.5 col-lg-2">
                        <label for="select_municipio" class="form-label small fw-bold text-muted text-uppercase mb-1">
                            <i class="bi bi-building me-1"></i> Municipio
                        </label>
                        <select class="form-select form-select-sm bg-light" id="select_municipio" name="municipio_id" {{ !request('departamento') ? 'disabled' : '' }}>
                            <option value="">Todos</option>
                        </select>
                    </div>

                    <!-- Distrito -->
                    <div class="col-12 col-md-2.5 col-lg-2">
                        <label for="select_distrito" class="form-label small fw-bold text-muted text-uppercase mb-1">
                            <i class="bi bi-pin-map me-1"></i> Distrito
                        </label>
                        <select class="form-select form-select-sm bg-light" id="select_distrito" name="distrito_id" {{ !request('municipio_id') ? 'disabled' : '' }}>
                            <option value="">Todos</option>
                        </select>
                    </div>

                    <!-- Botón Limpiar -->
                    <div class="col-12 col-md-1 col-lg-2 ms-auto">
                        <a href="{{ route('super.sitio.index') }}" class="btn btn-sm btn-outline-secondary w-100 fw-semibold" title="Limpiar filtros">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                        </a>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <!-- Contenedor Relativo para el Spinner y Tabla -->
    <div class="position-relative">

        <!-- Spinner de Carga Overlay (Oculto por defecto) -->
        <div id="loading-overlay" 
             class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-none align-items-center justify-content-center rounded" 
             style="z-index: 10; transition: opacity 0.2s ease-in-out;">
            <div class="text-center p-4">
                <div class="spinner-border text-primary mb-2" role="status" style="width: 2.2rem; height: 2.2rem;">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="small text-muted fw-semibold mb-0">Buscando sitios...</p>
            </div>
        </div>

        <!-- Contenedor Dinámico para la Tabla AJAX -->
        <div class="card shadow-sm border-0" id="tabla-sitios-container">
            @include('super.sitio.partials.tabla')
        </div>

    </div>

</div>
@endsection

@push('scripts')
@vite(['resources/js/super/ubicacion-cascada.js'])
@endpush