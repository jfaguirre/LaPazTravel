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
        Schema::create('sitio_perfil', function (Blueprint $table) {
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
            $table->foreignId('id_sitio')->nullable()->constrained('sitios')->onDelete('set null');
            $table->foreignId('id_departamento')->nullable()->constrained('departamentos')->onDelete('set null');
            $table->foreignId('id_distrito')->nullable()->constrained('distritos')->onDelete('set null');
            $table->foreignId('id_municipio')->nullable()->constrained('municipios')->onDelete('set null');            
            // Fecha de registro
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitio_perfil');
    }
};

