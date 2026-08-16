@extends('layouts.app')
@section('title', 'Detalle de Solicitud #' . $solicitud->id)

@push('styles')
    @vite(['resources/css/solicitudes.css'])
@endpush

@section('contenido')
<div class="solicitudes-container">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('super.solicitudes.index') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
            <i class="bi bi-arrow-left"></i> Volver a la lista de solicitudes
        </a>
    </div>

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

    <!-- Cabecera de la Solicitud -->
    <div class="detalle-solicitud-card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">
                    Solicitud #{{ $solicitud->id }}
                </h1>
                <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 4px;">
                    Enviada el {{ $solicitud->created_at->format('d/m/Y \a \l\a\s H:i') }}
                </p>
            </div>
            <div>
                <span class="badge-status badge-{{ strtolower($solicitud->estado) }}" style="font-size: 0.9rem; padding: 6px 16px;">
                    {{ $solicitud->estado }}
                </span>
            </div>
        </div>

        <!-- Información Contextual -->
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Sitio Afectado</div>
                <div class="info-value">
                    <i class="bi bi-building"></i> {{ $solicitud->sitio->nombre_sitio ?? 'Sitio #' . $solicitud->id_sitio }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Usuario Solicitante</div>
                <div class="info-value">
                    <i class="bi bi-person-circle"></i> {{ $solicitud->usuario->name ?? 'ID #' . $solicitud->id_user }}
                </div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">
                    {{ $solicitud->usuario->email ?? '' }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Operaciones Incluidas</div>
                <div class="info-value">
                    <i class="bi bi-layers"></i> {{ $solicitud->operaciones->count() }} operaciones
                </div>
            </div>

            @if($solicitud->revisador_por || $solicitud->revisor)
                <div class="info-item">
                    <div class="info-label">Revisado Por</div>
                    <div class="info-value">
                        <i class="bi bi-person-check"></i> {{ $solicitud->revisor->name ?? 'Admin #' . $solicitud->revisado_por }}
                    </div>
                    @if($solicitud->fecha_revision)
                        <div style="font-size: 0.8rem; color: var(--text-muted);">
                            {{ \Carbon\Carbon::parse($solicitud->fecha_revision)->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        @if($solicitud->comentario_usuario)
            <div style="margin-top: 20px; padding: 14px; background: #f8fafc; border-left: 4px solid var(--primary-color); border-radius: 6px;">
                <strong style="font-size: 0.85rem; color: var(--text-main); display: block; margin-bottom: 4px;">Comentario del Usuario:</strong>
                <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);">{{ $solicitud->comentario_usuario }}</p>
            </div>
        @endif

        @if($solicitud->comentario_admin)
            <div style="margin-top: 15px; padding: 14px; background: #fff1f2; border-left: 4px solid var(--danger-color); border-radius: 6px;">
                <strong style="font-size: 0.85rem; color: #9f1239; display: block; margin-bottom: 4px;">Observación de Revisión (Admin):</strong>
                <p style="margin: 0; font-size: 0.9rem; color: #881337;">{{ $solicitud->comentario_admin }}</p>
            </div>
        @endif
    </div>

    <!-- Detalle de Operaciones -->
    <div style="margin-bottom: 30px;">
        <h2 class="operaciones-seccion-titulo">
            <i class="bi bi-code-square"></i> Cambios y Operaciones Solicitadas
        </h2>

        @foreach($solicitud->operaciones as $index => $op)
            <div class="operacion-card">
                <div class="operacion-header">
                    <div>
                        <span class="operacion-badge op-{{ strtolower($op->operacion) }}">
                            {{ $op->operacion }}
                        </span>
                        <strong style="font-size: 1rem; color: var(--text-main); margin-left: 8px;">
                            {{ class_basename($op->modelo) }}
                        </strong>
                        @if($op->id_registro)
                            <span style="font-size: 0.85rem; color: var(--text-muted);">
                                (ID Registro: {{ $op->id_registro }})
                            </span>
                        @endif
                    </div>
                    @if($op->descripcion)
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted);">
                            {{ $op->descripcion }}
                        </div>
                    @endif
                </div>

                <!-- Visualización de Cambios (Diff) -->
                @php
                    $cambios = $op->cambios ?? [];
                @endphp

                @if(isset($cambios['relacion']))
                    <!-- Cambio en Relación (ManyToMany/Sync) -->
                    <div style="font-size: 0.9rem; margin-top: 8px;">
                        <p style="margin-bottom: 6px;"><strong>Relación Afectada:</strong> <code>{{ $cambios['relacion'] }}</code></p>
                        <div class="diff-container">
                            <div class="diff-box diff-antes">
                                <div class="diff-title">IDs Anteriores</div>
                                <pre style="margin:0;">{{ json_encode($cambios['antes'] ?? [], JSON_PRETTY_PRINT) }}</pre>
                            </div>
                            <div class="diff-box diff-despues">
                                <div class="diff-title">IDs Nuevos Solicitados</div>
                                <pre style="margin:0;">{{ json_encode($cambios['despues'] ?? [], JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    </div>
                @elseif(isset($cambios['antes']) || isset($cambios['despues']))
                    <!-- Cambio Directo de Atributos (UPDATE o CREATE) -->
                    <div class="diff-container">
                        @if(isset($cambios['antes']))
                            <div class="diff-box diff-antes">
                                <div class="diff-title">Estado Original (Antes)</div>
                                @if(is_array($cambios['antes']) && isset($cambios['antes']['foto_portada']) && $cambios['antes']['foto_portada'])
                                    @php
                                        $antesImg = $cambios['antes']['foto_portada'];
                                        $antesUrl = \Illuminate\Support\Str::startsWith($antesImg, ['http://', 'https://', 'uploads/']) 
                                            ? asset($antesImg) 
                                            : asset('storage/' . $antesImg);
                                    @endphp
                                    <div style="margin-bottom: 10px; padding: 8px; background: rgba(0,0,0,0.03); border-radius: 8px;">
                                        <strong style="font-size: 0.8rem; color: #475569; display: block; margin-bottom: 4px;">Portada Anterior:</strong>
                                        <img src="{{ $antesUrl }}" style="width: 100%; max-height: 180px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    </div>
                                @endif
                                <pre style="margin:0; white-space: pre-wrap; word-break: break-word;">{{ json_encode($cambios['antes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        @endif

                        @if(isset($cambios['despues']))
                            <div class="diff-box diff-despues">
                                <div class="diff-title">Estado Propuesto (Después)</div>
                                @if(is_array($cambios['despues']) && isset($cambios['despues']['foto_portada']) && $cambios['despues']['foto_portada'])
                                    @php
                                        $despuesImg = $cambios['despues']['foto_portada'];
                                        $despuesUrl = \Illuminate\Support\Str::startsWith($despuesImg, ['http://', 'https://', 'uploads/']) 
                                            ? asset($despuesImg) 
                                            : asset('storage/' . $despuesImg);
                                    @endphp
                                    <div style="margin-bottom: 10px; padding: 8px; background: rgba(0,0,0,0.03); border-radius: 8px;">
                                        <strong style="font-size: 0.8rem; color: #0f52ba; display: block; margin-bottom: 4px;">Nueva Portada Propuesta:</strong>
                                        <img src="{{ $despuesUrl }}" style="width: 100%; max-height: 180px; object-fit: cover; border-radius: 6px; border: 1px solid #93c5fd;">
                                    </div>
                                @endif
                                <pre style="margin:0; white-space: pre-wrap; word-break: break-word;">{{ json_encode($cambios['despues'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Formato genérico JSON -->
                    <div class="diff-box diff-despues" style="margin-top: 10px;">
                        <div class="diff-title">Datos de la Operación</div>
                        <pre style="margin:0; white-space: pre-wrap;">{{ json_encode($cambios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Panel de Acciones (Solo visible si la solicitud está PENDIENTE) -->
    @if($solicitud->estado === 'PENDIENTE')
        <div class="acciones-panel">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin: 0;">
                <i class="bi bi-sliders"></i> Panel de Decisión del Administrador
            </h3>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
                Evalúa los cambios expuestos arriba. Si apruebas la solicitud, las modificaciones se guardarán permanentemente en la base de datos.
            </p>

            <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 10px;">
                <!-- Formulario de Aprobación -->
                <form action="{{ route('super.solicitudes.aprobar', $solicitud->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas APROBAR esta solicitud y aplicar los cambios en el sitio?');">
                    @csrf
                    <button type="submit" class="btn-aprobar">
                        <i class="bi bi-check-lg" style="font-size: 1.2rem;"></i> Aprobar y Aplicar Cambios
                    </button>
                </form>

                <!-- Formulario de Rechazo -->
                <div style="flex: 1; min-width: 280px;">
                    <form action="{{ route('super.solicitudes.rechazar', $solicitud->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 10px;">
                            <textarea name="comentario_admin" class="textarea-comentario" placeholder="Escribe el motivo del rechazo u observaciones para el usuario (opcional)..."></textarea>
                        </div>
                        <button type="submit" class="btn-rechazar" onclick="return confirm('¿Estás seguro de que deseas RECHAZAR esta solicitud?');">
                            <i class="bi bi-x-lg" style="font-size: 1.1rem;"></i> Rechazar Solicitud
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
