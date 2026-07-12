<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'icono',
        'estado',
        'color'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function sitioPerfiles(): BelongsToMany
    {
        return $this->belongsToMany(SitioPerfil::class, 'sitio_categoria', 'categoria_id', 'sitioPerfil_id');
    }
}
