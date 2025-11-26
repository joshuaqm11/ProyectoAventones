<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('vehiculos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('usuario_id'); // chofer dueño del vehículo

        $table->string('placa')->unique();
        $table->string('marca');
        $table->string('modelo');
        $table->year('anio');
        $table->string('color');
        $table->string('fotografia')->nullable(); // ruta de la imagen
        $table->unsignedInteger('capacidad');     // cantidad de espacios

        $table->timestamps();

        $table->foreign('usuario_id')
              ->references('id')
              ->on('usuarios')
              ->onDelete('cascade');
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
