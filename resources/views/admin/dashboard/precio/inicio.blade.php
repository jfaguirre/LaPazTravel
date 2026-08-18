@extends('layouts.dashboardSitio')
@section('title', 'Precios y Tarifas - ' . $sitio->nombre)

@push('styles')
    @vite(['resources/css/dashboard_sitio.css'])
    <style>
        .precios-container {
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
            background: #059669;
            color: #ffffff;
            border-color: #059669;
        }

        .precios-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .precios-table th {
            background: #f1f5f9;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .precios-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            background: #ffffff;
        }

        .precios-table tr:last-child td {
            border-bottom: none;
        }

        .input-precio-cat {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
        }

        .input-precio-monto {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #047857;
        }

        .input-precio-desc {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
        }

        .btn-eliminar-fila {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-eliminar-fila:hover {
            background: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }

        .btn-agregar-fila {
            background: #ecfdf5;
            color: #047857;
            border: 1px dashed #10b981;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 10px;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-agregar-fila:hover {
            background: #10b981;
            color: #ffffff;
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
            color: #34d399;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .preview-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .preview-cat {
            font-weight: 600;
            color: #f8fafc;
        }

        .preview-desc {
            font-size: 12px;
            color: #94a3b8;
            display: block;
        }

        .preview-monto {
            font-weight: 700;
            color: #34d399;
            font-size: 16px;
        }
    </style>
@endpush

@section('contenido')
<div class="pagina">
    <div class="form-container precios-container">

        <!-- Cabecera -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Precios y tarifas del sitio</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Establece los costos de entrada, boletaje, tours o servicios en <strong>{{ $sitio->nombre }}</strong>.</p>
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

        @if(session('info'))
            <div class="alert alert-info mb-4" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
            </div>
        @endif

        @if($tieneSolicitudPendiente)
            <div class="alert alert-warning mb-4 d-flex align-items-center" role="alert">
                <i class="bi bi-clock-history fs-4 me-3 text-warning"></i>
                <div>
                    <strong>Solicitud en revisión:</strong> Ya tienes una solicitud de actualización de precios pendiente de aprobación. No se pueden realizar modificaciones hasta que la solicitud actual sea procesada.
                </div>
            </div>
        @endif

        <!-- Barra de Acciones Rápidas -->
        <div class="quick-actions-bar">
            <div class="quick-actions-title">
                <i class="bi bi-grip-vertical"></i> Plantillas de tarifas:
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="quick-btn" onclick="cargarPlantillaEstandar()" @if($tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-person-badge me-1"></i> Entrada General / Niños / Tercera Edad
                </button>
                <button type="button" class="quick-btn" onclick="cargarPlantillaGratis()" @if($tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-ticket-perforated me-1"></i> Entrada Gratuita ($0.00)
                </button>
                <button type="button" class="quick-btn" onclick="vaciarPrecios()" @if($tieneSolicitudPendiente) disabled @endif>
                    <i class="bi bi-trash me-1"></i> Limpiar Todo
                </button>
            </div>
        </div>

        <form id="form-precios" class="form-card" action="{{ route('precio.update') }}" method="POST">
            @csrf
            @method('put')

            <div class="form-section-title">
                <i class="bi bi-cash-stack me-2"></i> Lista de Precios y Tarifas
            </div>

            <div class="table-responsive">
                <table class="precios-table" id="tabla-precios">
                    <thead>
                        <tr>
                            <th style="width: 35%;">Categoría / Tipo <span class="text-danger">*</span></th>
                            <th style="width: 25%;">Precio ($ USD) <span class="text-danger">*</span></th>
                            <th style="width: 33%;">Descripción / Detalles</th>
                            <th style="width: 7%; text-align: center;"><i class="bi bi-gear-fill"></i></th>
                        </tr>
                    </thead>
                    <tbody id="tbody-precios">
                        <!-- Las filas se renderizan dinámicamente -->
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn-agregar-fila mb-4" onclick="agregarFilaPrecio()" @if($tieneSolicitudPendiente) disabled @endif>
                <i class="bi bi-plus-circle-fill"></i> Agregar otra tarifa o precio
            </button>

            <!-- Vista previa en tiempo real -->
            <div class="preview-card">
                <div class="preview-header">
                    <i class="bi bi-eye-fill"></i> Vista previa pública de tarifas
                </div>
                <div id="preview-lista-precios">
                    <!-- Se llena dinámicamente -->
                </div>
            </div>

            <!-- Botones de Acción -->
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
    const preciosIniciales = @json($precios);
    const tieneSolicitudPendiente = @json($tieneSolicitudPendiente);
    let contadorFilas = 0;

    function agregarFilaPrecio(id = '', categoria = '', precioEntrada = '', descripcion = '') {
        const tbody = document.getElementById('tbody-precios');
        if (!tbody) return;

        const index = contadorFilas++;
        const tr = document.createElement('tr');
        tr.id = `fila-precio-${index}`;

        const disabledAttr = tieneSolicitudPendiente ? 'disabled' : '';

        tr.innerHTML = `
            <td>
                <input type="hidden" name="precios[${index}][id]" value="${id}">
                <input type="hidden" name="precios[${index}][eliminar]" id="eliminar-${index}" value="0">
                <input type="text" name="precios[${index}][categoria]" value="${categoria}" 
                    placeholder="Ej: Entrada General, Niños, Tour" class="input-precio-cat" 
                    required oninput="actualizarPreviewPrecios()" ${disabledAttr}>
            </td>
            <td>
                <div class="input-group input-group-sm d-flex flex-row">                   
                    <input type="number" step="0.01" min="0" name="precios[${index}][precioEntrada]" value="${precioEntrada !== '' ? precioEntrada : ''}" 
                        placeholder="0.00" class="input-precio-monto" required oninput="actualizarPreviewPrecios()" ${disabledAttr}>
                </div>
            </td>
            <td>
                <input type="text" name="precios[${index}][descripcion]" value="${descripcion}" 
                    placeholder="Ej: Mayores de 12 años, presentando carnet" class="input-precio-desc" 
                    maxlength="100" oninput="actualizarPreviewPrecios()" ${disabledAttr}>
            </td>
            <td style="text-align: center;">
                <button type="button" class="btn-eliminar-fila" onclick="eliminarFilaPrecio(${index})" title="Eliminar tarifa" ${disabledAttr}>
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        actualizarPreviewPrecios();
    }

    function eliminarFilaPrecio(index) {
        const tr = document.getElementById(`fila-precio-${index}`);
        if (!tr) return;

        const idInput = tr.querySelector(`input[name="precios[${index}][id]"]`);
        if (idInput && idInput.value) {
            // Si ya existe en DB, marcarlo como eliminado y ocultar la fila
            const inputEliminar = document.getElementById(`eliminar-${index}`);
            if (inputEliminar) inputEliminar.value = "1";
            tr.style.display = 'none';

            // Quitar requeridos
            tr.querySelectorAll('input').forEach(inp => inp.removeAttribute('required'));
        } else {
            // Si es nueva fila aún no guardada, remover directamente del DOM
            tr.remove();
        }

        actualizarPreviewPrecios();
    }

    function cargarPlantillaEstandar() {
        const tbody = document.getElementById('tbody-precios');
        tbody.innerHTML = '';
        contadorFilas = 0;

        agregarFilaPrecio('', 'Entrada General', '3.00', 'Aplica para adultos e individuales');
        agregarFilaPrecio('', 'Niños y Estudiantes', '1.50', 'Menores de 12 años o estudiantes con carnet');
        agregarFilaPrecio('', 'Tercera Edad y Discapacidad', '0.00', 'Gratuito acreditando documentación');
    }

    function cargarPlantillaGratis() {
        const tbody = document.getElementById('tbody-precios');
        tbody.innerHTML = '';
        contadorFilas = 0;

        agregarFilaPrecio('', 'Entrada General', '0.00', 'Acceso libre e impositivo para todo público');
    }

    function vaciarPrecios() {
        const tbody = document.getElementById('tbody-precios');
        tbody.innerHTML = '';
        contadorFilas = 0;
        agregarFilaPrecio();
    }

    function actualizarPreviewPrecios() {
        const previewContainer = document.getElementById('preview-lista-precios');
        if (!previewContainer) return;

        const tbody = document.getElementById('tbody-precios');
        const filas = tbody.querySelectorAll('tr');

        let html = '';
        let count = 0;

        filas.forEach(tr => {
            if (tr.style.display === 'none') return;

            const cat = tr.querySelector('.input-precio-cat')?.value?.trim() || '';
            const montoRaw = tr.querySelector('.input-precio-monto')?.value;
            const desc = tr.querySelector('.input-precio-desc')?.value?.trim() || '';

            if (cat !== '' || (montoRaw !== undefined && montoRaw !== '')) {
                const montoNum = parseFloat(montoRaw) || 0;
                const montoFormateado = montoNum === 0 ? 'Gratis ($0.00)' : `$${montoNum.toFixed(2)}`;

                html += `
                    <div class="preview-item">
                        <div>
                            <div class="preview-cat">${cat || 'Sin nombre'}</div>
                            ${desc ? `<span class="preview-desc">${desc}</span>` : ''}
                        </div>
                        <div class="preview-monto">${montoFormateado}</div>
                    </div>
                `;
                count++;
            }
        });

        if (count === 0) {
            html = '<p class="text-muted mb-0 small" style="color: #94a3b8;"><i class="bi bi-info-circle me-1"></i> No se han ingresado tarifas aún.</p>';
        }

        previewContainer.innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (preciosIniciales && preciosIniciales.length > 0) {
            preciosIniciales.forEach(p => {
                agregarFilaPrecio(p.id, p.categoria, p.precioEntrada, p.descripcion || '');
            });
        } else {
            agregarFilaPrecio('', 'Entrada General', '2.00', 'Acceso para todo público');
        }
    });
</script>
@endpush
