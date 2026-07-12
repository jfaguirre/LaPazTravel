<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
      protected $fillable = [
        'municipio',
        'id_distrito'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'id_distrito');
    }

    public function sitioPerfiles(): HasMany
    {
        return $this->hasMany(SitioPerfil::class, 'id_municipio');
    }
}
