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
         Schema::create('reservas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ride_id')->constrained('rides')->onDelete('cascade');
        $table->foreignId('pasajero_id')->constrained('usuarios')->onDelete('cascade');
        $table->enum('estado', ['pendiente','aceptada','rechazada','cancelada']);
        $table->unsignedInteger('cantidad')->default(1);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
