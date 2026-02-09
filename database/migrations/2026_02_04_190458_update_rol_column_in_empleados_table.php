<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->string('rol', 20)->change();
        });
    }

    public function down(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->enum('rol', ['Empleado', 'Administrador'])->change();
        });
    }
};
