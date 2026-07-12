<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Regla extends Model
{
    protected $fillable = [
        'regla',
        'icono',
        'estado'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function sitioPerfiles(): BelongsToMany
    {
        return $this->belongsToMany(SitioPerfil::class, 'sitio_regla', 'regla_id', 'sitioPerfil_id');
    }
}
