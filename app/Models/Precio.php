<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Precio extends Model
{
    protected $fillable = [
        'categoria',
        'precioEntrada',
        'descripcion',
        'sitioPerfil_id'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function sitioPerfil(): BelongsTo
    {
        return $this->belongsTo(SitioPerfil::class, 'id_sitioPerfil');
    }
}
