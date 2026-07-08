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
        Schema::create('imagenes_sitios', function (Blueprint $table) {
            $table->id();
            $table->string('url', 255);
            $table->string('titulo', 150)->nullable();
            $table->boolean('principal')->default(false);
            $table->integer('orden')->default(1);
            $table->foreignId('sitio_id')->constrained('sitios')->cascadeOnDelete();
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes_sitios');
    }
};
