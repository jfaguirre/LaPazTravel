<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'id_sitio',
        'id_user',
        'estado',
        'comentario_usuario',
        'comentario_admin',
        'revisado_por',
        'fecha_revision',
    ];
    
    public function sitio(): BelongsTo
    {
        return $this->belongsTo(Sitio::class, 'id_sitio');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    public function operaciones(): HasMany
    {
        return $this->hasMany(SolicitudOperacion::class, 'id_solicitud');
    }
}
