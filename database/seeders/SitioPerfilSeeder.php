<?php

namespace Database\Seeders;

use App\Models\SitioPerfil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SitioPerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SitioPerfil::create([
            'identificador' => 'BHUTGCF3ML',
            'id_sitio' => 1,
            'id_departamento' => 6,
            'id_distrito' => 133,
            'id_municipio' => 19
        ]);

        SitioPerfil::create([
            'identificador' => 'LLGUGCF3ML',
            'id_sitio' => 2,
            'id_departamento' => 6,
            'id_distrito' => 133,
            'id_municipio' => 19
        ]);
    }
}
