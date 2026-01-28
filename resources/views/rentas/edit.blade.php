@extends('layouts.layoutadmin')

@section('title', 'Editar Renta de Viaje Express')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Editar Renta de Viaje Express</h2>

        {{-- Mensajes de validación --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>¡Ups! Algo salió mal.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario de Edición --}}
        <form action="{{ route('rentas.update', $renta->id) }}" method="POST" id="editarRentaForm" class="card p-4 shadow-sm rounded-3">
            @csrf
            @method('PUT')

            {{-- Sección 1: Datos del Cliente (Solo lectura) --}}
            <h3>Datos del Cliente</h3>
            <hr>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Nombre del Cliente</label>
                    <input type="text" class="form-control" value="{{ $renta->nombre_completo }}" readonly>
                    <small class="text-muted">El nombre no se puede modificar</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label">DNI / Identificación</label>
                    <input type="text" class="form-control" value="{{ $renta->usuario->dni ?? 'N/A' }}" readonly>
                </div>
            </div>

            {{-- Sección 2: Detalles del Viaje --}}
            <h3>Detalles del Viaje</h3>
            <hr>

            {{-- Punto de Partida y Destino --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="punto_partida" class="form-label">Punto de Partida</label>
                    <input type="text" name="punto_partida" id="punto_partida" class="form-control" required value="{{ old('punto_partida', $renta->punto_partida) }}">
                </div>
                <div class="col-md-6">
                    <label for="destino" class="form-label">Destino</label>
                    <input type="text" name="destino" id="destino" class="form-control" required value="{{ old('destino', $renta->destino) }}">
                </div>
            </div>

            {{-- Fechas --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required value="{{ old('fecha_inicio', $renta->fecha_inicio) }}">
                </div>
                <div class="col-md-6">
                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required value="{{ old('fecha_fin', $renta->fecha_fin) }}">
                </div>
            </div>

            {{-- Tipo de Evento y Estado del Servicio --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tipo_evento" class="form-label">Tipo de Evento</label>
                    <select name="tipo_evento" id="tipo_evento" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option value="Familiar" {{ old('tipo_evento', $renta->tipo_evento) == 'Familiar' ? 'selected' : '' }}>Familiar</option>
                        <option value="Campamento" {{ old('tipo_evento', $renta->tipo_evento) == 'Campamento' ? 'selected' : '' }}>Campamento</option>
                        <option value="Excursión" {{ old('tipo_evento', $renta->tipo_evento) == 'Excursión' ? 'selected' : '' }}>Excursión</option>
                        <option value="Educativo" {{ old('tipo_evento', $renta->tipo_evento) == 'Educativo' ? 'selected' : '' }}>Educativo</option>
                        <option value="Empresarial" {{ old('tipo_evento', $renta->tipo_evento) == 'Empresarial' ? 'selected' : '' }}>Empresarial</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado del Servicio</label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option value="cotizado" {{ old('estado', $renta->estado) == 'cotizado' ? 'selected' : '' }}>Cotizado</option>
                        <option value="confirmado" {{ old('estado', $renta->estado) == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="en_ruta" {{ old('estado', $renta->estado) == 'en_ruta' ? 'selected' : '' }}>En Ruta</option>
                        <option value="completado" {{ old('estado', $renta->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelado" {{ old('estado', $renta->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
            </div>

            {{-- Pasajeros y Horarios --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="num_pasajeros_confirmados" class="form-label">Pasajeros Confirmados</label>
                    <input type="number" name="num_pasajeros_confirmados" id="num_pasajeros_confirmados" class="form-control" value="{{ old('num_pasajeros_confirmados', $renta->num_pasajeros_confirmados) }}">
                </div>
                <div class="col-md-3">
                    <label for="num_pasajeros_estimados" class="form-label">Pasajeros Estimados</label>
                    <input type="number" name="num_pasajeros_estimados" id="num_pasajeros_estimados" class="form-control" value="{{ old('num_pasajeros_estimados', $renta->num_pasajeros_estimados) }}">
                </div>
                <div class="col-md-3">
                    <label for="hora_salida" class="form-label">Hora de Salida</label>
                    <input type="time" name="hora_salida" id="hora_salida" class="form-control" value="{{ old('hora_salida', $renta->hora_salida ? \Carbon\Carbon::parse($renta->hora_salida)->format('H:i') : '') }}">
                </div>
                <div class="col-md-3">
                    <label for="hora_retorno" class="form-label">Hora de Retorno</label>
                    <input type="time" name="hora_retorno" id="hora_retorno" class="form-control" value="{{ old('hora_retorno', $renta->hora_retorno ? \Carbon\Carbon::parse($renta->hora_retorno)->format('H:i') : '') }}">
                </div>
            </div>

            {{-- Sección 3: Información Financiera --}}
            <h3>Información Financiera</h3>
            <hr>
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="tarifa" class="form-label">Tarifa Base (Lps)</label>
                    <input type="number" step="0.01" name="tarifa" id="tarifa" class="form-control" required value="{{ old('tarifa', $renta->tarifa) }}">
                </div>
                <div class="col-md-3">
                    <label for="descuento_valor" class="form-label">Descuento (%)</label>
                    <input type="number" step="0.01" name="descuento_valor" id="descuento_valor" class="form-control" value="{{ old('descuento_valor', $renta->descuento ? ($renta->descuento / $renta->tarifa * 100) : 0) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Total a Pagar (Lps)</label>
                    <input type="number" step="0.01" id="total" class="form-control" readonly value="{{ old('total', $renta->total_tarifa) }}">
                </div>
                <div class="col-md-3">
                    <label for="anticipo" class="form-label">Anticipo (Lps)</label>
                    <input type="number" step="0.01" name="anticipo" id="anticipo" class="form-control" value="{{ old('anticipo', $renta->anticipo) }}">
                </div>
            </div>

            {{-- Campo de Penalización --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="penalizacion" class="form-label">Penalización (Lps)</label>
                    <input type="number" step="0.01" name="penalizacion" id="penalizacion" class="form-control" value="{{ old('penalizacion', $renta->penalizacion) }}">
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-4">Actualizar Renta</button>
                <a href="{{ route('rentas.index') }}" class="btn btn-secondary px-4">Cancelar</a>
            </div>
        </form>
    </div>

    {{-- Script para cálculos en tiempo real --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tarifaInput = document.getElementById('tarifa');
            const descuentoInput = document.getElementById('descuento_valor');
            const totalInput = document.getElementById('total');

            function calcularTotal() {
                const tarifa = parseFloat(tarifaInput.value) || 0;
                const descuentoPorcentaje = parseFloat(descuentoInput.value) || 0;

                if (tarifa > 0) {
                    const descuentoMonto = tarifa * (descuentoPorcentaje / 100);
                    const totalCalculado = tarifa - descuentoMonto;
                    totalInput.value = totalCalculado.toFixed(2);
                } else {
                    totalInput.value = '0.00';
                }
            }

            tarifaInput.addEventListener('input', calcularTotal);
            descuentoInput.addEventListener('input', calcularTotal);

            // Calcular al cargar la página
            calcularTotal();
        });
    </script>
@endsection
