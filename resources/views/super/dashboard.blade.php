@extends('layouts.su')
@section('title', 'Admin Dashboard')

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

    <!-- Encabezado con Acciones Rápidas -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 text-dark fw-bold mb-1">Panel de Administración</h1>
            <p class="text-muted mb-0">Resumen general, métricas y moderación del sitio web</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('super.sitio.index') }}" class="btn btn-outline-dark btn-sm rounded-2 shadow-sm">
                <i class="bi bi-grid-fill me-1"></i> Gestionar Sitios
            </a>
            <a href="{{ route('super.usuario.index') }}" class="btn btn-dark btn-sm rounded-2 shadow-sm">
                <i class="bi bi-people-fill me-1"></i> Gestionar Usuarios
            </a>
        </div>
    </div>

    <!-- Fila de Tarjetas KPI Primarias -->
    <div class="row g-3 g-xl-4 mb-4">
        <!-- Sitios Pendientes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-warning">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small text-nowrap">Por Aprobar</span>
                        <h2 class="display-6 fw-bold text-warning mb-0 mt-1">{{ $sitiosPendientesCount }}</h2>
                    </div>
                    <div class="p-3 bg-warning-subtle rounded-circle text-warning d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sitios Aprobados -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-success">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small text-nowrap">Sitios Activos</span>
                        <h2 class="display-6 fw-bold text-success mb-0 mt-1">{{ $totalSitiosActivos }}</h2>
                    </div>
                    <div class="p-3 bg-success-subtle rounded-circle text-success d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-check-circle fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Usuarios -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-primary">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small text-nowrap">Total Usuarios</span>
                        <h2 class="display-6 fw-bold text-primary mb-0 mt-1">{{ $totalUsuarios }}</h2>
                    </div>
                    <div class="p-3 bg-primary-subtle rounded-circle text-primary d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visitas Totales -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-info">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small text-nowrap">Visitas Totales</span>
                        <h2 class="display-6 fw-bold text-info mb-0 mt-1">{{ number_format($totalVisitas) }}</h2>
                    </div>
                    <div class="p-3 bg-info-subtle rounded-circle text-info d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-eye fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Métrico Secundario: Estado Global de Contenidos -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-white p-3">
                <div class="row align-items-center text-center text-md-start g-3">
                    <div class="col-md-3">
                        <span class="text-muted small fw-bold text-uppercase d-block">Distribución de Plataforma</span>
                        <span class="fw-semibold text-dark">Estado General de Sitios</span>
                    </div>
                    <div class="col-6 col-md-3 border-start">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <span class="badge bg-danger rounded-circle p-1"> </span>
                            <span class="text-muted small">Rechazados:</span>
                            <span class="fw-bold text-dark">{{ $sitiosRechazadosCount }}</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 border-start">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <span class="badge bg-secondary rounded-circle p-1"> </span>
                            <span class="text-muted small">Suspendidos:</span>
                            <span class="fw-bold text-dark">{{ $sitiosSuspendidosCount }}</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 border-start text-md-end">
                        <a href="{{ route('super.sitio.index') }}" class="btn btn-link btn-sm text-decoration-none p-0 fw-semibold">
                            Ver todos los filtros <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cuadrícula Principal -->
    <div class="row g-4 mb-4">

        <!-- Tabla 1: Sitios Esperando Aprobación -->
        <div class="col-12 col-xl-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shield-exclamation text-warning fs-5"></i>
                        <h5 class="mb-0 fw-bold text-dark">Pendientes de Moderación</h5>
                    </div>
                    @if(count($sitiosPendientes) > 0)
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2 fw-semibold">
                            {{ count($sitiosPendientes) }} pendientes
                        </span>
                    @else
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fw-semibold">
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
                                                <span>{{ $sitio->usuario->name ?? 'Sin usuario' }}</span>
                                            </div>
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            <a href="{{ route('super.sitio.revisar', $sitio->id) }}" class="btn btn-sm btn-dark rounded-2 px-3 shadow-sm">
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

        <!-- Tabla 2: Sitios Más Visitados -->
        <div class="col-12 col-xl-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-trophy-fill text-warning fs-5"></i>
                        <h5 class="mb-0 fw-bold text-dark">Top Sitios Más Visitados</h5>
                    </div>
                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-1 small">
                        Populares
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Sitio</th>
                                    <th class="pe-4 py-3 text-end">Visitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sitiosMasVisitados as $sitio)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-semibold text-dark">{{ $sitio->nombre }}</div>
                                            <div class="text-muted small">Por: {{ $sitio->usuario->name ?? 'Desconocido' }}</div>
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            <span class="badge bg-info-subtle text-info fw-bold fs-6 px-3 py-1">
                                                <i class="bi bi-eye me-1"></i>{{ number_format($sitio->visitas) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-muted">
                                            <p class="mb-0 small">No hay registros de visitas disponibles.</p>
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

    <!-- Cuadrícula Secundaria: Usuarios Registrados -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-person-plus-fill text-primary fs-5"></i>
                        <h5 class="mb-0 fw-bold text-dark">Últimos Usuarios Registrados</h5>
                    </div>
                    <a href="{{ route('super.usuario.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        Ver todos
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Usuario</th>
                                    <th class="py-3">Rol</th>
                                    <th class="pe-4 py-3 text-end">Fecha Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosUsuarios as $usuario)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-primary-subtle text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; font-size: 0.85rem;">
                                                    {{ strtoupper(substr($usuario->name, 0, 1)) }}{{ strtoupper(substr($usuario->lastName ?? '', 0, 1)) }}
                                                </div>
                                                <div class="text-truncate" style="max-width: 250px;">
                                                    <div class="fw-semibold text-dark text-truncate">{{ $usuario->name }} {{ $usuario->lastName }}</div>
                                                    <div class="text-muted small text-truncate">{{ $usuario->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            @forelse($usuario->roles as $rol)
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2 py-1 small">
                                                    {{ $rol->name }}
                                                </span>
                                            @empty
                                                <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small">
                                                    Sin rol
                                                </span>
                                            @endforelse
                                        </td>
                                        <td class="pe-4 py-3 text-end text-muted small">
                                            {{ $usuario->created_at ? $usuario->created_at->format('d M, Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-muted">
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