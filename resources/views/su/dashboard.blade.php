@extends('layouts.su')
@section('title', 'Admin Dashboard')

@push('styles')
<style>
    /* Estilos personalizados para colores no nativos de Bootstrap */
    .text-indigo { color: #6610f2 !important; }
    .bg-indigo { background-color: #6610f2 !important; }
    .border-indigo { border-color: #6610f2 !important; }
    
    .tracking-wider { letter-spacing: 0.05em; }
    .card-kpi { transition: transform 0.2s ease, shadow 0.2s ease; }
    .card-kpi:hover { transform: translateY(-3px); }
</style>
@endpush

@section('contenido')
<div class="container py-4 py-lg-5">
    
    <!-- Alertas de estado -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Título de sección -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 text-dark fw-bold mb-1">Panel de Administración</h1>
            <p class="text-muted mb-0">Resumen general y moderación del sitio web</p>
        </div>
    </div>

    <!-- Fila de Tarjetas de Resumen -->
    <div class="row g-3 g-xl-4 mb-5">
        <!-- Sitios Pendientes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-warning card-kpi">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small tracking-wider">Sitios Pendientes</span>
                        <h2 class="display-6 fw-bold text-warning mb-0 mt-1">{{ $sitiosPendientesCount }}</h2>
                    </div>
                    <div class="p-3 bg-warning bg-opacity-10 rounded-circle text-warning d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sitios Activos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-success card-kpi">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small tracking-wider">Sitios Aprobados</span>
                        <h2 class="display-6 fw-bold text-success mb-0 mt-1">{{ $totalSitiosActivos }}</h2>
                    </div>
                    <div class="p-3 bg-success bg-opacity-10 rounded-circle text-success d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-check-circle fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Usuarios -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-primary card-kpi">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small tracking-wider">Total Usuarios</span>
                        <h2 class="display-6 fw-bold text-primary mb-0 mt-1">{{ $totalUsuarios }}</h2>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 rounded-circle text-primary d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visitas Totales -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-indigo card-kpi">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small tracking-wider">Visitas Totales</span>
                        <h2 class="display-6 fw-bold text-indigo mb-0 mt-1">{{ $totalVisitas }}</h2>
                    </div>
                    <div class="p-3 bg-indigo bg-opacity-10 rounded-circle text-indigo d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-eye fs-3"></i>
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
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shield-exclamation text-warning fs-5"></i>
                        <h5 class="mb-0 fw-bold text-dark">Sitios por Aprobar</h5>
                    </div>
                    @if(count($sitiosPendientes) > 0)
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle rounded-pill px-3 py-2 fw-semibold">
                            {{ count($sitiosPendientes) }} pendientes
                        </span>
                    @else
                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-3 py-2 fw-semibold">
                            Al día
                        </span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Nombre del Sitio</th>
                                    <th class="py-3">Propietario</th>
                                    <th class="pe-4 py-3 text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sitiosPendientes as $sitio)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <span class="fw-semibold text-dark">{{ $sitio->nombre }}</span>
                                        </td>
                                        <td class="py-3 text-secondary">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-person-circle text-muted"></i>
                                                <span>{{ $sitio->usuario->name }}</span>
                                            </div>
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            <a href="{{ route('su.sitios.revisar', $sitio->id) }}" class="btn btn-sm btn-dark rounded-2 px-3 shadow-sm">
                                                <i class="bi bi-eye-fill me-1"></i> Revisar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-5 text-center text-muted">
                                            <div class="py-3">
                                                <i class="bi bi-check-circle-fill text-success fs-1 d-block mb-2"></i>
                                                <p class="mb-0 fw-medium">No hay solicitudes pendientes en este momento.</p>
                                            </div>
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
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-person-plus text-primary fs-5"></i>
                        <h5 class="mb-0 fw-bold text-dark">Nuevos Usuarios</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Usuario</th>
                                    <th class="pe-4 py-3 text-end">Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosUsuarios as $usuario)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-primary bg-opacity-10 text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; font-size: 0.85rem;">
                                                    {{ strtoupper(substr($usuario->name, 0, 1)) }}{{ strtoupper(substr($usuario->lastName, 0, 1)) }}
                                                </div>
                                                <div class="text-truncate" style="max-width: 200px;">
                                                    <div class="fw-semibold text-dark text-truncate">{{ $usuario->name }} {{ $usuario->lastName }}</div>
                                                    <div class="text-muted small text-truncate">{{ $usuario->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="pe-4 py-3 text-end text-muted small">
                                            {{ $usuario->created_at->format('d M, Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-muted">
                                            <p class="mb-0 small">No hay usuarios registrados recientemente.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection