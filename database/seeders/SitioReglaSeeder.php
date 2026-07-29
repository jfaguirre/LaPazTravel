<?php

namespace Database\Seeders;

use App\Models\SitioPerfil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SitioReglaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sitio = SitioPerfil::find(1);

            $sitio->reglas()->sync([
                1, // Alimentos            
            ]);

        $sitio = SitioPerfil::find(2);

            $sitio->reglas()->sync([
                1, // Alimentos            
            ]);
    }
}
