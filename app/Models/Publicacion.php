<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publicacion extends Model
{
    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'contenido',
        'imagen_portada',
        'estado',
        'sitio_id',
        'user_id'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function sitio(): BelongsTo
    {
        return $this->belongsTo(Sitio::class, 'id_sitio');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
