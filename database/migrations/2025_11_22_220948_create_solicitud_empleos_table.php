<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitud_empleos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre_completo');
            $table->string('contacto');
            $table->string('puesto_deseado');
            $table->text('experiencia_laboral');
            $table->string('cv')->nullable();
            $table->enum('estado', ['Pendiente', 'Revisada', 'Aceptada', 'Rechazada'])->default('Pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitud_empleos');
    }
};
