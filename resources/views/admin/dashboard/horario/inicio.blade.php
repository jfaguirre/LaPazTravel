@extends('layouts.dashboardSitio')
@section('title', 'Horarios de Atención - ' . $sitio->nombre)

@push('styles')
    @vite(['resources/css/dashboard_sitio.css'])
    <style>
        .horarios-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .quick-actions-bar {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .quick-actions-title {
            font-size: 14px;
            font-weight: 700;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .quick-btn {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .quick-btn:hover {
            background: #0284c7;
            color: #ffffff;
            border-color: #0284c7;
        }

        .dia-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 16px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .dia-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .dia-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .dia-nombre {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .opciones-estado {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .estado-radio-label {
            position: relative;
            cursor: pointer;
        }

        .estado-radio-label input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .estado-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 20px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #64748b;
            transition: all 0.2s ease;
            user-select: none;
        }

        .estado-radio-label input:checked + .estado-chip.chip-abierto {
            background: #dcfce7;
            border-color: #22c55e;
            color: #15803d;
        }

        .estado-radio-label input:checked + .estado-chip.chip-cerrado {
            background: #fee2e2;
            border-color: #ef4444;
            color: #b91c1c;
        }

        .estado-radio-label input:checked + .estado-chip.chip-24h {
            background: #dbeafe;
            border-color: #3b82f6;
            color: #1d4ed8;
        }

        .estado-radio-label input:checked + .estado-chip.chip-personalizado {
            background: #fef3c7;
            border-color: #f59e0b;
            color: #b45309;
        }

        .dia-detalles {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed #f1f5f9;
        }

        .time-inputs {
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 380px;
        }

        .time-group {
            flex: 1;
        }

        .time-group label {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 4px;
            display: block;
        }

        .time-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: #1e293b;
        }

        .preview-card {
            background: #0f172a;
            color: #f8fafc;
            border-radius: 16px;
            padding: 24px;
            margin-top: 32px;
        }

        .preview-header {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #38bdf8;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .preview-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .preview-dia {
            font-weight: 600;
            color: #e2e8f0;
        }

        .preview-val {
            color: #94a3b8;
            font-weight: 500;
        }
    </style>
@endpush

@section('contenido')
<div class="pagina">
    <div class="form-container horarios-container">

        <!-- Cabecera -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Horarios de atención del sitio</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Configura los días y horarios en los que tu sitio turístico está disponible en <strong>{{ $sitio->nombre }}</strong>.</p>
            </div>
            <a href="{{ route('dashboard.sitio.inicio') }}" class="step-link" style="font-size: 14.5px;">
                <i class="bi bi-arrow-left-short" style="font-size: 20px; line-height: 1;"></i> Volver al panel
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        @if($tieneSolicitudPendiente)
            <div class="alert alert-warning mb-4 d-flex align-items-center" role="alert">
                <i class="bi bi-clock-history fs-4 me-3 text-warning"></i>
                <div>
                    <strong>Solicitud en revisión:</strong> Ya tienes una solicitud de actualización de horarios pendiente de aprobación. No se pueden realizar modificaciones hasta que la solicitud actual sea procesada.
                </div>
            </div>
        @endif

        <!-- Barra de Acciones Rápidas -->
        <div class="quick-actions-bar">
            <div class="quick-actions-title">
                <i class="bi bi-grip-vertical"></i> Acciones rápidas:
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="quick-btn" onclick="aplicarHorarioSemana('08:00', '17:00')" @if($tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-briefcase me-1"></i> Lun-Vie (08:00 - 17:00)
                </button>
                <button type="button" class="quick-btn" onclick="copiarLunesAResto()" @if($tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-files me-1"></i> Copiar Lunes a Vie
                </button>
                <button type="button" class="quick-btn" onclick="marcarTodos24h()" @if($tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-clock me-1"></i> Todos 24 Horas
                </button>
                <button type="button" class="quick-btn" onclick="marcarTodosCerrados()" @if($tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-x-circle me-1"></i> Todos Cerrados
                </button>
            </div>
        </div>

        <form id="form-horarios" class="form-card" action="{{ route('horario.update') }}" method="POST">
            @csrf
            @method('put')

            <div class="form-section-title">
                <i class="bi bi-calendar3 me-2"></i> Configuración por día de la semana
            </div>

            @php
                $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            @endphp

            @foreach($diasSemana as $dia)
                @php
                    $valorOriginal = $horarios[$dia] ?? null;
                    $estadoActual = 'cerrado';
                    $aperturaActual = '08:00';
                    $cierreActual = '17:00';
                    $personalizadoActual = '';

                    if ($valorOriginal) {
                        if ($valorOriginal === 'Cerrado') {
                            $estadoActual = 'cerrado';
                        } elseif ($valorOriginal === '24 Horas' || $valorOriginal === '24h') {
                            $estadoActual = '24h';
                        } elseif (preg_match('/^(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})$/', $valorOriginal, $matches)) {
                            $estadoActual = 'abierto';
                            $aperturaActual = strlen($matches[1]) == 4 ? '0'.$matches[1] : $matches[1];
                            $cierreActual = strlen($matches[2]) == 4 ? '0'.$matches[2] : $matches[2];
                        } else {
                            $estadoActual = 'personalizado';
                            $personalizadoActual = $valorOriginal;
                        }
                    } else {
                        // Si no hay datos, Lun-Vie abierto por defecto
                        if (in_array($dia, ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'])) {
                            $estadoActual = 'abierto';
                        }
                    }
                @endphp

                <div class="dia-card" id="card-dia-{{ $dia }}">
                    <div class="dia-header">
                        <div class="dia-nombre">
                            <i class="bi bi-calendar-event text-primary"></i> {{ $dia }}
                        </div>

                        <div class="opciones-estado">
                            <label class="estado-radio-label">
                                <input type="radio" name="horarios[{{ $dia }}][estado]" value="abierto" 
                                    {{ $estadoActual === 'abierto' ? 'checked' : '' }} 
                                    onchange="toggleDia('{{ $dia }}')" 
                                    @if($tieneSolicitudPendiente) disabled @endif>
                                <span class="estado-chip chip-abierto">
                                    <i class="bi bi-door-open-fill"></i> Abierto
                                </span>
                            </label>

                            <label class="estado-radio-label">
                                <input type="radio" name="horarios[{{ $dia }}][estado]" value="24h" 
                                    {{ $estadoActual === '24h' ? 'checked' : '' }} 
                                    onchange="toggleDia('{{ $dia }}')" 
                                    @if($tieneSolicitudPendiente) disabled @endif>
                                <span class="estado-chip chip-24h">
                                    <i class="bi bi-clock-fill"></i> 24 Horas
                                </span>
                            </label>

                            <label class="estado-radio-label">
                                <input type="radio" name="horarios[{{ $dia }}][estado]" value="cerrado" 
                                    {{ $estadoActual === 'cerrado' ? 'checked' : '' }} 
                                    onchange="toggleDia('{{ $dia }}')" 
                                    @if($tieneSolicitudPendiente) disabled @endif>
                                <span class="estado-chip chip-cerrado">
                                    <i class="bi bi-door-closed-fill"></i> Cerrado
                                </span>
                            </label>

                            <label class="estado-radio-label">
                                <input type="radio" name="horarios[{{ $dia }}][estado]" value="personalizado" 
                                    {{ $estadoActual === 'personalizado' ? 'checked' : '' }} 
                                    onchange="toggleDia('{{ $dia }}')" 
                                    @if($tieneSolicitudPendiente) disabled @endif>
                                <span class="estado-chip chip-personalizado">
                                    <i class="bi bi-pencil-square"></i> Especial
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="dia-detalles" id="detalles-{{ $dia }}">
                        <!-- Horas de apertura y cierre -->
                        <div class="time-inputs" id="input-time-{{ $dia }}" style="{{ $estadoActual === 'abierto' ? '' : 'display: none;' }}">
                            <div class="time-group">
                                <label for="apertura-{{ $dia }}">Hora de Apertura</label>
                                <input type="time" id="apertura-{{ $dia }}" name="horarios[{{ $dia }}][apertura]" 
                                    value="{{ $aperturaActual }}" class="time-input" onchange="actualizarPreview()" 
                                    @if($tieneSolicitudPendiente) disabled @endif>
                            </div>
                            <span style="align-self: flex-end; margin-bottom: 8px; font-weight: 700; color: #94a3b8;">a</span>
                            <div class="time-group">
                                <label for="cierre-{{ $dia }}">Hora de Cierre</label>
                                <input type="time" id="cierre-{{ $dia }}" name="horarios[{{ $dia }}][cierre]" 
                                    value="{{ $cierreActual }}" class="time-input" onchange="actualizarPreview()" 
                                    @if($tieneSolicitudPendiente) disabled @endif>
                            </div>
                        </div>

                        <!-- Texto personalizado -->
                        <div id="input-personalizado-{{ $dia }}" style="{{ $estadoActual === 'personalizado' ? '' : 'display: none;' }}">
                            <label for="custom-{{ $dia }}" style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 4px; display: block;">
                                Descripción o turno especial
                            </label>
                            <input type="text" id="custom-{{ $dia }}" name="horarios[{{ $dia }}][personalizado]" 
                                value="{{ $personalizadoActual }}" placeholder="Ej: 08:00 - 12:00 / 14:00 - 18:00 o Previa cita" 
                                class="time-input" oninput="actualizarPreview()" maxlength="100" 
                                @if($tieneSolicitudPendiente) disabled @endif>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Vista previa en tiempo real -->
            <div class="preview-card">
                <div class="preview-header">
                    <i class="bi bi-eye-fill"></i> Vista previa pubilca de horarios
                </div>
                <div id="preview-lista">
                    <!-- Se llena dinámicamente -->
                </div>
            </div>

            <!-- Botones -->
            <div class="btn-actions mt-4">
                <a class="btn btn-dark" href="{{ route('dashboard.sitio.inicio') }}">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary" @if($tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-send-fill me-1"></i> Guardar solicitud
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

    function toggleDia(dia) {
        const radios = document.getElementsByName(`horarios[${dia}][estado]`);
        let estado = 'cerrado';
        for (const radio of radios) {
            if (radio.checked) {
                estado = radio.value;
                break;
            }
        }

        const timeDiv = document.getElementById(`input-time-${dia}`);
        const customDiv = document.getElementById(`input-personalizado-${dia}`);

        if (estado === 'abierto') {
            timeDiv.style.display = 'flex';
            customDiv.style.display = 'none';
        } else if (estado === 'personalizado') {
            timeDiv.style.display = 'none';
            customDiv.style.display = 'block';
        } else {
            timeDiv.style.display = 'none';
            customDiv.style.display = 'none';
        }

        actualizarPreview();
    }

    function setEstadoDia(dia, estado, apertura = '08:00', cierre = '17:00', personalizado = '') {
        const radios = document.getElementsByName(`horarios[${dia}][estado]`);
        for (const radio of radios) {
            if (radio.value === estado) {
                radio.checked = true;
            }
        }

        if (apertura) {
            const inputAp = document.getElementById(`apertura-${dia}`);
            if (inputAp) inputAp.value = apertura;
        }

        if (cierre) {
            const inputCi = document.getElementById(`cierre-${dia}`);
            if (inputCi) inputCi.value = cierre;
        }

        if (personalizado !== undefined) {
            const inputCust = document.getElementById(`custom-${dia}`);
            if (inputCust) inputCust.value = personalizado;
        }

        toggleDia(dia);
    }

    function aplicarHorarioSemana(apertura, cierre) {
        const habs = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        habs.forEach(dia => {
            setEstadoDia(dia, 'abierto', apertura, cierre);
        });
    }

    function copiarLunesAResto() {
        const radiosLun = document.getElementsByName('horarios[Lunes][estado]');
        let estadoLun = 'abierto';
        for (const radio of radiosLun) {
            if (radio.checked) {
                estadoLun = radio.value;
                break;
            }
        }

        const aperturaLun = document.getElementById('apertura-Lunes')?.value || '08:00';
        const cierreLun   = document.getElementById('cierre-Lunes')?.value   || '17:00';
        const customLun   = document.getElementById('custom-Lunes')?.value   || '';

        const resto = ['Martes', 'Miércoles', 'Jueves', 'Viernes'];
        resto.forEach(dia => {
            setEstadoDia(dia, estadoLun, aperturaLun, cierreLun, customLun);
        });
    }

    function marcarTodos24h() {
        dias.forEach(dia => {
            setEstadoDia(dia, '24h');
        });
    }

    function marcarTodosCerrados() {
        dias.forEach(dia => {
            setEstadoDia(dia, 'cerrado');
        });
    }

    function actualizarPreview() {
        const previewContainer = document.getElementById('preview-lista');
        if (!previewContainer) return;

        let html = '';

        dias.forEach(dia => {
            const radios = document.getElementsByName(`horarios[${dia}][estado]`);
            let estado = 'cerrado';
            for (const radio of radios) {
                if (radio.checked) {
                    estado = radio.value;
                    break;
                }
            }

            let valorTexto = 'Cerrado';
            if (estado === 'abierto') {
                const ap = document.getElementById(`apertura-${dia}`)?.value || '08:00';
                const ci = document.getElementById(`cierre-${dia}`)?.value || '17:00';
                valorTexto = `${ap} - ${ci}`;
            } else if (estado === '24h') {
                valorTexto = '24 Horas';
            } else if (estado === 'personalizado') {
                valorTexto = document.getElementById(`custom-${dia}`)?.value?.trim() || 'Horario especial';
            }

            html += `
                <div class="preview-item">
                    <span class="preview-dia">${dia}</span>
                    <span class="preview-val">${valorTexto}</span>
                </div>
            `;
        });

        previewContainer.innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', () => {
        dias.forEach(dia => toggleDia(dia));
        actualizarPreview();
    });
</script>
@endpush
