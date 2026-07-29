@extends('layouts.su')
@section('title', 'Detalles del Usuario')

@section('contenido')
<div class="container py-5">
    <!-- Navegación -->
    <div class="mb-4">
        <a href="{{ route('su.usuarios.index') }}" class="text-muted text-decoration-none small">
            <i class="bi bi-arrow-left me-1"></i> Volver al panel de usuarios
        </a>
    </div>

    <div class="row g-4">
        <!-- Columna Ficha de Perfil -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="card-body">
                    <!-- Foto -->
                    <div class="mb-3">
                        @if($usuario->foto_perfil)
                            <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Perfil" class="rounded-circle border img-thumbnail shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border text-secondary mx-auto shadow-sm" style="width: 120px; height: 120px;">
                                <i class="bi bi-person-fill fs-1"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Datos básicos -->
                    <h4 class="font-weight-bold text-dark mb-1">{{ $usuario->name }} {{ $usuario->lastName }}</h4>
                    <p class="text-muted mb-3">{{ $usuario->email }}</p>

                    <!-- Estatus / Badge de Rol -->
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                        @if($usuario->hasRole('su'))
                            <span class="badge bg-danger px-3 py-2"><i class="bi bi-shield-lock-fill me-1"></i> Super Admin</span>
                        @elseif($usuario->hasRole('admin'))
                            <span class="badge bg-primary px-3 py-2"><i class="bi bi-briefcase-fill me-1"></i> Admin</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2"><i class="bi bi-person-fill me-1"></i> {{ ucfirst($usuario->roles->first()?->name ?? 'Sin Rol') }}</span>
                        @endif

                        @if($usuario->estado === 'ACTIVO')
                            <span class="badge bg-success px-3 py-2">Activo</span>
                        @elseif($usuario->estado === 'INACTIVO')
                            <span class="badge bg-warning text-dark px-3 py-2">Inactivo</span>
                        @else
                            <span class="badge bg-dark px-3 py-2">Suspendido</span>
                        @endif
                    </div>

                    <hr>

                    <!-- Botones rápidos -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('su.usuarios.edit', $usuario->id) }}" class="btn btn-dark btn-sm font-weight-bold">
                            <i class="bi bi-pencil-fill me-1"></i> Modificar Cuenta
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Datos Técnicos y Sitios del usuario -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="font-weight-bold text-dark mb-0"><i class="bi bi-info-circle-fill me-2 text-secondary"></i> Información del Sistema</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <table class="table table-sm table-borderless align-middle mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted py-2" style="width: 30%;">Identificador único (ID)</td>
                                <td class="font-weight-semibold py-2"><code>{{ $usuario->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="text-muted py-2">Fecha de Registro</td>
                                <td class="text-dark py-2">{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y a las h:i A') : 'N/D' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-2">Última Modificación</td>
                                <td class="text-dark py-2">{{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y a las h:i A') : 'Sin cambios recientes' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-2">Último Acceso Registrado</td>
                                <td class="text-dark py-2">
                                    <i class="bi bi-calendar-event text-muted me-1"></i>
                                    {{ $usuario->ultimo_login ? $usuario->ultimo_login->format('d/m/Y H:i') : 'Nunca se ha conectado' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Listado de Sitios que le pertenecen a este usuario -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold text-dark mb-0"><i class="bi bi-browser-safari me-2 text-secondary"></i> Sitios de su Propiedad</h5>
                    <span class="badge bg-light text-dark border px-2.5 font-weight-bold">{{ $usuario->sitios->count() }} Registrados</span>
                </div>
                <div class="card-body p-0 mt-2">
                    @if($usuario->sitios->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 text-nowrap">
                                <thead class="table-light text-muted small">
                                    <tr>
                                        <th class="px-4 py-2">Nombre del Sitio</th>
                                        <th class="px-4 py-2 text-center">Estado</th>
                                        <th class="px-4 py-2 text-center">Visitas</th>
                                        <th class="px-4 py-2 text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuario->sitios as $sitio)
                                        <tr>
                                            <td class="px-4 font-weight-medium text-dark">{{ $sitio->nombre }}</td>
                                            <td class="px-4 text-center">
                                                <span class="badge bg-light text-dark border font-weight-bold">{{ $sitio->estado }}</span>
                                            </td>
                                            <td class="px-4 text-center text-muted small">{{ number_format($sitio->visitas) }}</td>
                                            <td class="px-4 text-end">
                                                <a href="{{ route('su.sitios.revisar', $sitio->id) }}" class="btn btn-sm btn-light border" title="Ver ficha del sitio">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-2 d-block text-secondary mb-2"></i>
                            Este usuario no ha registrado ningún establecimiento o sitio en la plataforma todavía.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection