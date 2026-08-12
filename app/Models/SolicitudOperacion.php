<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudOperacion extends Model
{

    protected $table = 'solicitud_operaciones';

    protected $fillable = [
        'id_solicitud',
        'modelo',
        'id_registro',
        'operacion',
        'descripcion',
        'cambios',
    ];

    protected $casts = [
        'cambios' => 'array',
    ];

    

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud');
    }
}
