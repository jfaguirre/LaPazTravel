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
        Schema::create('sitio_regla', function (Blueprint $table) {
            $table->foreignId('sitioPerfil_id')->constrained('sitio_perfils')->cascadeOnDelete();
            $table->foreignId('regla_id')->constrained('reglas')->cascadeOnDelete();
            $table->unique(['sitioPerfil_id', 'regla_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitio_regla');
    }
};
