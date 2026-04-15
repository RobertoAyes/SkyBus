<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('viajes', function (Blueprint $table) {

            $table->foreignId('bus_id')
                ->nullable()
                ->constrained('buses')
                ->onDelete('set null');

            $table->integer('asientos_totales')
                ->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('viajes', function (Blueprint $table) {

            // 🔥 forma segura de eliminar FK
            $table->dropForeign(['bus_id']);
            $table->dropColumn('bus_id');

            $table->dropColumn('asientos_totales');
        });
    }
};
