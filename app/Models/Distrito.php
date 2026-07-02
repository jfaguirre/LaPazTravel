<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
      protected $fillable = [
        'distrito',
        'id_departamento'
    ];
}
