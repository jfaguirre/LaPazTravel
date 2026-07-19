@extends('layouts.app')
@section('title', 'Administración de Sitios')

@section('contenido')
<div class="container py-5">
    
    <!-- Alertas de estado -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Título de sección -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-0 font-weight-bold">Control de Sitios</h1>
            <p class="text-muted mb-0">Listado, filtrado y gestión de todos los establecimientos registrados</p>
        </div>
    </div>

    <!-- Tarjeta de Filtros Avanzados -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.sitios.index') }}" method="GET" class="row g-3">
                
                <!-- Búsqueda por palabra clave -->
                <div class="col-12 col-md-4">
                    <label for="search" class="form-label small font-weight-bold text-muted text-uppercase">Buscar Sitio / Propietario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" id="search" name="search" value="{{ request('search') }}" placeholder="Nombre, email o dueño...">
                    </div>
                </div>

                <!-- Filtrar por Estado -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="estado" class="form-label small font-weight-bold text-muted text-uppercase">Estado del Sitio</label>
                    <select class="form-select bg-light" id="estado" name="estado">
                        <option value="">Todos los estados</option>
                        <option value="PENDIENTE" {{ request('estado') == 'PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
                        <option value="APROBADO" {{ request('estado') == 'APROBADO' ? 'selected' : '' }}>Aprobado</option>
                        <option value="RECHAZADO" {{ request('estado') == 'RECHAZADO' ? 'selected' : '' }}>Rechazado</option>
                        <option value="SUSPENDIDO" {{ request('estado') == 'SUSPENDIDO' ? 'selected' : '' }}>Suspendido</option>
                    </select>
                </div>

                <!-- Filtrar por Departamento -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="departamento" class="form-label small font-weight-bold text-muted text-uppercase">Departamento</label>
                    <select class="form-select bg-light" id="departamento" name="departamento">
                        <option value="">Todos los departamentos</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}" {{ request('departamento') == $dep->id ? 'selected' : '' }}>
                                {{ $dep->departamento }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botones de Acción -->
                <div class="col-12 col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-dark w-100 font-weight-bold shadow-sm">
                        <i class="bi bi-funnel-fill me-1"></i> Filtrar
                    </button>
                    @if(request()->hasAny(['search', 'estado', 'departamento']))
                        <a href="{{ route('admin.sitios.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- Tabla Principal de Sitios -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Nombre del Sitio</th>
                            <th class="px-4 py-3">Propietario</th>
                            <th class="px-4 py-3">Ubicación</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sitios as $sitio)
                            <tr>
                                <!-- Nombre del sitio e identificador -->
                                <td class="px-4 py-3">
                                    <div class="font-weight-semibold text-dark">{{ $sitio->nombre }}</div>
                                    @if($sitio->perfil && $sitio->perfil->identificador)
                                        <span class="text-muted small"><code>{{ $sitio->perfil->identificador }}</code></span>
                                    @endif
                                </td>
                                
                                <!-- Dueño -->
                                <td class="px-4 py-3 text-muted">
                                    <div class="text-dark font-weight-medium">{{ $sitio->usuario->name }} {{ $sitio->usuario->lastName }}</div>
                                    <span class="small d-block">{{ $sitio->usuario->email }}</span>
                                </td>
                                
                                <!-- Ubicación (Departamento / Distrito) -->
                                <td class="px-4 py-3 text-muted small">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $sitio->perfil->departamento->departamento ?? 'No especificado' }} 
                                    @if(isset($sitio->perfil->distrito))
                                        <span class="text-muted d-block ps-3">({{ $sitio->perfil->distrito->distrito }})</span>
                                    @endif
                                </td>
                                
                                <!-- Badge de Estado Dinámico -->
                                <td class="px-4 py-3 text-center">
                                    @if($sitio->estado === 'PENDIENTE' || $sitio->estado === null)
                                        <span class="badge bg-warning text-dark px-3 py-2 font-weight-bold">
                                            <i class="bi bi-hourglass-split me-1"></i> Pendiente
                                        </span>
                                    @elseif($sitio->estado === 'APROBADO')
                                        <span class="badge bg-success px-3 py-2 font-weight-bold">
                                            <i class="bi bi-check-circle-fill me-1"></i> Aprobado
                                        </span>
                                    @elseif($sitio->estado === 'SUSPENDIDO')
                                        <span class="badge bg-secondary px-3 py-2 font-weight-bold" data-bs-toggle="tooltip" title="{{ $sitio->motivo_suspension ?? 'Establecimiento suspendido temporalmente' }}">
                                            <i class="bi bi-dash-circle-fill me-1"></i> Suspendido
                                        </span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2 font-weight-bold" data-bs-toggle="tooltip" title="{{ $sitio->motivo_rechazo }}">
                                            <i class="bi bi-x-circle-fill me-1"></i> Rechazado
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Acciones -->
                                <td class="px-4 py-3 text-end">
                                    <a href="{{ route('admin.sitios.revisar', $sitio->id) }}" class="btn btn-sm btn-outline-dark font-weight-semibold">
                                        <i class="bi bi-eye-fill me-1"></i> Revisar / Evaluar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-5 text-center text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                    No se encontraron sitios que coincidan con los criterios de búsqueda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Paginación (Laravel Links) -->
        @if($sitios->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 px-4 d-flex justify-content-center">
                {{ $sitios->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection