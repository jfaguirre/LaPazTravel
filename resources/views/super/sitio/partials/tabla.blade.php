<div class="table-responsive">
    <table class="table table-hover align-middle mb-0 text-nowrap">
        <thead class="table-light text-muted small text-uppercase">
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
                    <td class="px-4 py-3">
                        <div class="fw-semibold text-dark">{{ $sitio->nombre }}</div>
                        @if(isset($sitio->perfil->identificador))
                            <span class="text-muted small"><code>{{ $sitio->perfil->identificador }}</code></span>
                        @endif
                    </td>
                    
                    <td class="px-4 py-3 text-muted">
                        <div class="text-dark fw-medium">{{ $sitio->usuario->name ?? 'N/A' }} {{ $sitio->usuario->lastName ?? '' }}</div>
                        <span class="small d-block text-muted">{{ $sitio->usuario->email ?? '' }}</span>
                    </td>
                    
                    <td class="px-4 py-3 text-muted small">
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-geo-alt-fill text-danger"></i>
                            <span class="fw-medium text-dark">{{ $sitio->perfil->departamento->departamento ?? 'No especificado' }}</span>
                        </div>
                        @if(isset($sitio->perfil->municipio) || isset($sitio->perfil->distrito))
                            <span class="text-muted d-block ps-3">
                                {{ $sitio->perfil->municipio->municipio ?? '' }}
                                {{ isset($sitio->perfil->distrito) ? ' - ' . $sitio->perfil->distrito->distrito : '' }}
                            </span>
                        @endif
                    </td>
                    
                    <td class="px-4 py-3 text-center">
                        @if($sitio->estado === 'PENDIENTE' || $sitio->estado === null)
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle rounded-pill px-3 py-2 fw-semibold">
                                <i class="bi bi-hourglass-split me-1"></i> Pendiente
                            </span>
                        @elseif($sitio->estado === 'APROBADO')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-3 py-2 fw-semibold">
                                <i class="bi bi-check-circle-fill me-1"></i> Aprobado
                            </span>
                        @elseif($sitio->estado === 'SUSPENDIDO')
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $sitio->motivo_suspension ?? 'Establecimiento suspendido temporalmente' }}">
                                <i class="bi bi-dash-circle-fill me-1"></i> Suspendido
                            </span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $sitio->motivo_rechazo ?? 'Rechazado' }}">
                                <i class="bi bi-x-circle-fill me-1"></i> Rechazado
                            </span>
                        @endif
                    </td>
                    
                    <td class="px-4 py-3 text-end">
                        <a href="{{ route('super.sitio.revisar', $sitio->id) }}" class="btn btn-sm btn-outline-dark fw-semibold rounded-2 shadow-sm">
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

@if($sitios->hasPages())
    <div class="card-footer bg-white border-top-0 py-3 px-4 d-flex justify-content-center">
        {{ $sitios->links() }}
    </div>
@endif