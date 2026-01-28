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
        Schema::create('documentos_buses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->enum('tipo_documento', [
                'permiso_operacion',
                'revision_tecnica',
                'seguro_vehicular',
                'matricula'
            ]);
            $table->string('numero_documento', 100);
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->string('archivo_url')->nullable();
            $table->enum('estado', ['vigente', 'por_vencer', 'vencido'])->default('vigente');
            $table->text('observaciones')->nullable();
            $table->integer('dias_hasta_vencimiento')->default(0);
            $table->foreignId('registrado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Índices para búsquedas rápidas
            $table->index('bus_id');
            $table->index('tipo_documento');
            $table->index('estado');
            $table->index('fecha_vencimiento');
        });

        // Tabla para el historial de documentos
        Schema::create('historial_documentos_buses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos_buses')->onDelete('cascade');
            $table->string('accion'); // creado, actualizado, vencido, renovado
            $table->text('descripcion')->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Tabla para notificaciones de vencimiento
        Schema::create('notificaciones_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos_buses')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipo', ['30_dias', '15_dias', '7_dias', 'vencido']);
            $table->boolean('leida')->default(false);
            $table->timestamp('fecha_notificacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones_documentos');
        Schema::dropIfExists('historial_documentos_buses');
        Schema::dropIfExists('documentos_buses');
    }
};
