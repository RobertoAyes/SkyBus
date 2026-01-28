<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('empleados')) {
            Schema::create('empleados', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 100);
                $table->string('apellido', 100);
                $table->string('dni', 20)->unique();
                $table->string('cargo', 50);
                $table->date('fecha_ingreso');
                $table->string('email')->unique();
                $table->string('password_initial')->nullable();
                $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
                $table->string('foto')->nullable();
                $table->string('motivo_baja')->nullable();
                $table->timestamp('fecha_desactivacion')->nullable();
                $table->timestamps();
                $table->enum('rol', ['Empleado', 'Administrador'])->default('Empleado');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
