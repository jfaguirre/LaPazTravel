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
        Schema::create('sitio_servicio', function (Blueprint $table) {
            $table->foreignId('id_sitioPerfil')->constrained('sitio_perfil')->cascadeOnDelete();                        
            $table->foreignId('id_servicio')->constrained('servicios')->cascadeOnDelete();
            $table->unique(['id_sitioPerfil', 'id_servicio']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitio_servicio');
    }
};
