<?php

use Livewire\Component;
use App\Models\Sitio;
use Livewire\Attributes\On;

new class extends Component
{
    public ?Sitio $sitio = null;
    public bool $hasSitio = false;
    public bool $hasUbicacion = false;
    public bool $hasCategoria = false;
    public bool $hasRegla = false;
    public bool $hasServicio = false;
    public bool $hasHorario = false;
    public bool $hasPrecio = false;
    public bool $hasGps = false;
    public bool $hasPortada = false;
    public bool $hasFotoPerfil = false;

    public function mount()
    {
        $user = Auth::user();
        $sitioId = session('id_sitio');
        if ($sitioId) {
            $this->sitio = Sitio::find($sitioId);
        } else {
            $this->sitio = Sitio::where('id_user', $user->id)->first();
        }

        $this->hasSitio = $this->sitio !== null;
        $this->hasUbicacion = (bool) ($this->sitio?->perfil?->id_departamento !== null &&
                                      $this->sitio?->perfil?->id_municipio !== null &&
                                      $this->sitio?->perfil?->id_distrito !== null);
        $this->hasCategoria = (bool) $this->sitio?->perfil?->categorias()->exists();
        $this->hasRegla = (bool) $this->sitio?->perfil?->reglas()->exists();
        $this->hasServicio = (bool) $this->sitio?->perfil?->servicios()->exists();
        $this->hasHorario = (bool) (!empty($this->sitio?->perfil?->horarios));
        $this->hasPrecio = (bool) $this->sitio?->perfil?->precios()->exists();
        $this->hasGps = (bool) ($this->sitio?->perfil?->latitud !== null && $this->sitio?->perfil?->longitud !== null);
        $this->hasPortada = (bool) (!empty($this->sitio?->perfil?->foto_portada));
        $this->hasFotoPerfil = (bool) (!empty($this->sitio?->perfil?->foto_perfil));
    }






        #[On('sitio-estado-cambiado')]
        public function actualizarEstado()
        {
            $this->sitio->refresh();
        }
};
?>

<div>
     <!-- Lista de Formularios (Pasos) -->
    <div class="steps-list">
        @if($this->sitio == null || $this->sitio->estado == 'BORRADOR')
            <!-- Paso 1: Sitio -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">1</span>
                    </div>
                    <div class="step-details">
                        <h4>Sitio Turístico</h4>
                        <p>Datos generales, ubicación y contacto.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        <span class="badge badge-completed">Completado</span>
                        <a href="{{ route('informacion.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                    @else
                        <span class="badge badge-pending">Pendiente</span>
                        <a href="{{ route('informacion.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                    @endif
                </div>
            </div>


            <!-- Paso 3: Reglas -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">2</span>
                    </div>
                    <div class="step-details">
                        <h4>Ubicación</h4>
                        <p>Define tu ubicación geográfica.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasUbicacion)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('perfil.ubicacion.agregar') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('perfil.ubicacion.agregar') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 2: Categoría -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">3</span>
                    </div>
                    <div class="step-details">
                        <h4>Categoría</h4>
                        <p>Clasificación y tipo de experiencia turística.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasCategoria)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('categoria.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('categoria.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif

                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 3: Reglas -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">4</span>
                    </div>
                    <div class="step-details">
                        <h4>Reglas</h4>
                        <p>Normativas de seguridad y pautas de visita.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasRegla)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('regla.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('regla.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 5: Servicios -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">5</span>
                    </div>
                    <div class="step-details">
                        <h4>Servicios</h4>
                        <p>Facilidades y comodidades disponibles.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasServicio)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('servicio.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('servicio.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif

                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 6: Horarios -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">6</span>
                    </div>
                    <div class="step-details">
                        <h4>Horarios</h4>
                        <p>Horarios de atención y apertura.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasHorario)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('horario.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('horario.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 7: Precios -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">7</span>
                    </div>
                    <div class="step-details">
                        <h4>Precios y Tarifas</h4>
                        <p>Costos de entrada y boletaje.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasPrecio)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('precio.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('precio.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 8: GPS / Mapa -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">8</span>
                    </div>
                    <div class="step-details">
                        <h4>Mapa GPS</h4>
                        <p>Ubicación y coordenadas en el mapa.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasGps)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('gps.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('gps.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 9: Portada -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">9</span>
                    </div>
                    <div class="step-details">
                        <h4>Imagen de Portada</h4>
                        <p>Imagen panorámica de cabecera.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasPortada)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('portada.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('portada.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 10: Foto de Perfil -->
            <div class="step-item">
                <div class="step-info">
                    <div class="step-icon">
                        <span style="font-weight: 700;">10</span>
                    </div>
                    <div class="step-details">
                        <h4>Foto de Perfil / Logo</h4>
                        <p>Logo o emblema distintivo del sitio.</p>
                    </div>
                </div>
                <div class="step-actions">
                    @if($hasSitio)
                        @if($hasFotoPerfil)
                            <span class="badge badge-completed">Completado</span>
                            <a href="{{ route('fotoperfil.create') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('fotoperfil.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>





        @endif

        @if(isset($this->sitio))
            @if($this->sitio->estado == 'PENDIENTE')
                <img src="{{ asset('assets/images/solicitud_enviada.svg') }}" alt="Ilustración de registro" style="max-width: 20%; height: auto; opacity: 0.95; transition: transform 0.3s ease; margin: 40px auto" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <h5>Solicitud enviada</h5>
                <p>Puedes cancelar la solicitud en cualquier momento mientras este pendiente.</p>
            @endif
        @endif
    </div>
</div>
