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
        Schema::create('sitios', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nombre', 150);
            $table->string('slug', 200)->unique();
            $table->text('descripcion_corta');
            $table->integer('visitas')->default(0);
            $table->enum('estado',['PENDIENTE', 'APROBADO', 'RECHAZADO', 'SUSPENDIDO'])->default('PENDIENTE');       
            $table->foreignId('id_user')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitios');
    }
};
