<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servicio extends Model
{
    protected $fillable = [
        'servicio',
        'icono',
        'estado'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function sitioPerfiles(): BelongsToMany
    {
        return $this->belongsToMany(SitioPerfil::class, 'sitio_servicio', 'id_servicio', 'id_sitioPerfil');
    }
}
