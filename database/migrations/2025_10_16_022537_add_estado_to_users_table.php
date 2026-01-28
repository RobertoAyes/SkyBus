<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo agrega la columna si no existe
            if (!Schema::hasColumn('users', 'estado')) {
                $table->enum('estado', ['activo', 'inactivo'])
                    ->default('activo')
                    ->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo elimina la columna si existe
            if (Schema::hasColumn('users', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};
