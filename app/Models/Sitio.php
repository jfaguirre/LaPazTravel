<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->belongsTo(User::class, 'id_user');
    }

    // Traer el perfil asociado al sitio.
    public function perfil(): HasOne
    {
        return $this->hasOne(SitioPerfil::class, 'id_sitio');
    }

    // Traer las imágenes del sitio.
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenesSitio::class, 'id_sitio');
    }

    // Traer las publicaciones del sitio.
    public function publicaciones(): HasMany
    {
        return $this->hasMany(Publicacion::class, 'id_sitio');
    }


}

