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
                        <a href="{{ route('sitio.edit') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                    @else
                        <span class="badge badge-pending">Pendiente</span>
                        <a href="{{ route('sitio.create') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
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
                            <a href="{{ route('perfil.categoria.agregar') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('perfil.categoria.agregar') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
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
                            <a href="{{ route('perfil.regla.agregar') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('perfil.regla.agregar') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
                        @endif
                    @else
                        <span class="badge badge-pending" style="opacity: 0.6;">Pendiente</span>
                        <span style="color: var(--neutro-400); cursor: not-allowed; display: inline-flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 600; user-select: none;">
                            Bloqueado <i class="bi bi-lock-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Paso 4: Servicios -->
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
                            <a href="{{ route('perfil.servicio.agregar') }}" class="step-link">Editar <i class="bi bi-pencil-square"></i></a>
                        @else
                            <span class="badge badge-pending">Pendiente</span>
                            <a href="{{ route('perfil.servicio.agregar') }}" class="step-link">Completar <i class="bi bi-arrow-right-short"></i></a>
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
