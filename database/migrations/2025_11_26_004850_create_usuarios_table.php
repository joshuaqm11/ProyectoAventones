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
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('apellido');
        $table->string('cedula')->unique();
        $table->date('fecha_nacimiento')->nullable();
        $table->string('correo')->unique();
        $table->string('telefono')->nullable();
        $table->string('foto')->nullable();
        $table->string('password');
        $table->enum('tipo', ['admin','chofer','pasajero']);
        $table->enum('estado', ['pendiente','activo','inactivo'])->default('pendiente');
        $table->string('token_activacion')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('usuarios');
}

};
