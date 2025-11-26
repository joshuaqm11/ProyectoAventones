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
        Schema::create('rides', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('usuarios'); // chofer
        $table->foreignId('vehiculo_id')->nullable()->constrained('vehiculos')->nullOnDelete();
        $table->string('nombre');
        $table->string('lugar_salida');
        $table->string('lugar_llegada');
        $table->date('fecha');
        $table->time('hora');
        $table->decimal('costo', 10, 2);
        $table->unsignedInteger('espacios');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
