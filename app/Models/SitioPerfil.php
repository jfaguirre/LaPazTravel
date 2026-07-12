<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SitioPerfil extends Model
{
    protected $table = 'sitio_perfil';

    protected $fillable = [
        'identificador',
        'telefono',
        'correo_institucional',
        'direccion',
        'horarios',
        'facebook',
        'instagram',
        'tiktok',
        'youtube',
        'sitio_web',
        'foto_perfil',
        'foto_portada',
        'latitud',
        'longitud',
        'sitio_id',
        'departamento_id',
        'distrito_id',
        'municipio_id'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function sitio(): BelongsTo
    {
        return $this->belongsTo(Sitio::class, 'id_sitio');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'id_distrito');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }

    public function precios(): HasMany
    {
        return $this->hasMany(Precio::class, 'id_sitioPerfil');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'sitio_categoria', 'id_sitioPerfil', 'id_categoria');
    }

    public function reglas(): BelongsToMany
    {
        return $this->belongsToMany(Regla::class, 'sitio_regla', 'id_sitioPerfil', 'id_regla');
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'sitio_servicio', 'id_sitioPerfil', 'id_servicio');
    }
}
