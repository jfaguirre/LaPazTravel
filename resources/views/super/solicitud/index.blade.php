@extends('layouts.app')
@section('title', 'Aprobación de Solicitudes')

@push('styles')
    @vite(['resources/css/solicitudes.css'])
@endpush

@section('contenido')
<div class="solicitudes-container">

    @if(session('success'))
        <div class="alert-custom alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Header Principal -->
    <div class="solicitudes-header">
        <div>
            <h1 class="solicitudes-title">
                <i class="bi bi-shield-check"></i> Solicitudes de Modificación
            </h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">
                Revisa y aprueba las actualizaciones o eliminaciones enviadas por los propietarios de sitios.
            </p>
        </div>

        <!-- Filtros por Pestaña -->
        <div class="solicitudes-filters">
            <a href="{{ route('super.solicitudes.index') }}" 
               class="filter-btn {{ empty($estado) ? 'active' : '' }}">
                Todas <span class="filter-count">{{ $conteos['todos'] }}</span>
            </a>
            <a href="{{ route('super.solicitudes.index', ['estado' => 'PENDIENTE']) }}" 
               class="filter-btn {{ $estado === 'PENDIENTE' ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Pendientes 
                <span class="filter-count">{{ $conteos['pendiente'] }}</span>
            </a>
            <a href="{{ route('super.solicitudes.index', ['estado' => 'APROBADA']) }}" 
               class="filter-btn {{ $estado === 'APROBADA' ? 'active' : '' }}">
                <i class="bi bi-check2-circle"></i> Aprobadas 
                <span class="filter-count">{{ $conteos['aprobada'] }}</span>
            </a>
            <a href="{{ route('super.solicitudes.index', ['estado' => 'RECHAZADA']) }}" 
               class="filter-btn {{ $estado === 'RECHAZADA' ? 'active' : '' }}">
                <i class="bi bi-x-circle"></i> Rechazadas 
                <span class="filter-count">{{ $conteos['rechazada'] }}</span>
            </a>
        </div>
    </div>

    <!-- Grid de Solicitudes -->
    @if($solicitudes->count() > 0)
        <div class="solicitudes-grid">
            @foreach($solicitudes as $solicitud)
                <div class="solicitud-card">
                    <div>
                        <div class="solicitud-card-header">
                            <h3 class="solicitud-sitio-nombre">
                                {{ $solicitud->sitio->nombre_sitio ?? 'Sitio #' . $solicitud->id_sitio }}
                            </h3>
                            <span class="badge-status badge-{{ strtolower($solicitud->estado) }}">
                                {{ $solicitud->estado }}
                            </span>
                        </div>

                        <div class="solicitud-meta">
                            <div>
                                <i class="bi bi-person"></i>
                                Solicitante: <strong>{{ $solicitud->usuario->name ?? 'Usuario #' . $solicitud->id_user }}</strong>
                            </div>
                            <div>
                                <i class="bi bi-calendar3"></i>
                                Fecha: {{ $solicitud->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="solicitud-operaciones-resumen">
                            <span class="solicitud-operaciones-count">
                                <i class="bi bi-layers"></i> {{ $solicitud->operaciones->count() }} operaciones solicitadas
                            </span>
                            @if($solicitud->operaciones->count() > 0)
                                <ul style="margin: 6px 0 0 0; padding-left: 18px; font-size: 0.82rem; color: var(--text-muted);">
                                    @foreach($solicitud->operaciones->take(2) as $op)
                                        <li>
                                            <strong>{{ $op->operacion }}:</strong> 
                                            {{ $op->descripcion ?? class_basename($op->modelo) }}
                                        </li>
                                    @endforeach
                                    @if($solicitud->operaciones->count() > 2)
                                        <li style="font-style: italic; list-style: none; margin-top: 2px;">
                                            + {{ $solicitud->operaciones->count() - 2 }} más...
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('super.solicitudes.show', $solicitud->id) }}" class="btn-ver-detalle">
                            Ver Solicitud Completa <i class="bi bi-arrow-right-short" style="font-size: 1.2rem;"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 30px;">
            {{ $solicitudes->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 16px; border: 1px solid var(--border-color);">
            <i class="bi bi-inbox" style="font-size: 3rem; color: var(--text-muted);"></i>
            <h3 style="margin-top: 16px; color: var(--text-main); font-weight: 700;">No hay solicitudes encontradas</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                No existen solicitudes asociadas al filtro seleccionado actualmente.
            </p>
        </div>
    @endif

</div>
@endsection
