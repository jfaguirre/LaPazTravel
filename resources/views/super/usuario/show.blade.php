@extends('layouts.su')
@section('title', 'Detalles del Usuario')

@section('contenido')
<div class="container py-4">
    <!-- Navegación superior -->
    <div class="mb-4">
        <a href="{{ route('super.usuario.index') }}" class="btn btn-link text-decoration-none text-secondary p-0 btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver al panel de usuarios
        </a>
    </div>

    <div class="row g-4">
        <!-- Columna Ficha de Perfil -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 rounded-3 text-center p-3">
                <div class="card-body">
                    <!-- Foto de Perfil -->
                    <div class="mb-3 position-relative d-inline-block">
                        @if($usuario->foto_perfil)
                            <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Perfil" class="rounded-circle border border-2 border-white shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border mx-auto shadow-sm" style="width: 120px; height: 120px;">
                                <i class="bi bi-person-fill text-secondary display-5"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Datos Básicos -->
                    <h5 class="fw-bold text-dark mb-1">{{ $usuario->name }} {{ $usuario->lastName }}</h5>
                    <p class="text-muted small mb-3">{{ $usuario->email }}</p>

                    <!-- Estatus / Badge de Rol -->
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                        @if($usuario->hasRole('su'))
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fs-7">
                                <i class="bi bi-shield-lock-fill me-1"></i> Super Admin
                            </span>
                        @elseif($usuario->hasRole('admin'))
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fs-7">
                                <i class="bi bi-briefcase-fill me-1"></i> Admin
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill fs-7">
                                <i class="bi bi-person-fill me-1"></i> {{ ucfirst($usuario->roles->first()?->name ?? 'Sin Rol') }}
                            </span>
                        @endif

                        @if($usuario->estado === 'ACTIVO')
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fs-7">
                                <i class="bi bi-check-circle-fill me-1"></i> Activo
                            </span>
                        @elseif($usuario->estado === 'INACTIVO')
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-pill fs-7">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Inactivo
                            </span>
                        @else
                            <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-3 py-2 rounded-pill fs-7">
                                <i class="bi bi-slash-circle-fill me-1"></i> Suspendido
                            </span>
                        @endif
                    </div>

                    <hr class="text-muted opacity-25">

                    <!-- Acciones rápidas -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('super.usuario.edit', $usuario->id) }}" class="btn btn-dark btn-sm fw-semibold shadow-sm">
                            <i class="bi bi-pencil-square me-1"></i> Modificar Cuenta
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Datos Técnicos y Sitios -->
        <div class="col-12 col-lg-8">
            <!-- Información del Sistema -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="bi bi-cpu-fill me-2 text-primary"></i> Información del Sistema
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                            <span class="text-muted small">ID del Usuario</span>
                            <span class="badge bg-light text-dark font-monospace border px-2 py-1">{{ $usuario->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                            <span class="text-muted small">Fecha de Registro</span>
                            <span class="fw-semibold text-dark small">
                                {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y - h:i A') : 'N/D' }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                            <span class="text-muted small">Última Modificación</span>
                            <span class="fw-semibold text-dark small">
                                {{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y - h:i A') : 'Sin cambios recientes' }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                            <span class="text-muted small">Último Acceso</span>
                            <span class="fw-semibold text-dark small">
                                <i class="bi bi-clock-history text-muted me-1"></i>
                                {{ $usuario->ultimo_login ? $usuario->ultimo_login->format('d/m/Y - h:i A') : 'Nunca se ha conectado' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Listado de Sitios -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="bi bi-globe me-2 text-primary"></i> Sitios de su Propiedad
                    </h6>
                    <span class="badge bg-secondary-subtle text-secondary border px-2.5 py-1 rounded-pill fw-bold small">
                        {{ $usuario->sitios->count() }} Registrados
                    </span>
                </div>
                <div class="card-body p-0">
                    @if($usuario->sitios->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 text-nowrap">
                                <thead class="table-light text-muted small">
                                    <tr>
                                        <th class="px-4 py-3 border-0">Nombre del Sitio</th>
                                        <th class="px-4 py-3 border-0 text-center">Estado</th>
                                        <th class="px-4 py-3 border-0 text-center">Visitas</th>
                                        <th class="px-4 py-3 border-0 text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuario->sitios as $sitio)
                                        <tr>
                                            <td class="px-4 fw-medium text-dark">{{ $sitio->nombre }}</td>
                                            <td class="px-4 text-center">
                                                <span class="badge bg-light text-dark border px-2.5 py-1 fw-normal">
                                                    {{ $sitio->estado }}
                                                </span>
                                            </td>
                                            <td class="px-4 text-center text-muted small">
                                                <i class="bi bi-eye me-1 text-secondary"></i> {{ number_format($sitio->visitas) }}
                                            </td>
                                            <td class="px-4 text-end">
                                                <a href="{{ route('super.sitio.revisar', $sitio->id) }}" class="btn btn-sm btn-outline-secondary border-0" title="Ver ficha del sitio">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted px-4">
                            <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-folder-x fs-3 text-secondary"></i>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Sin sitios registrados</h6>
                            <p class="small text-muted mb-0">Este usuario aún no posee establecimientos o sitios dentro de la plataforma.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection