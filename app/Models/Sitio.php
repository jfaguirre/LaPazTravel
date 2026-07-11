<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sitio extends Model
{
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion_corta',
        'id_user'
    ];


    // RELACIONES
    // _______________________________________________________________________

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}

