@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Solicitudes de Empleo</h2>

        <!-- FORMULARIO DE FILTRO POR ESTADO -->
        <form method="GET" action="{{ route('admin.solicitudes.empleo') }}" class="mb-3">

            <!-- Selector de estado -->
            <select name="estado" class="form-select w-auto d-inline">
                <option value="">-- Filtrar por estado --</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>
                    Pendiente
                </option>
                <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>
                    En Proceso
                </option>
                <option value="atendida" {{ request('estado') == 'atendida' ? 'selected' : '' }}>
                    Atendida
                </option>
            </select>

            <!-- Campo para buscar por puesto -->
            <input type="text"
                   name="puesto"
                   value="{{ request('puesto') }}"
                   placeholder="Buscar por puesto"
                   class="form-control w-auto d-inline">

            <!-- Botón filtrar -->
            <button type="submit" class="btn btn-primary btn-sm">
                Filtrar
            </button>

            <a href="{{ route('admin.solicitudes.empleo') }}"
               class="btn btn-secondary btn-sm">
                Limpiar
            </a>
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Puesto</th>
                <th>Estado</th>
                <th>CV</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($solicitudes as $solicitud)
                <tr>
                    <td>{{ $solicitud->nombre_completo }}</td>
                    <td>{{ $solicitud->contacto }}</td>
                    <td>{{ $solicitud->puesto_deseado }}</td>

                    <!-- COLUMNA ESTADO CON COLOR -->
                    <td>
                        @php
                            // Convertimos a minúscula para evitar errores
                            $estado = strtolower($solicitud->estado ?? 'pendiente');
                        @endphp

                        @if($estado == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                        @elseif($estado == 'en_proceso')
                            <span class="badge bg-info">En Proceso</span>
                        @elseif($estado == 'atendida')
                            <span class="badge bg-success">Atendida</span>
                        @endif
                    </td>

                    <!-- COLUMNA CV -->
                    <td>
                        @if($solicitud->cv)
                            <a href="{{ asset('storage/' . $solicitud->cv) }}" target="_blank" class="btn btn-sm btn-primary">
                                Ver CV
                            </a>
                        @else
                            No adjunto
                        @endif
                    </td>

                    <!-- COLUMNA ACCIONES -->
                    <td>
                        <a href="{{ route('admin.solicitudes.empleo.show', $solicitud->id) }}"
                           class="btn btn-sm btn-info">
                            Ver detalle
                        </a>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay solicitudes registradas</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
