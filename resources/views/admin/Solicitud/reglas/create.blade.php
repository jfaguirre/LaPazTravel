@extends('layouts.app')
@section('title', 'Agregar Reglas')

@push('styles')
    @vite(['resources/css/dashboard_sitio.css'])
    <style>
        .reglas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .selectable-card {
            border: 2px solid var(--border);
            border-radius: var(--radius-md);
            padding: 24px 16px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--blanco);
            text-align: center;
            position: relative;
            user-select: none;
            min-height: 180px;
        }
        .selectable-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        }

        /* Estilos Verde (Permitido = 1) */
        .selectable-card.is-permitido.selected {
            border-color: #059669;
            background-color: #f0fdf4;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.12);
        }
        .selectable-card.is-permitido.selected::after {
            content: "\F272"; /* Bootstrap Icons check-circle-fill */
            font-family: "bootstrap-icons";
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 20px;
            color: #059669;
            line-height: 1;
        }
        .selectable-card.is-permitido.selected .icon-container {
            background-color: #d1fae5;
            color: #059669;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }

        /* Estilos Rojo (No Permitido = 0) */
        .selectable-card.is-no-permitido.selected {
            border-color: #dc2626;
            background-color: #fef2f2;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.12);
        }
        .selectable-card.is-no-permitido.selected::after {
            content: "\F272"; /* Bootstrap Icons check-circle-fill */
            font-family: "bootstrap-icons";
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 20px;
            color: #dc2626;
            line-height: 1;
        }
        .selectable-card.is-no-permitido.selected .icon-container {
            background-color: #fee2e2;
            color: #dc2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }

        .icon-container {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background-color: var(--neutro-100);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            transition: all 0.25s ease;
            color: var(--neutro-700);
        }
        .icon-container i {
            font-size: 24px;
        }
        .icon-container img {
            width: 26px;
            height: 26px;
            object-fit: contain;
        }
        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--neutro-800);
            margin: 0 0 10px 0;
            line-height: 1.3;
        }

        .permitido-toggle-wrapper {
            margin-top: auto;
            display: none;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .selectable-card.selected .permitido-toggle-wrapper {
            display: flex;
        }
        .permitido-toggle-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            transition: all 0.2s ease;
            user-select: none;
        }
        .selectable-card.is-permitido .permitido-toggle-label {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .selectable-card.is-no-permitido .permitido-toggle-label {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        .permitido-checkbox {
            cursor: pointer;
            width: 15px;
            height: 15px;
            accent-color: #059669;
        }
        .selectable-card.is-no-permitido .permitido-checkbox {
            accent-color: #dc2626;
        }

        .btn-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 16px;
            border-top: 2px solid var(--border);
            padding-top: 24px;
            margin-top: 16px;
        }
        .btn-cancel {
            background-color: var(--blanco);
            border: 2px solid var(--border);
            color: var(--neutro-700);
            padding: 10px 24px;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-cancel:hover {
            background-color: var(--neutro-100);
            border-color: var(--neutro-300);
            color: var(--neutro-800);
        }
        .btn-submit {
            background-color: var(--primario);
            color: var(--blanco);
            border: none;
            padding: 12px 28px;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-submit:hover {
            background-color: var(--primario-oscuro);
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('contenido')
<div id="page-dashboard" class="page">
    <div class="dashboard-card" style="max-width: 900px; padding: 40px;">
        <!-- Cabecera -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Selecciona las Reglas del Sitio</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Elige las normativas de seguridad, prohibiciones y pautas que los turistas deben seguir en <strong>{{ $sitio->nombre }}</strong>.</p>
            </div>
            <a href="{{ route('perfil.create') }}" class="step-link" style="font-size: 14.5px;">
                <i class="bi bi-arrow-left-short" style="font-size: 20px; line-height: 1;"></i> Volver al panel
            </a>
        </div>

        <!-- Formulario -->
        <form action="{{ route('regla.store') }}" method="POST">
            @csrf

            @if($reglas->isEmpty())
                <div style="background-color: var(--primario-50); border-radius: var(--radius-md); padding: 24px; border: 1px solid var(--primario-100); text-align: center;">
                    <p style="margin: 0; color: var(--neutro-700); font-weight: 600;">No hay reglas disponibles en este momento.</p>
                </div>
            @else
                <div class="reglas-grid">
                    @foreach($reglas as $rg)
                        @php
                            $isSelected = in_array($rg->id, $selectedReglas);
                            $isPermitido = $isSelected && isset($selectedReglasMap[$rg->id]) ? (bool)$selectedReglasMap[$rg->id] : false;
                        @endphp
                        <div class="selectable-card @if($isSelected) selected @endif @if($isPermitido) is-permitido @else is-no-permitido @endif"
                             data-id="{{ $rg->id }}">

                            <input type="checkbox" name="reglas[]" value="{{ $rg->id }}" class="hidden-checkbox d-none" @if($isSelected) checked @endif>

                            <div class="icon-container">
                                @if(Str::startsWith($rg->icono, 'bi-'))
                                    <i class="bi {{ $rg->icono }}"></i>
                                @else
                                    <img src="{{ asset($rg->icono) }}" alt="{{ $rg->regla }}">
                                @endif
                            </div>

                            <span class="card-title">{{ $rg->regla }}</span>

                            <div class="permitido-toggle-wrapper" onclick="event.stopPropagation();">
                                <input type="hidden" name="permitido[{{ $rg->id }}]" value="0">
                                <label class="permitido-toggle-label">
                                    <input type="checkbox"
                                           name="permitido[{{ $rg->id }}]"
                                           value="1"
                                           class="permitido-checkbox"
                                           @if($isPermitido) checked @endif>
                                    <span class="permitido-text">{{ $isPermitido ? 'Permitido' : 'No permitido' }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="btn-container">
                <a href="{{ route('perfil.create') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">
                    Guardar Cambios <i class="bi bi-check-lg" style="font-size: 16px;"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.selectable-card');

        cards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.closest('.permitido-toggle-wrapper')) {
                    return;
                }

                const checkbox = this.querySelector('.hidden-checkbox');
                const permitidoCheckbox = this.querySelector('.permitido-checkbox');
                const textSpan = this.querySelector('.permitido-text');

                if (e.target !== checkbox) {
                    checkbox.checked = !checkbox.checked;
                }

                if (checkbox.checked) {
                    this.classList.add('selected');
                } else {
                    this.classList.remove('selected');
                    if (permitidoCheckbox) {
                        permitidoCheckbox.checked = false;
                    }
                    this.classList.remove('is-permitido');
                    this.classList.add('is-no-permitido');
                    if (textSpan) {
                        textSpan.textContent = 'No permitido';
                    }
                }
            });
        });

        const permitidoCheckboxes = document.querySelectorAll('.permitido-checkbox');
        permitidoCheckboxes.forEach(chk => {
            chk.addEventListener('change', function(e) {
                e.stopPropagation();
                const card = this.closest('.selectable-card');
                const textSpan = card.querySelector('.permitido-text');

                if (this.checked) {
                    card.classList.remove('is-no-permitido');
                    card.classList.add('is-permitido');
                    if (textSpan) textSpan.textContent = 'Permitido';
                } else {
                    card.classList.remove('is-permitido');
                    card.classList.add('is-no-permitido');
                    if (textSpan) textSpan.textContent = 'No permitido';
                }
            });
        });
    });
</script>
@endpush
