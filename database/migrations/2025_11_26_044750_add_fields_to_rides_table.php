<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rides', function (Blueprint $table) {

            // 🚫 NO tocamos usuario_id porque ya existe

            // vehiculo_id (solo si no existe)
            if (!Schema::hasColumn('rides', 'vehiculo_id')) {
                $table->unsignedBigInteger('vehiculo_id')->nullable()->after('usuario_id');

                $table->foreign('vehiculo_id')
                    ->references('id')->on('vehiculos')
                    ->onDelete('cascade');
            }

            // Campos de detalle del ride (si faltan)
            if (!Schema::hasColumn('rides', 'origen')) {
                $table->string('origen')->after('vehiculo_id');
            }

            if (!Schema::hasColumn('rides', 'destino')) {
                $table->string('destino')->after('origen');
            }

            if (!Schema::hasColumn('rides', 'fecha')) {
                $table->date('fecha')->after('destino');
            }

            if (!Schema::hasColumn('rides', 'hora')) {
                $table->time('hora')->after('fecha');
            }

            if (!Schema::hasColumn('rides', 'precio')) {
                $table->decimal('precio', 10, 2)->after('hora');
            }

            if (!Schema::hasColumn('rides', 'espacios')) {
                $table->unsignedInteger('espacios')->after('precio');
            }

            if (!Schema::hasColumn('rides', 'estado')) {
                $table->string('estado')->default('activo')->after('espacios');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            // eliminamos solo si existen, para no romper rollback
            if (Schema::hasColumn('rides', 'estado')) {
                $table->dropColumn('estado');
            }
            if (Schema::hasColumn('rides', 'espacios')) {
                $table->dropColumn('espacios');
            }
            if (Schema::hasColumn('rides', 'precio')) {
                $table->dropColumn('precio');
            }
            if (Schema::hasColumn('rides', 'hora')) {
                $table->dropColumn('hora');
            }
            if (Schema::hasColumn('rides', 'fecha')) {
                $table->dropColumn('fecha');
            }
            if (Schema::hasColumn('rides', 'destino')) {
                $table->dropColumn('destino');
            }
            if (Schema::hasColumn('rides', 'origen')) {
                $table->dropColumn('origen');
            }
            if (Schema::hasColumn('rides', 'vehiculo_id')) {
                // primero quitamos la foreign si existe
                $table->dropForeign(['vehiculo_id']);
                $table->dropColumn('vehiculo_id');
            }
        });
    }
};
