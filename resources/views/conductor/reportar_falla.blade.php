@extends('layouts.layoutchofer')

@section('content')

    <div class="container">

        <h2>Reportar Falla Mecánica</h2>

        <!-- Nombre del conductor (se llena automáticamente) -->
        <div class="mb-3">
            <label class="form-label">Conductor</label>
            <input type="text"
                   name="conductor_nombre"
                   class="form-control"
                   value="{{ auth()->user()->name }}"
                   readonly>
        </div>

        <!-- Formulario para registrar la falla -->
        <form method="POST" action="{{ route('empleado.incidentes.store') }}">

            @csrf

            <!-- Número del bus -->
            <div class="mb-3">
                <label class="form-label">Número de Bus</label>
                <input type="text" name="bus_numero" class="form-control" required>
            </div>

            <!-- Ruta del viaje -->
            <div class="mb-3">
                <label class="form-label">Ruta</label>
                <input type="text" name="ruta" class="form-control" required>
            </div>

            <!-- Tipo de falla -->
            <div class="mb-3">
                <label class="form-label">Tipo de Falla</label>
                <select name="tipo_incidente" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <option value="motor">Motor</option>
                    <option value="frenos">Frenos</option>
                    <option value="llantas">Llantas</option>
                    <option value="electrico">Eléctrico</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label class="form-label">Descripción de la Falla</label>
                <textarea name="descripcion" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Ubicación -->
            <div class="mb-3">
                <label class="form-label">Ubicación actual</label>
                <input type="text" name="ubicacion" class="form-control" required>
            </div>

            <!-- Nivel de gravedad -->
            <div class="mb-3">
                <label class="form-label">Nivel de gravedad</label>
                <select name="nivel_gravedad" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <option value="baja">Baja</option>
                    <option value="media">Media</option>
                    <option value="alta">Alta</option>
                    <option value="critica">Crítica</option>
                </select>
            </div>

            <!-- Botón -->
            <button type="submit" class="btn btn-danger">
                Reportar Falla
            </button>

        </form>

    </div>

@endsection
