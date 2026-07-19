@extends('layouts.app')
@section('title', 'Revisar Sitio - ' . $sitio->nombre)

@section('contenido')
<div class="container py-5" style="margin-bottom: 180px;">

    <!-- Botón de retorno -->
    <div class="mb-4">
        <a href="{{ route('dashboard')}}" class="btn btn-link link-dark p-0 text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i> Volver al Panel
        </a>
    </div>

    <!-- Cabecera -->
    <div class="card shadow-sm border-0 mb-4 overflow-hidden">
        <!-- Foto de Portada con Banner según el Estado -->
        <div class="bg-secondary position-relative" style="height: 200px; @if($sitio->perfil && $sitio->perfil->foto_portada) background: url('{{ asset('storage/' . $sitio->perfil->foto_portada) }}') center/cover no-repeat; @endif">
            
            @if($sitio->estado == 'PENDIENTE')
                <span class="badge bg-warning text-dark font-weight-bold position-absolute top-0 end-0 m-3 fs-6 shadow-sm">
                    <i class="bi bi-hourglass-split me-1"></i> Pendiente de Aprobación
                </span>
            @elseif($sitio->estado == 'APROBADO' || $sitio->estado == 'PUBLICADO')
                <span class="badge bg-success text-white font-weight-bold position-absolute top-0 end-0 m-3 fs-6 shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> Sitio Publicado
                </span>
            @elseif($sitio->estado == 'SUSPENDIDO')
                <span class="badge bg-danger text-white font-weight-bold position-absolute top-0 end-0 m-3 fs-6 shadow-sm">
                    <i class="bi bi-dash-circle-fill me-1"></i> Sitio Suspendido
                </span>
            @else
                <span class="badge bg-secondary text-white font-weight-bold position-absolute top-0 end-0 m-3 fs-6 shadow-sm">
                    <i class="bi bi-info-circle me-1"></i> {{ ucfirst($sitio->estado) }}
                </span>
            @endif

        </div>
        
        <div class="card-body position-relative pt-0 px-4 pb-4">
            <!-- Foto de Perfil -->
            <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-end" style="margin-top: -60px;">
                <div class="bg-white p-1 rounded-circle shadow-sm mb-3 mb-sm-0" style="width: 120px; height: 120px; z-index: 2;">
                    @if($sitio->perfil && $sitio->perfil->foto_perfil)
                        <img src="{{ asset('storage/' . $sitio->perfil->foto_perfil) }}" class="rounded-circle w-100 h-100" style="object-fit: cover;" alt="Logo/Perfil">
                    @else
                        <div class="rounded-circle w-100 h-100 bg-light d-flex align-items-center justify-content-center border">
                            <i class="bi bi-shop fs-1 text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="ms-sm-4 text-center text-sm-start">
                    <h1 class="h2 font-weight-bold mb-1 text-gray-900">{{ $sitio->nombre }}</h1>
                    <p class="text-muted mb-0">
                        Propietario: <strong class="text-dark">{{ $sitio->usuario->name }} {{ $sitio->usuario->lastName }}</strong> ({{ $sitio->usuario->email }})
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Columna de Datos Técnicos y de Contacto -->
        <div class="col-12 col-lg-8">
            <!--Descripción e Información Básica -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-card-text me-2 text-primary"></i>Descripción del Sitio</h5>
                    <p class="text-muted fs-5 mb-0" style="white-space: pre-line;">{{ $sitio->descripcion_corta }}</p>
                    
                    @if($sitio->perfil && $sitio->perfil->identificador)
                        <div class="mt-3 p-2 bg-light rounded d-inline-block">
                            <span class="small font-weight-semibold text-muted">IDENTIFICADOR ÚNICO:</span> 
                            <code class="text-dark font-weight-bold">{{ $sitio->perfil->identificador }}</code>
                        </div>
                    @endif
                </div>
            </div>

            <!--Ubicación Geográfica -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-geo-alt me-2 text-danger"></i>Ubicación</h5>
                    <div class="row g-3">
                        <div class="col-12 col-sm-4">
                            <span class="text-muted small d-block font-weight-bold text-uppercase">Departamento</span>
                            <span class="text-dark font-weight-semibold">{{ $sitio->perfil->departamento->departamento ?? 'No especificado' }}</span>
                        </div>
                        <div class="col-12 col-sm-4">
                            <span class="text-muted small d-block font-weight-bold text-uppercase">Distrito</span>
                            <span class="text-dark font-weight-semibold">{{ $sitio->perfil->distrito->distrito ?? 'No especificado' }}</span>
                        </div>
                        <div class="col-12 col-sm-4">
                            <span class="text-muted small d-block font-weight-bold text-uppercase">Municipio</span>
                            <span class="text-dark font-weight-semibold">{{ $sitio->perfil->municipio->municipio ?? 'No especificado' }}</span>
                        </div>
                        <div class="col-12">
                            <span class="text-muted small d-block font-weight-bold text-uppercase">Dirección Completa</span>
                            <span class="text-dark">{{ $sitio->perfil->direccion ?? 'No se proporcionó dirección física.' }}</span>
                        </div>
                        
                        @if($sitio->perfil && $sitio->perfil->latitud && $sitio->perfil->longitud)
                            <div class="col-12">
                                <span class="text-muted small d-block font-weight-bold text-uppercase mb-2">Coordenadas del Mapa</span>
                                <div class="p-3 bg-light rounded border border-dashed d-flex align-items-center">
                                    <i class="bi bi-map-fill fs-4 text-primary me-3"></i>
                                    <div>
                                        <div class="small"><strong>Latitud:</strong> {{ $sitio->perfil->latitud }} | <strong>Longitud:</strong> {{ $sitio->perfil->longitud }}</div>
                                        <a href="https://www.google.com/maps?q={{ $sitio->perfil->latitud }},{{ $sitio->perfil->longitud }}" target="_blank" class="btn btn-sm btn-link p-0 text-decoration-none">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>Ver en Google Maps
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!--Precios del Establecimiento -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-cash-stack me-2 text-success"></i>Lista de Precios</h5>
                    @if($sitio->perfil && $sitio->perfil->precios->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Categoría de Ticket / Entrada</th>
                                        <th>Precio</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sitio->perfil->precios as $precio)
                                        <tr>
                                            <td class="font-weight-semibold text-dark">{{ $precio->categoria }}</td>
                                            <td><span class="badge bg-success fs-6">${{ number_format($precio->precioEntrada, 2) }}</span></td>
                                            <td class="text-muted small">{{ $precio->descripcion ?? 'Sin descripción' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i> No se han registrado tarifas o precios para este sitio.</p>
                    @endif
                </div>
            </div>

            <!--Galería de Imágenes Adicionales -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-images me-2 text-info"></i>Galería de Imágenes</h5>
                    @if($sitio->imagenes->isNotEmpty())
                        <div class="row g-2">
                            @foreach($sitio->imagenes as $img)
                                <div class="col-6 col-sm-4 col-md-3">
                                    <div class="position-relative overflow-hidden rounded shadow-sm border" style="height: 120px;">
                                        <img src="{{ asset('storage/' . $img->url) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $img->titulo ?? 'Imagen del Sitio' }}">
                                        @if($img->principal)
                                            <span class="badge bg-primary position-absolute top-0 start-0 m-1 font-weight-bold small" style="font-size: 10px;">Principal</span>
                                        @endif
                                    </div>
                                    @if($img->titulo)
                                        <p class="small text-muted text-center mt-1 text-truncate">{{ $img->titulo }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i> El propietario no ha añadido fotos adicionales a la galería.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Columna Derecha -->
        <div class="col-12 col-lg-4">
            <!--Datos Rápidos de Contacto & Redes -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-info-circle-fill text-muted me-2"></i>Contacto e Info</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-telephone text-primary fs-5 me-3"></i>
                            <div>
                                <small class="text-muted d-block uppercase-font">Teléfono</small>
                                <span class="font-weight-semibold text-dark">{{ $sitio->perfil->telefono ?? 'No especificado' }}</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-envelope-at text-primary fs-5 me-3"></i>
                            <div class="text-truncate">
                                <small class="text-muted d-block">Correo Institucional</small>
                                <span class="font-weight-semibold text-dark text-truncate d-block">{{ $sitio->perfil->correo_institucional ?? 'No especificado' }}</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-globe text-primary fs-5 me-3"></i>
                            <div class="text-truncate">
                                <small class="text-muted d-block">Sitio Web Externo</small>
                                @if($sitio->perfil && $sitio->perfil->sitio_web)
                                    <a href="{{ $sitio->perfil->sitio_web }}" target="_blank" class="text-decoration-none font-weight-semibold text-primary text-truncate d-block">{{ $sitio->perfil->sitio_web }}</a>
                                @else
                                    <span class="text-muted">No especificado</span>
                                @endif
                            </div>
                        </li>
                    </ul>

                    @if($sitio->perfil)
                        <hr class="my-3 opacity-25">
                        <div class="d-flex justify-content-around">
                            @if($sitio->perfil->facebook) <a href="{{ $sitio->perfil->facebook }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm"><i class="bi bi-facebook"></i></a> @endif
                            @if($sitio->perfil->instagram) <a href="{{ $sitio->perfil->instagram }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm"><i class="bi bi-instagram"></i></a> @endif
                            @if($sitio->perfil->tiktok) <a href="{{ $sitio->perfil->tiktok }}" target="_blank" class="btn btn-outline-dark btn-sm rounded-circle shadow-sm"><i class="bi bi-tiktok"></i></a> @endif
                            @if($sitio->perfil->youtube) <a href="{{ $sitio->perfil->youtube }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm"><i class="bi bi-youtube"></i></a> @endif
                        </div>
                    @endif
                </div>
            </div>

            <!--Categorías -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-tags me-2 text-warning"></i>Categorías</h5>
                    @if($sitio->perfil && $sitio->perfil->categorias->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sitio->perfil->categorias as $cat)
                                <span class="badge border p-2 text-dark font-weight-bold shadow-sm d-flex align-items-center" style="background-color: {{ $cat->color ?? '#f8f9fa' }}; border-color: rgba(0,0,0,0.1) !important;">
                                    <i class="bi {{ $cat->icono }} me-2"></i> {{ $cat->nombre }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0 small">No tiene categorías asociadas.</p>
                    @endif
                </div>
            </div>

            <!-- Servicios Ofrecidos -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-patch-check me-2 text-primary"></i>Servicios</h5>
                    @if($sitio->perfil && $sitio->perfil->servicios->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sitio->perfil->servicios as $serv)
                                <span class="badge bg-light text-dark border p-2 d-flex align-items-center rounded-pill">
                                    <i class="bi {{ $serv->icono }} me-2 text-primary"></i> {{ $serv->servicio }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0 small">No ofrece servicios de momento.</p>
                    @endif
                </div>
            </div>

            <!--Reglas del Sitio -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-exclamation-octagon me-2 text-danger"></i>Reglas e Indicaciones</h5>
                    @if($sitio->perfil && $sitio->perfil->reglas->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sitio->perfil->reglas as $regla)
                                <span class="badge bg-light text-dark border p-2 d-flex align-items-center rounded-pill">
                                    <i class="bi {{ $regla->icono }} me-2 text-danger"></i> {{ $regla->regla }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0 small">No se han listado reglas especiales.</p>
                    @endif
                </div>
            </div>

            <!--Horarios de Atención -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="bi bi-clock me-2 text-info"></i>Horarios de Atención</h5>
                    @if($sitio->perfil && $sitio->perfil->horarios)
                        @php $horarios = json_decode($sitio->perfil->horarios, true); @endphp
                        @if(is_array($horarios))
                            <ul class="list-group list-group-flush small">
                                @foreach($horarios as $dia => $horas)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 bg-transparent">
                                        <span class="text-capitalize font-weight-bold">{{ $dia }}</span>
                                        <span class="text-muted">{{ $horas }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0 small">Formato de horarios incorrecto.</p>
                        @endif
                    @else
                        <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1"></i> No se han especificado horarios.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<!--BARRA FLOTANTE FIJA -->
<div class="fixed-bottom bg-white border-top shadow-lg py-3" x-data="{ formulario: '' }" style="z-index: 1030;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Título izquierdo -->
            <div class="col-12 col-xl-4 d-none d-xl-block">
                <h6 class="mb-1 font-weight-bold text-gray-900">Panel de Control: {{ $sitio->nombre }}</h6>
                <p class="text-muted small mb-0">Estado actual: <span class="text-uppercase font-weight-bold text-primary">{{ $sitio->estado }}</span></p>
            </div>
            
            <!-- Grupo completo de Botones Modificadores -->
            <div class="col-12 col-xl-8">
                <div class="d-flex flex-wrap gap-2 justify-content-xl-end">
                    
                    <!-- Botón Reestablecer a Pendiente (Solo visible si no está pendiente) -->
                    @if($sitio->estado != 'pendiente')
                        <form action="{{ route('admin.sitios.pendiente', $sitio->id) }}" method="POST" class="m-0 flex-grow-1 flex-md-grow-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-warning text-dark w-100 px-3 py-2 font-weight-bold">
                                <i class="bi bi-hourglass-split me-1"></i> Poner Pendiente
                            </button>
                        </form>
                    @endif

                    <!-- Botón Suspender -->
                    @if($sitio->estado != 'suspendido')
                        <button class="btn btn-dark px-3 py-2 font-weight-bold flex-grow-1 flex-md-grow-0" 
                                type="button" 
                                @click="formulario = (formulario === 'suspender' ? '' : 'suspender')">
                            <i class="bi bi-dash-circle me-1"></i> Suspender
                        </button>
                    @endif

                    <!-- Botón Rechazar -->
                    <button class="btn btn-outline-danger px-3 py-2 font-weight-bold flex-grow-1 flex-md-grow-0" 
                            type="button" 
                            @click="formulario = (formulario === 'rechazar' ? '' : 'rechazar')">
                        <i class="bi bi-x-lg me-1"></i> Rechazar
                    </button>
                    
                    <!-- Botón Aprobar -->
                    @if($sitio->estado != 'aprobado' && $sitio->estado != 'publicado')
                        <form action="{{ route('admin.sitios.aprobar', $sitio->id) }}" method="POST" class="m-0 flex-grow-1 flex-md-grow-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100 px-4 py-2 font-weight-bold shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Aprobar y Publicar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SUB-FORMULARIOS CONTROLADOS POR ALPINE -->
        <!-- ========================================== -->

        <!-- Formulario: Rechazar Solicitud -->
        <div class="mt-3" x-show="formulario === 'rechazar'" x-cloak style="display: none;" x-transition>
            <div class="card card-body bg-light border-0 p-3 mb-0 shadow-inner">
                <form action="{{ route('admin.sitios.rechazar', $sitio->id) }}" method="POST" class="mb-0">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="motivo_rechazo" class="form-label font-weight-bold text-muted small text-uppercase">Razón del Rechazo</label>
                        <textarea class="form-control" id="motivo_rechazo" name="motivo" rows="2" placeholder="Ej. Las fotos tienen baja calidad o información inconsistente..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light btn-sm font-weight-bold" @click="formulario = ''">Cancelar</button>
                        <button type="submit" class="btn btn-danger btn-sm font-weight-bold shadow-sm">Enviar Rechazo</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Formulario: Suspender Sitio -->
        <div class="mt-3" x-show="formulario === 'suspender'" x-cloak style="display: none;" x-transition>
            <div class="card card-body bg-light border-0 p-3 mb-0 shadow-inner">
                <form action="{{ route('admin.sitios.suspender', $sitio->id) }}" method="POST" class="mb-0">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="motivo_suspension" class="form-label font-weight-bold text-muted small text-uppercase">Motivo de la Suspensión</label>
                        <textarea class="form-control" id="motivo_suspension" name="motivo" rows="2" placeholder="Ej. Incumplimiento de términos, reportes de usuarios o inactividad comercial..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light btn-sm font-weight-bold" @click="formulario = ''">Cancelar</button>
                        <button type="submit" class="btn btn-dark btn-sm font-weight-bold shadow-sm">Confirmar Suspensión</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection