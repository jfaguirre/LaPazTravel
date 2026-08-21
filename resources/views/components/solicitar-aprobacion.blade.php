<?php

use App\Models\Sitio;
use Livewire\Component;

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

    public function enviarSolicitud()
    {
        $sitio = $this->sitio;

        if (!$sitio) {
            return;
        }

        $perfil = $sitio->perfil;

        $hasCategoria = (bool) $perfil?->categorias()->exists();
        $hasRegla = (bool) $perfil?->reglas()->exists();
        $hasServicio = (bool) $perfil?->servicios()->exists();
        $hasUbicacion = (bool) ($perfil?->id_departamento !== null &&
                                $perfil?->id_municipio !== null &&
                                $perfil?->id_distrito !== null);
        $hasHorario = (bool) (!empty($perfil?->horarios));
        $hasPrecio = (bool) $perfil?->precios()->exists();
        $hasGps = (bool) ($perfil?->latitud !== null && $perfil?->longitud !== null);
        $hasPortada = (bool) (!empty($perfil?->foto_portada));
        $hasFotoPerfil = (bool) (!empty($perfil?->foto_perfil));

        if (
            !$hasCategoria ||
            !$hasRegla ||
            !$hasServicio ||
            !$hasUbicacion ||
            !$hasHorario ||
            !$hasPrecio ||
            !$hasGps ||
            !$hasPortada ||
            !$hasFotoPerfil
        ) {
            return;
        }

        if($sitio->estado == 'BORRADOR')
        {
            $sitio->update([
                'estado' => 'PENDIENTE',
            ]);
        } else {
            if($sitio->estado == 'PENDIENTE')
            {
                $sitio->update([
                    'estado' => 'BORRADOR',
                ]);
            }
        }

         $this->dispatch('sitio-estado-cambiado');
    }
};


?>

<div>
    <div class="solicitud">
        @if ($hasSitio && $hasCategoria && $hasRegla && $hasServicio && $hasUbicacion && $hasHorario && $hasPrecio && $hasGps && $hasPortada && $hasFotoPerfil)
            @if ($sitio->estado == 'BORRADOR')
                <button type="button" class="btn btn-primary" wire:click="enviarSolicitud">
                    Enviar solicitud
                    <i class="bi bi-check-circle"></i>
                </button>
            @else
                @if ($sitio->estado == 'PENDIENTE')
                    <button type="button" class="btn btn-danger" wire:click="enviarSolicitud">
                        Cancelar solicitud
                        <i class="bi bi-x-circle"></i>
                    </button>
                @endif
            @endif
        @endif
    </div>
</div>

