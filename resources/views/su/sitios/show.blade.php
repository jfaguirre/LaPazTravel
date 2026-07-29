@extends('layouts.su')
@section('title', 'Revisar Sitio - ' . $sitio->nombre)

@section('contenido')
<div class="container py-4" style="margin-bottom: 140px;">

    <!-- Botón de retorno -->
    <div class="mb-3">
        <a href="{{ route('su.sitios.index')}}" class="btn btn-sm btn-light border text-secondary rounded-pill px-3 shadow-sm d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
    </div>

    <!-- Cabecera -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <!-- Foto de Portada con Banner según el Estado -->
        <div class="position-relative bg-secondary bg-gradient" style="height: 180px; @if($sitio->perfil && $sitio->perfil->foto_portada) background: url('{{ asset('storage/' . $sitio->perfil->foto_portada) }}') center/cover no-repeat; @endif">
            <div class="position-absolute top-0 end-0 p-3">
                @if($sitio->estado == 'PENDIENTE')
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm fs-6">
                        <i class="bi bi-hourglass-split me-1"></i> Pendiente de Aprobación
                    </span>
                @elseif($sitio->estado == 'APROBADO' || $sitio->estado == 'PUBLICADO')
                    <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm fs-6">
                        <i class="bi bi-check-circle-fill me-1"></i> Sitio Publicado
                    </span>
                @elseif($sitio->estado == 'SUSPENDIDO')
                    <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm fs-6">
                        <i class="bi bi-dash-circle-fill me-1"></i> Sitio Suspendido
                    </span>
                @else
                    <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm fs-6">
                        <i class="bi bi-info-circle me-1"></i> {{ ucfirst($sitio->estado) }}
                    </span>
                @endif
            </div>
        </div>
        
        <div class="card-body p-4 bg-white">
            <!-- Foto de Perfil -->
            <div class="d-flex flex-column flex-md-row align-items-center align-items-md-end gap-3" style="margin-top: -60px;">
                <div class="position-relative">
                    <div class="rounded-circle bg-white p-1 shadow" style="width: 110px; height: 110px;">
                        @if($sitio->perfil && $sitio->perfil->foto_perfil)
                            <img src="{{ asset('storage/' . $sitio->perfil->foto_perfil) }}" class="rounded-circle w-100 h-100" style="object-fit: cover;" alt="Logo/Perfil">
                        @else
                            <div class="rounded-circle w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted border">
                                <i class="bi bi-shop fs-2"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="flex-grow-1 text-center text-md-start">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
                        <div>
                            <h2 class="h3 font-weight-bold mb-1 text-dark">{{ $sitio->nombre }}</h2>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-person me-1"></i> Propietario: <strong class="text-dark">{{ $sitio->usuario->name }} {{ $sitio->usuario->lastName }}</strong> 
                                <span class="mx-1">•</span> <i class="bi bi-envelope me-1"></i>{{ $sitio->usuario->email }}
                            </p>
                        </div>
                        @if($sitio->perfil && $sitio->perfil->identificador)
                            <div class="badge bg-light text-dark border px-3 py-2 rounded-3 text-start">
                                <span class="d-block text-muted" style="font-size: 10px;">IDENTIFICADOR ÚNICO</span>
                                <code>{{ $sitio->perfil->identificador }}</code>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación por pestañas y contenido -->
    <div class="row g-4">
        <!-- Columna de Datos Técnicos y de Contacto -->
        <div class="col-12 col-lg-8">
            
            <!--Descripción e Información Básica -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-card-text me-2 text-primary"></i>Descripción del Sitio</h6>
                    <p class="text-secondary lh-base mb-0" style="white-space: pre-line;">{{ $sitio->descripcion_corta }}</p>
                </div>
            </div>

            <!--Ubicación Geográfica -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-geo-alt me-2 text-danger"></i>Ubicación</h6>
                    <div class="row g-3">
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small font-weight-bold">DEPARTAMENTO</span>
                                <span class="text-dark fw-semibold">{{ $sitio->perfil->departamento->departamento ?? 'No especificado' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small font-weight-bold">DISTRITO</span>
                                <span class="text-dark fw-semibold">{{ $sitio->perfil->distrito->distrito ?? 'No especificado' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small font-weight-bold">MUNICIPIO</span>
                                <span class="text-dark fw-semibold">{{ $sitio->perfil->municipio->municipio ?? 'No especificado' }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small font-weight-bold">DIRECCIÓN COMPLETA</span>
                                <span class="text-dark">{{ $sitio->perfil->direccion ?? 'No se proporcionó dirección física.' }}</span>
                            </div>
                        </div>
                        
                        @if($sitio->perfil && $sitio->perfil->latitud && $sitio->perfil->longitud)
                            <div class="col-12">
                                <div class="p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-map-fill fs-3 text-primary me-3"></i>
                                        <div>
                                            <span class="d-block fw-bold text-dark small">Coordenadas del Mapa</span>
                                            <span class="small text-muted">Lat: {{ $sitio->perfil->latitud }} | Long: {{ $sitio->perfil->longitud }}</span>
                                        </div>
                                    </div>
                                    <a href="https://www.google.com/maps?q={{ $sitio->perfil->latitud }},{{ $sitio->perfil->longitud }}" target="_blank" class="btn btn-primary btn-sm rounded-pill px-3">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Ver en Google Maps
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!--Precios del Establecimiento -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-cash-stack me-2 text-success"></i>Lista de Precios</h6>
                    @if($sitio->perfil && $sitio->perfil->precios->isNotEmpty())
                        <div class="table-responsive rounded-3 border">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th>Categoría de Ticket / Entrada</th>
                                        <th>Precio</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sitio->perfil->precios as $precio)
                                        <tr>
                                            <td class="fw-semibold text-dark">{{ $precio->categoria }}</td>
                                            <td><span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1 fs-6">${{ number_format($precio->precioEntrada, 2) }}</span></td>
                                            <td class="text-muted small">{{ $precio->descripcion ?? 'Sin descripción' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1"></i> No se han registrado tarifas o precios para este sitio.</p>
                    @endif
                </div>
            </div>

            <!--Galería de Imágenes Adicionales -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-images me-2 text-info"></i>Galería de Imágenes</h6>
                    @if($sitio->imagenes->isNotEmpty())
                        <div class="row g-3">
                            @foreach($sitio->imagenes as $img)
                                <div class="col-6 col-sm-4 col-md-3">
                                    <div class="position-relative overflow-hidden rounded-3 border shadow-sm group-hover" style="height: 110px;">
                                        <img src="{{ asset('storage/' . $img->url) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $img->titulo ?? 'Imagen del Sitio' }}">
                                        @if($img->principal)
                                            <span class="badge bg-primary position-absolute top-0 start-0 m-1 rounded-pill" style="font-size: 9px;">Principal</span>
                                        @endif
                                    </div>
                                    @if($img->titulo)
                                        <p class="small text-muted text-center mt-1 text-truncate mb-0" style="font-size: 11px;">{{ $img->titulo }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1"></i> El propietario no ha añadido fotos adicionales a la galería.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Columna Derecha -->
        <div class="col-12 col-lg-4">
            
            <!--Datos Rápidos de Contacto & Redes -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-info-circle-fill text-muted me-2"></i>Contacto e Info</h6>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                <i class="bi bi-telephone fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 11px;">TELÉFONO</small>
                                <span class="fw-semibold text-dark">{{ $sitio->perfil->telefono ?? 'No especificado' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                <i class="bi bi-envelope-at fs-5"></i>
                            </div>
                            <div class="text-truncate">
                                <small class="text-muted d-block" style="font-size: 11px;">CORREO INSTITUCIONAL</small>
                                <span class="fw-semibold text-dark text-truncate d-block">{{ $sitio->perfil->correo_institucional ?? 'No especificado' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                <i class="bi bi-globe fs-5"></i>
                            </div>
                            <div class="text-truncate">
                                <small class="text-muted d-block" style="font-size: 11px;">SITIO WEB EXTERNO</small>
                                @if($sitio->perfil && $sitio->perfil->sitio_web)
                                    <a href="{{ $sitio->perfil->sitio_web }}" target="_blank" class="text-decoration-none fw-semibold text-primary text-truncate d-block">{{ $sitio->perfil->sitio_web }}</a>
                                @else
                                    <span class="text-muted">No especificado</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($sitio->perfil)
                        <hr class="my-3 opacity-25">
                        <div class="d-flex justify-content-center gap-2">
                            @if($sitio->perfil->facebook) <a href="{{ $sitio->perfil->facebook }}" target="_blank" class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-facebook text-primary"></i></a> @endif
                            @if($sitio->perfil->instagram) <a href="{{ $sitio->perfil->instagram }}" target="_blank" class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-instagram text-danger"></i></a> @endif
                            @if($sitio->perfil->tiktok) <a href="{{ $sitio->perfil->tiktok }}" target="_blank" class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-tiktok text-dark"></i></a> @endif
                            @if($sitio->perfil->youtube) <a href="{{ $sitio->perfil->youtube }}" target="_blank" class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-youtube text-danger"></i></a> @endif
                        </div>
                    @endif
                </div>
            </div>

            <!--Categorías -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-tags me-2 text-warning"></i>Categorías</h6>
                    @if($sitio->perfil && $sitio->perfil->categorias->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sitio->perfil->categorias as $cat)
                                <span class="badge border px-3 py-2 text-dark fw-normal rounded-pill shadow-sm d-flex align-items-center" style="background-color: {{ $cat->color ?? '#f8f9fa' }}; border-color: rgba(0,0,0,0.08) !important;">
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
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-patch-check me-2 text-primary"></i>Servicios</h6>
                    @if($sitio->perfil && $sitio->perfil->servicios->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sitio->perfil->servicios as $serv)
                                <span class="badge bg-light text-dark border px-3 py-2 d-flex align-items-center rounded-pill fw-normal">
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
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-exclamation-octagon me-2 text-danger"></i>Reglas e Indicaciones</h6>
                    @if($sitio->perfil && $sitio->perfil->reglas->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sitio->perfil->reglas as $regla)
                                <span class="badge bg-light text-dark border px-3 py-2 d-flex align-items-center rounded-pill fw-normal">
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
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small"><i class="bi bi-clock me-2 text-info"></i>Horarios de Atención</h6>
                    @if($sitio->perfil && $sitio->perfil->horarios)
                        @php $horarios = json_decode($sitio->perfil->horarios, true); @endphp
                        @if(is_array($horarios))
                            <div class="d-flex flex-column gap-2 small">
                                @foreach($horarios as $dia => $horas)
                                    <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light">
                                        <span class="text-capitalize fw-bold text-dark">{{ $dia }}</span>
                                        <span class="text-muted">{{ $horas }}</span>
                                    </div>
                                @endforeach
                            </div>
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
<div class="fixed-bottom p-3" x-data="{ formulario: '' }" style="z-index: 1030;">
    <div class="container">
        <div class="bg-white bg-opacity-95 backdrop-blur border shadow-lg rounded-4 p-3 border-light">
            <div class="row align-items-center">
                <!-- Título izquierdo -->
                <div class="col-12 col-xl-4 d-none d-xl-block">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3">
                            <i class="bi bi-sliders fs-5"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Panel de Control: {{ $sitio->nombre }}</h6>
                            <small class="text-muted">Estado actual: <span class="fw-bold text-primary text-uppercase">{{ $sitio->estado }}</span></small>
                        </div>
                    </div>
                </div>
                
                <!-- Grupo completo de Botones Modificadores -->
                <div class="col-12 col-xl-8">
                    <div class="d-flex flex-wrap gap-2 justify-content-xl-end">
                        
                        <!-- Botón Reestablecer a Pendiente (Solo visible si no está pendiente) -->
                        @if($sitio->estado != 'pendiente')
                            <form action="{{ route('su.sitios.pendiente', $sitio->id) }}" method="POST" class="m-0 flex-grow-1 flex-md-grow-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-warning text-dark rounded-pill px-3 py-2 fw-semibold w-100">
                                    <i class="bi bi-hourglass-split me-1"></i> Poner Pendiente
                                </button>
                            </form>
                        @endif

                        <!-- Botón Suspender -->
                        @if($sitio->estado != 'suspendido')
                            <button class="btn btn-dark rounded-pill px-3 py-2 fw-semibold flex-grow-1 flex-md-grow-0" 
                                    type="button" 
                                    @click="formulario = (formulario === 'suspender' ? '' : 'suspender')">
                                <i class="bi bi-dash-circle me-1"></i> Suspender
                            </button>
                        @endif

                        <!-- Botón Rechazar -->
                        <button class="btn btn-outline-danger rounded-pill px-3 py-2 fw-semibold flex-grow-1 flex-md-grow-0" 
                                type="button" 
                                @click="formulario = (formulario === 'rechazar' ? '' : 'rechazar')">
                            <i class="bi bi-x-lg me-1"></i> Rechazar
                        </button>
                        
                        <!-- Botón Aprobar -->
                        @if($sitio->estado != 'aprobado' && $sitio->estado != 'publicado')
                            <form action="{{ route('su.sitios.aprobar', $sitio->id) }}" method="POST" class="m-0 flex-grow-1 flex-md-grow-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-sm w-100">
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
            <div class="mt-3 border-top pt-3" x-show="formulario === 'rechazar'" x-cloak style="display: none;" x-transition>
                <form action="{{ route('su.sitios.rechazar', $sitio->id) }}" method="POST" class="mb-0">
                    @csrf
                    @method('PATCH')
                    <div class="mb-2">
                        <label for="motivo_rechazo" class="form-label fw-bold text-danger small text-uppercase mb-1">Razón del Rechazo</label>
                        <textarea class="form-control rounded-3" id="motivo_rechazo" name="motivo" rows="2" placeholder="Ej. Las fotos tienen baja calidad o información inconsistente..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 fw-bold" @click="formulario = ''">Cancelar</button>
                        <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm">Enviar Rechazo</button>
                    </div>
                </form>
            </div>

            <!-- Formulario: Suspender Sitio -->
            <div class="mt-3 border-top pt-3" x-show="formulario === 'suspender'" x-cloak style="display: none;" x-transition>
                <form action="{{ route('su.sitios.suspender', $sitio->id) }}" method="POST" class="mb-0">
                    @csrf
                    @method('PATCH')
                    <div class="mb-2">
                        <label for="motivo_suspension" class="form-label fw-bold text-dark small text-uppercase mb-1">Motivo de la Suspensión</label>
                        <textarea class="form-control rounded-3" id="motivo_suspension" name="motivo" rows="2" placeholder="Ej. Incumplimiento de términos, reportes de usuarios o inactividad comercial..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 fw-bold" @click="formulario = ''">Cancelar</button>
                        <button type="submit" class="btn btn-dark btn-sm rounded-pill px-3 fw-bold shadow-sm">Confirmar Suspensión</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection