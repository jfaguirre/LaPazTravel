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
        Schema::create('precios', function (Blueprint $table) {
            // Asignacion de la categoria y el precio de cada categoria en el sitio
            $table->id();
            $table->string('categoria', 50);
            $table->decimal('precioEntrada', 8, 2);
            $table->string('descripcion', 100)->nullable();
            $table->foreignId('id_sitioPerfil')->constrained('sitio_perfil')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios');
    }
};
