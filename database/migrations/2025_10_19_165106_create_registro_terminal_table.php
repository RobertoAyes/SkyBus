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
        Schema::create('registro_terminal', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('codigo', 10)->unique();
            $table->string('direccion',150 );
            $table->string('departamento', 50);
            $table->string('municipio', 50);
            $table->string('telefono', 8);
            $table->string('correo', 50);
            $table->time('horario_apertura');
            $table->time('horario_cierre');
            $table->text('descripcion');
            $table->decimal('latitud', 10, 8)->nullable(); // ✅ NUEVO
            $table->decimal('longitud', 11, 8)->nullable(); // ✅ NUEVO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_terminal');
    }
};
