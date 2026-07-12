<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distrito extends Model
{
      protected $fillable = [
        'distrito',
        'id_departamento'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'id_distrito');
    }

    public function sitioPerfiles(): HasMany
    {
        return $this->hasMany(SitioPerfil::class, 'distrito_id');
    }
}
