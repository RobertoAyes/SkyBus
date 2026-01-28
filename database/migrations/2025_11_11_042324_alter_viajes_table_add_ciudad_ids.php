<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->foreignId('ciudad_origen_id')->constrained('ciudades')->after('id');
            $table->foreignId('ciudad_destino_id')->constrained('ciudades')->after('ciudad_origen_id');
            $table->dropColumn('origen');
            $table->dropColumn('destino');
            $table->renameColumn('fecha_salida', 'fecha_hora_salida');
            $table->renameColumn('capacidad_maxima', 'asientos_totales');
            $table->dropColumn('fecha_llegada');
            $table->dropColumn('precio');
        });
    }

    public function down(): void
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->string('origen')->after('id');
            $table->string('destino')->after('origen');
            $table->dropForeign(['ciudad_origen_id']);
            $table->dropForeign(['ciudad_destino_id']);
            $table->dropColumn('ciudad_origen_id');
            $table->dropColumn('ciudad_destino_id');
            $table->renameColumn('fecha_hora_salida', 'fecha_salida');
            $table->renameColumn('asientos_totales', 'capacidad_maxima');
            $table->dateTime('fecha_llegada')->after('fecha_salida');
            $table->decimal('precio', 8, 2)->after('fecha_llegada');
        });
    }
};
