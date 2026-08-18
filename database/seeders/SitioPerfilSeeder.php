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
            'telefono' => '23342121',
            'correo_institucional' => 'mangovillage@gmail.com',
            'direccion' => 'Km 62 1/2 Autopista a Zacatecoluca. 400 Mts al sur de Gasolinera UNO',
            'horarios' => '{"Lunes":"08:00 - 17:00","Martes":"08:00 - 17:00","Miércoles":"08:00 - 17:00","Jueves":"08:00 - 17:00","Viernes":"08:00 - 17:00","Sábado":"08:00 - 17:00","Domingo":"08:00 - 17:00"}',
            'facebook' => 'https://www.facebook.com',
            'instagram' => 'https://www.instagram.com',
            'tiktok' => 'https://www.tiktok.com',
            'youtube' => 'https://www.youtube.com',            
            'foto_portada' => 'uploads/portada/1786975400_6a8314a8b4957.jpg',
            'latitud' => '13.4903809',
            'longitud' => '-88.8794817',
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
