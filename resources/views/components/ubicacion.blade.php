<?php

use Livewire\Component;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Distrito;
use App\Models\SitioPerfil;

new class extends Component
{
    public $departamentos = [];
    public $municipios = [];
    public $distritos = [];

    public $departamentoSeleccionado = null;
    public $municipioSeleccionado = null;
    public $distritoSeleccionado = null;

    public function mount()
    {
        $this->departamentos = Departamento::Where('estado', 'ACTIVO')->get();

        $perfil = SitioPerfil::where('id_sitio', session('id_sitio'))->first();
        if ($perfil) {
            $this->departamentoSeleccionado = $perfil->id_departamento;
            
            if ($this->departamentoSeleccionado) {
                $this->municipios = Municipio::where('id_departamento', $this->departamentoSeleccionado)
                    ->orderBy('municipio')
                    ->get();
                $this->municipioSeleccionado = $perfil->id_municipio;
            }
            
            if ($this->municipioSeleccionado) {
                $this->distritos = Distrito::where('id_municipio', $this->municipioSeleccionado)
                    ->orderBy('distrito')
                    ->get();
                $this->distritoSeleccionado = $perfil->id_distrito;
            }
        }
    }

    public function updatedDepartamentoSeleccionado($id)
    {
        $this->municipioSeleccionado = null;
        $this->distritoSeleccionado = null;
        $this->distritos = [];

        if ($id) {
            $this->municipios = Municipio::where('id_departamento', $id)
                ->orderBy('municipio')
                ->get();
        }
    }

    public function updatedMunicipioSeleccionado($id)
    {
        $this->distritoSeleccionado = null;

        if ($id) {
            $this->distritos = Distrito::where('id_municipio', $id)
                ->orderBy('distrito')
                ->get();
        }
    }
};

?>

<div>
    <div class="ubicacion-grid">
        <div class="seleccion-ubicacion">
            <span>Departamento:</span>
            <select name="departamento" id="departamento" wire:model.live="departamentoSeleccionado" required>
                <option value="">Selecciona un departamento</option>
                @foreach($this->departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->departamento }}</option>
                @endforeach
            </select>
        </div>

        <div class="seleccion-ubicacion">
            <span>Municipio:</span>
            <select name="municipio" id="municipio" wire:model.live="municipioSeleccionado" required>
                    <option value="">Selecciona un municipio</option>
                @foreach($this->municipios as $municipio)
                    <option value="{{ $municipio->id }}">{{ $municipio->municipio }}</option>
                @endforeach
            </select>
        </div>

        <div class="seleccion-ubicacion">
            <span>Distrito:</span>
            <select name="distrito" id="distrito" wire:model="distritoSeleccionado" required>
                <option value="">Selecciona un distrito</option>
                @foreach($this->distritos as $distrito)
                    <option value="{{ $distrito->id }}">{{ $distrito->distrito }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="btn-container">
        <a href="{{ route('perfil.create') }}" class="btn-cancel">Cancelar</a>
        <button type="submit" class="btn-submit">
            Guardar Cambios <i class="bi bi-check-lg" style="font-size: 16px;"></i>
        </button>
    </div>

</div>
