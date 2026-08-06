<?php
namespace App\Contracts;

use App\Models\Sitio;

interface HasSitio
{
    public function obtenerSitio(): Sitio;
}