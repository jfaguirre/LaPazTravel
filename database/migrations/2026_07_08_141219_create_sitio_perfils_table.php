<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sitio_perfils', function (Blueprint $table) {
            // Datos principales
            $table->id();            
            $table->string('identificador', 10)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('correo_institucional', 255)->nullable();
            $table->text('direccion')->nullable();
            $table->json('horarios')->nullable();            
            // Redes sociales
            $table->string('facebook', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('tiktok', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('sitio_web', 255)->nullable();
            // Multimedia
            $table->string('foto_perfil', 255)->nullable();
            $table->string('foto_portada', 255)->nullable();
            // Ubicaion geografica
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            // Relaciones | Llaves foraneas            
            $table->foreignId('sitio_id')->nullable()->constrained('sitios')->onDelete('set null');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->onDelete('set null');
            $table->foreignId('distrito_id')->nullable()->constrained('distritos')->onDelete('set null');
            $table->foreignId('municipio_id')->nullable()->constrained('municipios')->onDelete('set null');            
            // Fecha de registro
            $table->timestamps();
            
        });
    }


    
   
    
    
    // created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    // updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    // FOREIGN KEY(id_sitio) REFERENCES sitios(id) ON DELETE CASCADE,
    // FOREIGN KEY(id_departamento) REFERENCES departamentos(id),
    // FOREIGN KEY(id_distrito) REFERENCES distritos(id),
    // FOREIGN KEY(id_municipio) REFERENCES municipios(id)





    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitio_perfils');
    }
};

