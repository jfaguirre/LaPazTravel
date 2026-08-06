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
        Schema::create('solicitud_operaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_solicitud')
                ->constrained('solicitudes')
                ->cascadeOnDelete();

            // Modelo afectado
            $table->string('modelo');

            // Id del registro real
            $table->unsignedBigInteger('id_registro')->nullable();

            // Tipo de operación
            $table->enum('operacion', [
                'CREATE',
                'UPDATE',
                'DELETE'
            ]);

            // Descripción legible para el administrador
            $table->string('descripcion')->nullable();
            // Toda la información del cambio
            $table->json('cambios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_operaciones');
    }
};
