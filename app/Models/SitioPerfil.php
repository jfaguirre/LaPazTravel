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
        return $this->belongsTo(Sitio::class, 'sitio_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function precios(): HasMany
    {
        return $this->hasMany(Precio::class, 'sitioPerfil_id');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'sitio_categoria', 'sitioPerfil_id', 'categoria_id');
    }

    public function reglas(): BelongsToMany
    {
        return $this->belongsToMany(Regla::class, 'sitio_regla', 'sitioPerfil_id', 'regla_id');
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'sitio_servicio', 'sitioPerfil_id', 'servicio_id');
    }
}
