<?php

namespace Database\Seeders;

use App\Models\SitioPerfil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SitioServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sitio = SitioPerfil::find(1);

            $sitio->servicios()->sync([
                1, // Parqueo            
            ]);

        $sitio = SitioPerfil::find(2);

            $sitio->servicios()->sync([
                1, // Parqueo            
            ]);
    }
}
