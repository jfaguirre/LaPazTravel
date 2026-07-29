<?php

namespace Database\Seeders;

use App\Models\Distrito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistritosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Departamento de Ahuachapán
        Distrito::create(['distrito' => 'Atiquizaya', 'id_municipio' => 1]);
        Distrito::create(['distrito' => 'El Refugio', 'id_municipio' => 1]);
        Distrito::create(['distrito' => 'San Lorenzo', 'id_municipio' => 1]);
        Distrito::create(['distrito' => 'Turín', 'id_municipio' => 1]);

        Distrito::create(['distrito' => 'Ahuachapán', 'id_municipio' => 2]);
        Distrito::create(['distrito' => 'Apaneca', 'id_municipio' => 2]);
        Distrito::create(['distrito' => 'Concepción de Ataco', 'id_municipio' => 2]);
        Distrito::create(['distrito' => 'Tacuba', 'id_municipio' => 2]);

        Distrito::create(['distrito' => 'Guaymango', 'id_municipio' => 3]);
        Distrito::create(['distrito' => 'Jujutla', 'id_municipio' => 3]);
        Distrito::create(['distrito' => 'San Francisco Menendez', 'id_municipio' => 3]);
        Distrito::create(['distrito' => 'San Pedro Puxtla', 'id_municipio' => 3]);

        // Departamento de San Salvador
        Distrito::create(['distrito' => 'Aguilares', 'id_municipio' => 27]);
        Distrito::create(['distrito' => 'El Paisnal', 'id_municipio' => 27]);
        Distrito::create(['distrito' => 'Guazapa', 'id_municipio' => 27]);

        Distrito::create(['distrito' => 'Apopa', 'id_municipio' => 28]);
        Distrito::create(['distrito' => 'Nejapa', 'id_municipio' => 28]);

        Distrito::create(['distrito' => 'Ilopango', 'id_municipio' => 29]);
        Distrito::create(['distrito' => 'San Martín', 'id_municipio' => 29]);
        Distrito::create(['distrito' => 'Soyapango', 'id_municipio' => 29]);
        Distrito::create(['distrito' => 'Tonacatepeque', 'id_municipio' => 29]);

        Distrito::create(['distrito' => 'Ayutuxtepeque', 'id_municipio' => 30]);
        Distrito::create(['distrito' => 'Mejicanos', 'id_municipio' => 30]);
        Distrito::create(['distrito' => 'San Salvador', 'id_municipio' => 30]);
        Distrito::create(['distrito' => 'Cuscatancingo', 'id_municipio' => 30]);
        Distrito::create(['distrito' => 'Ciudad Delgado', 'id_municipio' => 30]);

        Distrito::create(['distrito' => 'Panchimalco', 'id_municipio' => 31]);
        Distrito::create(['distrito' => 'Rosario de Mora', 'id_municipio' => 31]);
        Distrito::create(['distrito' => 'San Marcos', 'id_municipio' => 31]);
        Distrito::create(['distrito' => 'Santo Tomás', 'id_municipio' => 31]);
        Distrito::create(['distrito' => 'Santiago Texacuangos', 'id_municipio' => 31]);

        // Departamento de La Libertad
        Distrito::create(['distrito' => 'Quezaltepeque', 'id_municipio' => 11]);
        Distrito::create(['distrito' => 'San Matías', 'id_municipio' => 11]);
        Distrito::create(['distrito' => 'San Pablo Tacachico', 'id_municipio' => 11]);

        Distrito::create(['distrito' => 'San Juan Opico', 'id_municipio' => 12]);
        Distrito::create(['distrito' => 'Ciudad Arce', 'id_municipio' => 12]);

        Distrito::create(['distrito' => 'Colón', 'id_municipio' => 13]);
        Distrito::create(['distrito' => 'Jayaque', 'id_municipio' => 13]);
        Distrito::create(['distrito' => 'Sacacoyo', 'id_municipio' => 13]);
        Distrito::create(['distrito' => 'Tepecoyo', 'id_municipio' => 13]);
        Distrito::create(['distrito' => 'Talnique', 'id_municipio' => 13]);

        Distrito::create(['distrito' => 'Antiguo Cuscatlán', 'id_municipio' => 14]);
        Distrito::create(['distrito' => 'Huizucar', 'id_municipio' => 14]);
        Distrito::create(['distrito' => 'Nuevo Cuscatlán', 'id_municipio' => 14]);
        Distrito::create(['distrito' => 'San José Villanueva', 'id_municipio' => 14]);
        Distrito::create(['distrito' => 'Zaragoza', 'id_municipio' => 14]);

        Distrito::create(['distrito' => 'Chiltuipán', 'id_municipio' => 15]);
        Distrito::create(['distrito' => 'Jicalapa', 'id_municipio' => 15]);
        Distrito::create(['distrito' => 'La Libertad', 'id_municipio' => 15]);
        Distrito::create(['distrito' => 'Tamanique', 'id_municipio' => 15]);
        Distrito::create(['distrito' => 'Teotepeque', 'id_municipio' => 15]);

        Distrito::create(['distrito' => 'Comasagua', 'id_municipio' => 16]);
        Distrito::create(['distrito' => 'Santa Tecla', 'id_municipio' => 16]);

        // Departamento de Chalatenango
        Distrito::create(['distrito' => 'La Palma', 'id_municipio' => 6]);
        Distrito::create(['distrito' => 'Citalá', 'id_municipio' => 6]);
        Distrito::create(['distrito' => 'San Ignacio', 'id_municipio' => 6]);

        Distrito::create(['distrito' => 'Nueva Concepción', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'Tejutla', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'La Reina', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'Agua Caliente', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'Dulce Nombre de María', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'El Paraíso', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'San Francisco Morazán', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'San Rafael', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'Santa Rita', 'id_municipio' => 7]);
        Distrito::create(['distrito' => 'San Fernando', 'id_municipio' => 7]);

        Distrito::create(['distrito' => 'Chalatenango', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Arcatao', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Azacualpa', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Comalapa', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Concepción Quezaltepeque', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'El Carrizal', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'La Laguna', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Las Vueltas', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Nombre de Jesús', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Nueva Trinidad', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Ojos de Agua', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'Potonico', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'San Antonio de La Cruz', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'San Antonio Los Ranchos', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'San Francisco Lempa', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'San Isidro Labrador', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'San José Cancasque', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'San Miguel de Mercedes', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'San José Las Flores', 'id_municipio' => 8]);
        Distrito::create(['distrito' => 'San Luis del Carmen', 'id_municipio' => 8]);

        // Departamento de Cuscatlán
        Distrito::create(['distrito' => 'Suchitoto', 'id_municipio' => 9]);
        Distrito::create(['distrito' => 'San José Guayabal', 'id_municipio' => 9]);
        Distrito::create(['distrito' => 'Oratorio de Concepción', 'id_municipio' => 9]);
        Distrito::create(['distrito' => 'San Bartolomé Perulapán', 'id_municipio' => 9]);
        Distrito::create(['distrito' => 'San Pedro Perulapán', 'id_municipio' => 9]);

        Distrito::create(['distrito' => 'Cojutepeque', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'San Rafael Cedros', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'Candelaria', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'Monte San Juan', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'El Carmen', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'San Cristóbal', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'Santa Cruz Michapa', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'San Ramón', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'El Rosario', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'Santa Cruz Analquito', 'id_municipio' => 10]);
        Distrito::create(['distrito' => 'Tenancingo', 'id_municipio' => 10]);

        // Departamento de Cabañas
        Distrito::create(['distrito' => 'Sensuntepeque', 'id_municipio' => 4]);
        Distrito::create(['distrito' => 'Victoria', 'id_municipio' => 4]);
        Distrito::create(['distrito' => 'Dolores', 'id_municipio' => 4]);
        Distrito::create(['distrito' => 'Guacotecti', 'id_municipio' => 4]);
        Distrito::create(['distrito' => 'San Isidro', 'id_municipio' => 4]);

        Distrito::create(['distrito' => 'Ilobasco', 'id_municipio' => 5]);
        Distrito::create(['distrito' => 'Tejutepeque', 'id_municipio' => 5]);
        Distrito::create(['distrito' => 'Jutiapa', 'id_municipio' => 5]);
        Distrito::create(['distrito' => 'Cinquera', 'id_municipio' => 5]);

        // Departamento de La Paz
        Distrito::create(['distrito' => 'Cuyultitán', 'estado' => 'ACTIVO', 'id_municipio' => 17]);
        Distrito::create(['distrito' => 'Olocuilta', 'estado' => 'ACTIVO', 'id_municipio' => 17]);
        Distrito::create(['distrito' => 'San Juan Talpa', 'estado' => 'ACTIVO', 'id_municipio' => 17]);
        Distrito::create(['distrito' => 'San Luis Talpa', 'estado' => 'ACTIVO', 'id_municipio' => 17]);
        Distrito::create(['distrito' => 'San Pedro Masahuat', 'estado' => 'ACTIVO', 'id_municipio' => 17]);
        Distrito::create(['distrito' => 'Tapalhuaca', 'estado' => 'ACTIVO', 'id_municipio' => 17]);
        Distrito::create(['distrito' => 'San Francisco Chinameca', 'estado' => 'ACTIVO', 'id_municipio' => 17]);

        Distrito::create(['distrito' => 'El Rosario', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'Jerusalén', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'Mercedes La Ceiba', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'Paraíso de Osorio', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'San Antonio Masahuat', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'San Emigdio', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'San Juan Tepezontes', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'San Luis La Herradura', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'San Miguel Tepezontes', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'San Pedro Nonualco', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'Santa María Ostuma', 'estado' => 'ACTIVO', 'id_municipio' => 18]);
        Distrito::create(['distrito' => 'Santiago Nonualco', 'estado' => 'ACTIVO', 'id_municipio' => 18]);

        Distrito::create(['distrito' => 'San Juan Nonualco', 'estado' => 'ACTIVO', 'id_municipio' => 19]);
        Distrito::create(['distrito' => 'San Rafael Obrajuelo', 'estado' => 'ACTIVO', 'id_municipio' => 19]);
        Distrito::create(['distrito' => 'Zacatecoluca', 'estado' => 'ACTIVO', 'id_municipio' => 19]);

        // Departamento de La Unión
        Distrito::create(['distrito' => 'Anamorós', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'Bolivar', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'Concepción de Oriente', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'El Sauce', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'Lislique', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'Nueva Esparta', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'Pasaquina', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'Polorós', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'San José La Fuente', 'id_municipio' => 20]);
        Distrito::create(['distrito' => 'Santa Rosa de Lima', 'id_municipio' => 20]);

        Distrito::create(['distrito' => 'Conchagua', 'id_municipio' => 21]);
        Distrito::create(['distrito' => 'El Carmen', 'id_municipio' => 21]);
        Distrito::create(['distrito' => 'Intipucá', 'id_municipio' => 21]);
        Distrito::create(['distrito' => 'La Unión', 'id_municipio' => 21]);
        Distrito::create(['distrito' => 'Meanguera del Golfo', 'id_municipio' => 21]);
        Distrito::create(['distrito' => 'San Alejo', 'id_municipio' => 21]);
        Distrito::create(['distrito' => 'Yayantique', 'id_municipio' => 21]);
        Distrito::create(['distrito' => 'Yucuaiquín', 'id_municipio' => 21]);

        // Departamento de Usulután
        Distrito::create(['distrito' => 'Santiago de María', 'id_municipio' => 42]);
        Distrito::create(['distrito' => 'Alegría', 'id_municipio' => 42]);
        Distrito::create(['distrito' => 'Berlín', 'id_municipio' => 42]);
        Distrito::create(['distrito' => 'Mercedes Umana', 'id_municipio' => 42]);
        Distrito::create(['distrito' => 'Jucuapa', 'id_municipio' => 42]);
        Distrito::create(['distrito' => 'El Triunfo', 'id_municipio' => 42]);
        Distrito::create(['distrito' => 'Estanzuelas', 'id_municipio' => 42]);
        Distrito::create(['distrito' => 'San Buenaventura', 'id_municipio' => 42]);
        Distrito::create(['distrito' => 'Nueva Granada', 'id_municipio' => 42]);

        Distrito::create(['distrito' => 'Usulután', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'Jucuarán', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'San Dionisio', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'Concepción Batres', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'Santa María', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'Ozatlán', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'Tecapán', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'Santa Elena', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'California', 'id_municipio' => 43]);
        Distrito::create(['distrito' => 'Ereguayquín', 'id_municipio' => 43]);

        Distrito::create(['distrito' => 'Jiquilisco', 'id_municipio' => 44]);
        Distrito::create(['distrito' => 'Puerto El Triunfo', 'id_municipio' => 44]);
        Distrito::create(['distrito' => 'San Agustín', 'id_municipio' => 44]);
        Distrito::create(['distrito' => 'San Francisco Javier', 'id_municipio' => 44]);

        // Departamento de Sonsonate
        Distrito::create(['distrito' => 'Juayúa', 'id_municipio' => 38]);
        Distrito::create(['distrito' => 'Nahuizalco', 'id_municipio' => 38]);
        Distrito::create(['distrito' => 'Salcoatitán', 'id_municipio' => 38]);
        Distrito::create(['distrito' => 'Santa Catarina Masahuat', 'id_municipio' => 38]);

        Distrito::create(['distrito' => 'Sonsonate', 'id_municipio' => 39]);
        Distrito::create(['distrito' => 'Sonzacate', 'id_municipio' => 39]);
        Distrito::create(['distrito' => 'Nahulingo', 'id_municipio' => 39]);
        Distrito::create(['distrito' => 'San Antonio del Monte', 'id_municipio' => 39]);
        Distrito::create(['distrito' => 'Santo Domingo de Guzmán', 'id_municipio' => 39]);

        Distrito::create(['distrito' => 'Izalco', 'id_municipio' => 40]);
        Distrito::create(['distrito' => 'Armenia', 'id_municipio' => 40]);
        Distrito::create(['distrito' => 'Caluco', 'id_municipio' => 40]);
        Distrito::create(['distrito' => 'San Julián', 'id_municipio' => 40]);
        Distrito::create(['distrito' => 'Cuisnahuat', 'id_municipio' => 40]);
        Distrito::create(['distrito' => 'Santa Isabel Ishuatán', 'id_municipio' => 40]);

        Distrito::create(['distrito' => 'Acajutla', 'id_municipio' => 41]);

        // Departamento de Santa Ana
        Distrito::create(['distrito' => 'Masahuat', 'id_municipio' => 34]);
        Distrito::create(['distrito' => 'Metapán', 'id_municipio' => 34]);
        Distrito::create(['distrito' => 'Santa Rosa Guachipilín', 'id_municipio' => 34]);
        Distrito::create(['distrito' => 'Texistepeque', 'id_municipio' => 34]);

        Distrito::create(['distrito' => 'Santa Ana', 'id_municipio' => 35]);

        Distrito::create(['distrito' => 'Coatepeque', 'id_municipio' => 36]);
        Distrito::create(['distrito' => 'El Congo', 'id_municipio' => 36]);

        Distrito::create(['distrito' => 'Candelaria de la Frontera', 'id_municipio' => 37]);
        Distrito::create(['distrito' => 'Chalchuapa', 'id_municipio' => 37]);
        Distrito::create(['distrito' => 'El Porvenir', 'id_municipio' => 37]);
        Distrito::create(['distrito' => 'San Antonio Pajonal', 'id_municipio' => 37]);
        Distrito::create(['distrito' => 'San Sebastián Salitrillo', 'id_municipio' => 37]);
        Distrito::create(['distrito' => 'Santiago de La Frontera', 'id_municipio' => 37]);

        // Departamento de San Vicente
        Distrito::create(['distrito' => 'Apastepeque', 'id_municipio' => 32]);
        Distrito::create(['distrito' => 'Santa Clara', 'id_municipio' => 32]);
        Distrito::create(['distrito' => 'San Ildefonso', 'id_municipio' => 32]);
        Distrito::create(['distrito' => 'San Esteban Catarina', 'id_municipio' => 32]);
        Distrito::create(['distrito' => 'San Sebastián', 'id_municipio' => 32]);
        Distrito::create(['distrito' => 'San Lorenzo', 'id_municipio' => 32]);
        Distrito::create(['distrito' => 'Santo Domingo', 'id_municipio' => 32]);

        Distrito::create(['distrito' => 'San Vicente', 'id_municipio' => 33]);
        Distrito::create(['distrito' => 'Guadalupe', 'id_municipio' => 33]);
        Distrito::create(['distrito' => 'Verapaz', 'id_municipio' => 33]);
        Distrito::create(['distrito' => 'Tepetitán', 'id_municipio' => 33]);
        Distrito::create(['distrito' => 'Tecoluca', 'id_municipio' => 33]);
        Distrito::create(['distrito' => 'San Cayetano Istepeque', 'id_municipio' => 33]);

        // Departamento de San Miguel
        Distrito::create(['distrito' => 'Ciudad Barrios', 'id_municipio' => 24]);
        Distrito::create(['distrito' => 'Sesori', 'id_municipio' => 24]);
        Distrito::create(['distrito' => 'Nuevo Edén de San Juan', 'id_municipio' => 24]);
        Distrito::create(['distrito' => 'San Gerardo', 'id_municipio' => 24]);
        Distrito::create(['distrito' => 'San Luis de La Reina', 'id_municipio' => 24]);
        Distrito::create(['distrito' => 'Carolina', 'id_municipio' => 24]);
        Distrito::create(['distrito' => 'San Antonio del Mosco', 'id_municipio' => 24]);
        Distrito::create(['distrito' => 'Chapeltique', 'id_municipio' => 24]);

        Distrito::create(['distrito' => 'San Miguel', 'id_municipio' => 25]);
        Distrito::create(['distrito' => 'Comacarán', 'id_municipio' => 25]);
        Distrito::create(['distrito' => 'Uluazapa', 'id_municipio' => 25]);
        Distrito::create(['distrito' => 'Moncagua', 'id_municipio' => 25]);
        Distrito::create(['distrito' => 'Quelepa', 'id_municipio' => 25]);
        Distrito::create(['distrito' => 'Chirilagua', 'id_municipio' => 25]);

        Distrito::create(['distrito' => 'Chinameca', 'id_municipio' => 26]);
        Distrito::create(['distrito' => 'Nueva Guadalupe', 'id_municipio' => 26]);
        Distrito::create(['distrito' => 'Lolotique', 'id_municipio' => 26]);
        Distrito::create(['distrito' => 'San Jorge', 'id_municipio' => 26]);
        Distrito::create(['distrito' => 'San Rafael Oriente', 'id_municipio' => 26]);
        Distrito::create(['distrito' => 'El Tránsito', 'id_municipio' => 26]);

        // Departamento de Morazán
        Distrito::create(['distrito' => 'Arambala', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'Cacaopera', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'Corinto', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'El Rosario', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'Joateca', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'Jocoaitique', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'Meanguera', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'Perquín', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'San Fernando', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'San Isidro', 'id_municipio' => 22]);
        Distrito::create(['distrito' => 'Torola', 'id_municipio' => 22]);

        Distrito::create(['distrito' => 'Chilanga', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Delicias de Concepción', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'El Divisadero', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Gualococti', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Guatajiagua', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Jocoro', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Lolotiquillo', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Osicala', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'San Carlos', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'San Francisco Gotera', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'San Simón', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Sensembra', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Sociedad', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Yamabal', 'id_municipio' => 23]);
        Distrito::create(['distrito' => 'Yoloaiquín', 'id_municipio' => 23]);
    }
}
