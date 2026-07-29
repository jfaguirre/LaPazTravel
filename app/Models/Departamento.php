<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    protected $fillable = [
        'departamento',
        'estado',
        'id_pais'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function distritos(): HasMany
    {
        return $this->hasMany(Distrito::class, 'id_departamento');
    }

    public function sitioPerfiles(): HasMany
    {
        return $this->hasMany(SitioPerfil::class, 'id_departamento');
    }
}
