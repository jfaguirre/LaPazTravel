<?php

use App\Models\Sitio;
use Livewire\Component;

new class extends Component
{
    public ?Sitio $sitio = null;
    public bool $hasSitio = false;
    public bool $hasCategoria = false;
    public bool $hasRegla = false;
    public bool $hasServicio = false;

    public function mount()
    {
        $user = Auth::user();
        $this->sitio = Sitio::where('id_user', $user->id)->first();

        $this->hasSitio = $this->sitio !== null;
        $this->hasCategoria = (bool) $this->sitio?->perfil?->categorias()->exists();
        $this->hasRegla = (bool) $this->sitio?->perfil?->reglas()->exists();
        $this->hasServicio = (bool) $this->sitio?->perfil?->servicios()->exists();
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

        if (
            !$hasCategoria ||
            !$hasRegla ||
            !$hasServicio
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
        @if ($hasSitio && $hasCategoria && $hasRegla && $hasServicio)
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

