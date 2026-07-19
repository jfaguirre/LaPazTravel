@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('contenido')
<div class="container py-5">
    
    <!-- Alertas de estado -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Título de sección -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-0 font-weight-bold">Panel de Administración</h1>
            <p class="text-muted mb-0">Resumen general y moderación del sitio web</p>
        </div>
    </div>

    <!-- Fila de Tarjetas de Resumen -->
    <div class="row g-4 mb-5">
        <!-- Sitios Pendientes -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted small font-weight-bold">Sitios Pendientes</span>
                        <h2 class="h2 mb-0 font-weight-bold text-warning mt-1">{{ $sitiosPendientesCount }}</h2>
                    </div>
                    <div class="fs-1 text-warning-50 opacity-75">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sitios Activos -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0" style="border-left: 4px solid #198754 !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted small font-weight-bold">Sitios Aprobados</span>
                        <h2 class="h2 mb-0 font-weight-bold text-success mt-1">{{ $totalSitiosActivos }}</h2>
                    </div>
                    <div class="fs-1 text-success-50 opacity-75">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Usuarios -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted small font-weight-bold">Total Usuarios</span>
                        <h2 class="h2 mb-0 font-weight-bold text-primary mt-1">{{ $totalUsuarios }}</h2>
                    </div>
                    <div class="fs-1 text-primary-50 opacity-75">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visitas Totales -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0" style="border-left: 4px solid #6f42c1 !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted small font-weight-bold">Visitas Totales</span>
                        <h2 class="h2 mb-0 font-weight-bold text-purple mt-1" style="color: #6f42c1;">{{ $totalVisitas }}</h2>
                    </div>
                    <div class="fs-1 opacity-75" style="color: #6f42c1;">
                        <i class="bi bi-eye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cuadrícula Principal -->
    <div class="row g-4">
        
        <!-- Tabla: Sitios Esperando Aprobación -->
        <div class="col-12 col-xl-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom-0">
                    <h5 class="mb-0 font-weight-bold text-gray-800">Sitios por Aprobar</h5>
                    <span class="badge bg-warning text-dark font-weight-bold">Acción Requerida</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Nombre del Sitio</th>
                                    <th class="px-4 py-3">Propietario</th>
                                    <th class="px-4 py-3 text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sitiosPendientes as $sitio)
                                    <tr>
                                        <td class="px-4 py-3 font-weight-semibold">{{ $sitio->nombre }}</td>
                                        <td class="px-4 py-3 text-muted">
                                            <i class="bi bi-person me-1"></i> {{ $sitio->usuario->name }}
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <a href="{{ route('admin.sitios.revisar', $sitio->id) }}" class="btn btn-sm btn-outline-dark">
                                                <i class="bi bi-eye-fill"></i> Revisar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-5 text-center text-muted">
                                            <i class="bi bi-emoji-smile fs-2 d-block mb-2"></i>
                                            No hay solicitudes pendientes en este momento.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla: Últimos Usuarios Registrados -->
        <div class="col-12 col-xl-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 font-weight-bold text-gray-800">Nuevos Usuarios</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Usuario</th>
                                    <th class="px-4 py-3 text-end">Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimosUsuarios as $usuario)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-weight-semibold">{{ $usuario->name }} {{ $usuario->lastName }}</div>
                                            <span class="text-muted small">{{ $usuario->email }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-end text-muted small">
                                            {{ $usuario->created_at->format('d M, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection