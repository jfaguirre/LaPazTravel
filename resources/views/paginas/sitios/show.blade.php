
@extends('layouts.guest')

@section('title', 'Nombre del sitio - La Paz Travel')

<style>
    .lpc-site {
        --lpc-primary: #0f766e;
        --lpc-primary-dark: #115e59;
        --lpc-dark: #0f172a;
        --lpc-muted: #64748b;
        --lpc-border: #e2e8f0;
        --lpc-bg: #f8fafc;
        color: #111827;
        line-height: 1.6;
        background: var(--lpc-bg);
    }

    .lpc-site *,
    .lpc-site *::before,
    .lpc-site *::after {
        box-sizing: border-box;
    }

    .lpc-hero {
        position: relative;
        display: flex;
        align-items: flex-end;
        min-height: 340px;
        overflow: hidden;
        background: #0f172a;
    }

    .lpc-hero img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .lpc-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(2, 6, 23, 0.86) 0%,
            rgba(2, 6, 23, 0.35) 45%,
            rgba(2, 6, 23, 0.10) 100%
        );
    }

    .lpc-hero-content {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 28px 20px;
        color: #fff;
    }

    .lpc-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 10px;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.75);
    }

    .lpc-breadcrumb a {
        color: rgba(255, 255, 255, 0.92);
        text-decoration: none;
    }

    .lpc-breadcrumb a:hover {
        text-decoration: underline;
    }

    .lpc-hero-content h1 {
        margin: 0;
        font-size: clamp(2rem, 4vw, 3.2rem);
        line-height: 1.15;
        text-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
    }

    .lpc-hero-content p {
        margin: 10px 0 0;
        max-width: 760px;
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.88);
    }

    .lpc-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 28px 20px 48px;
    }

    .lpc-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 24px;
        align-items: start;
    }

    .lpc-main {
        display: grid;
        gap: 24px;
        min-width: 0;
    }

    .lpc-card {
        background: #fff;
        border: 1px solid var(--lpc-border);
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .lpc-card h2 {
        margin: 0 0 14px;
        font-size: 1.1rem;
        color: var(--lpc-dark);
    }

    .lpc-text {
        color: #334155;
    }

    .lpc-info {
        margin: 0;
        display: grid;
        gap: 16px;
    }

    .lpc-info-item dt {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--lpc-muted);
    }

    .lpc-info-item dd {
        margin: 5px 0 0;
        color: #1f2937;
    }

    .lpc-map-link {
        display: inline-block;
        margin-top: 6px;
        color: var(--lpc-primary);
        font-weight: 600;
        text-decoration: none;
    }

    .lpc-map-link:hover {
        text-decoration: underline;
    }

    .lpc-rules {
        margin: 0;
        padding-left: 18px;
        display: grid;
        gap: 8px;
        color: #334155;
    }

    .lpc-rules li::marker {
        color: var(--lpc-primary);
    }

    .lpc-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin-top: 18px;
        padding: 11px 14px;
        border-radius: 12px;
        background: var(--lpc-primary);
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.2s ease;
    }

    .lpc-btn:hover {
        background: var(--lpc-primary-dark);
    }

    @media (max-width: 900px) {
        .lpc-grid {
            grid-template-columns: 1fr;
        }

        .lpc-hero {
            min-height: 280px;
        }
    }
</style>

@section('contenido')

<div class="lpc-site">

    <!-- PORTADA -->
    <div class="lpc-hero">
        <!-- Reemplazar la URL de la imagen por la portada real -->
        <img
            src="https://placehold.co/1600x500/000000/ffffff?text=Portada"
            alt="Portada del sitio"
        >

        <div class="lpc-hero-overlay"></div>

        <div class="lpc-hero-content">
            <!-- Reemplazar por nombre del sitio -->
            <h1>{{ $sitio->nombre }}</h1>

            <!-- Reemplazar por descripción corta -->
            <p>
                {{ $sitio->descripcion_corta }}
            </p>
        </div>
    </div>

    <div class="lpc-container">
        <div class="lpc-grid">

            <!-- CONTENIDO PRINCIPAL -->
            <main class="lpc-main">

                <!-- DESCRIPCIÓN -->
                <section class="lpc-card">
                    <h2>Descripción</h2>

                    <!-- Reemplazar por descripción completa -->
                    <div class="lpc-text">
                        <p>
                            {{ $sitio->descripcion_corta }}
                        </p>

                        <p>
                        </p>
                    </div>
                </section>

                <!-- REGLAS -->
                <section class="lpc-card">
                    <h2>Reglas</h2>

                    <!-- Reemplazar por reglas reales -->
                    <ul class="lpc-rules">
                        {{--
                        @foreach ($sitio->reglas as $r)
                            <li>{{ $r->regla }}</li>
                        @endforeach
                        --}}
                        <li>Regla de ejemplo</li>
                    </ul>
                </section>

            </main>

            <!-- INFORMACIÓN LATERAL -->
            <aside>
                <section class="lpc-card">
                    <h2>Información</h2>

                    <dl class="lpc-info">

                        <!-- DIRECCIÓN -->
                        <div class="lpc-info-item">
                            <dt>Dirección</dt>
                            <dd>
                                <!-- Reemplazar por dirección -->
                                {{ $sitio->id_departamento }}, {{ $sitio->id_distrito }} , {{ $sitio->id_municipio }} <br>
                                {{ $sitio->direccion }}

                                <br>

                                <!-- Reemplazar href por enlace de mapa -->
                                <a class="lpc-map-link" href="#" target="_blank" rel="noopener noreferrer">
                                    Ver mapa
                                </a>
                            </dd>
                        </div>

                        <!-- HORARIOS -->
                        <div class="lpc-info-item">
                            <dt>Horarios</dt>
                            <dd>
                                @if($sitio->perfil && $sitio->perfil->horarios)
                                    @php
                                        $horariosData = is_array($sitio->perfil->horarios)
                                            ? $sitio->perfil->horarios
                                            : json_decode($sitio->perfil->horarios, true);
                                    @endphp
                                    @if(is_array($horariosData) && count($horariosData) > 0)
                                        @foreach($horariosData as $dia => $horas)
                                            <div><strong>{{ ucfirst($dia) }}:</strong> {{ $horas }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                @else
                                    <span class="text-muted">No especificado</span>
                                @endif
                            </dd>
                        </div>

                        <!-- PRECIOS / TARIFAS -->
                        <div class="lpc-info-item">
                            <dt>Precios / Tarifas</dt>
                            <dd>
                                @if($sitio->perfil && $sitio->perfil->precios->isNotEmpty())
                                    @foreach($sitio->perfil->precios as $precio)
                                        <div>
                                            <strong>{{ $precio->categoria }}:</strong> ${{ number_format($precio->precioEntrada, 2) }}
                                            @if($precio->descripcion)
                                                <small class="text-muted">({{ $precio->descripcion }})</small>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-muted">No especificados</span>
                                @endif
                            </dd>
                        </div>

                        <!-- SITIO WEB -->
                        <div class="lpc-info-item">
                            <dt>Sitio web</dt>
                            <dd>
                                <!-- Reemplazar por sitio web -->
                                <a href="https://ejemplo.com" target="_blank" rel="noopener noreferrer">
                                    www.ejemplo.com
                                </a>
                            </dd>
                        </div>

                    </dl>
                </section>
            </aside>
        </div>
    </div>

</div>
    
@endsection