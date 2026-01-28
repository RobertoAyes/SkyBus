<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calificaciones_chofer', function (Blueprint $table) {
            // Eliminar FK si existe
            try {
                $table->dropForeign(['usuario_id']);
            } catch (\Exception $e) {}

            // Hacer la columna nullable
            $table->unsignedBigInteger('usuario_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('calificaciones_chofer', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->nullable(false)->change();
        });
    }
};
