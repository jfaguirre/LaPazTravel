<?php

namespace Database\Seeders;

use App\Models\SitioPerfil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SitioCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

     $sitio = SitioPerfil::find(1);

        $sitio->categorias()->sync([
            1, // Campamento            
        ]);            


    $sitio = SitioPerfil::find(2);

        $sitio->categorias()->sync([
            1, // Campamento            
        ]); 

    }
}
