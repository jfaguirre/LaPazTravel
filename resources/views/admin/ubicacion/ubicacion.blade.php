@extends('layouts.app')
@section('title', 'Ubicación del sitio')

@push('styles')
    @vite(['resources/css/dashboard_sitio.css'])
    <style>
        .reglas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .selectable-card {
            border: 2px solid var(--border);
            border-radius: var(--radius-md);
            padding: 28px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--blanco);
            text-align: center;
            position: relative;
            user-select: none;
            min-height: 150px;
        }
        .selectable-card:hover {
            transform: translateY(-4px);
            border-color: var(--primario-claro);
            box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        }
        .selectable-card.selected {
            border-color: var(--primario);
            background-color: var(--primario-50);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }
        .selectable-card.selected::after {
            content: "\F272"; /* Bootstrap Icons check-circle-fill */
            font-family: "bootstrap-icons";
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 20px;
            color: var(--primario);
            line-height: 1;
        }
        .icon-container {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background-color: var(--neutro-100);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            transition: all 0.25s ease;
            color: var(--neutro-700);
        }
        .selectable-card.selected .icon-container {
            background-color: var(--blanco);
            color: var(--primario);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
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
            margin: 0;
            line-height: 1.3;
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
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Selecciona el departamento, municipio y distrito</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Define la ubicación de tu centro turistico para que tus usuarios puedan encontrarte mas rapido.</p>
            </div>
            <a href="{{ route('perfil.create') }}" class="step-link" style="font-size: 14.5px;">
                <i class="bi bi-arrow-left-short" style="font-size: 20px; line-height: 1;"></i> Volver al panel
            </a>
        </div>

        <!-- Formulario -->
        <form action="{{ route('perfil.ubicacion.store') }}" method="POST">
            @csrf
            <livewire:ubicacion />
        </form>
    </div>
</div>
@endsection

