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
        Schema::table('empresa_buses', function (Blueprint $table) {
            $table->boolean('estado_validacion')->default(0)->after('telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresa_buses', function (Blueprint $table) {
            $table->dropColumn('estado_validacion');
        });
    }
};
