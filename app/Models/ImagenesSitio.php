<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenesSitio extends Model
{
    protected $table = 'imagenes_sitios';

    protected $fillable = [
        'url',
        'titulo',
        'principal',
        'orden',
        'sitio_id'
    ];

    // RELACIONES
    // _______________________________________________________________________

    public function sitio(): BelongsTo
    {
        return $this->belongsTo(Sitio::class, 'sitio_id');
    }
}
