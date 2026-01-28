@extends('layouts.layoutadmin')

@section('title', 'Listado de Rentas de Viaje Express')

@section('content')

    <div class="container mt-4">
        {{-- Encabezado y Botón de Creación --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0">Listado de Rentas de Viaje Express</h2>
            <a href="{{ route('rentas.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus"></i> Registrar Nueva Renta
            </a>
        </div>

        {{-- Mensajes de Sesión (Éxito/Error) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Inicio de la Tabla de Datos --}}
        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Verifica si hay rentas para mostrar --}}
                @if ($rentas->isEmpty())
                    <div class="alert alert-info mb-0" role="alert">
                        <i class="fas fa-info-circle"></i> No se han registrado rentas de viaje aún.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                            <tr>
                                <th># ID</th>
                                {{-- 🔑 ENCABEZADO CORREGIDO --}}
                                <th>Cliente (Nombre / DNI)</th>
                                <th>Destino</th>
                                <th>Fechas</th>
                                <th>Evento</th>
                                <th>Pasajeros</th>
                                <th>Total (Lps)</th>
                                <th>Anticipo (Lps)</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rentas as $renta)
                                <tr>
                                    <td>{{ $renta->id }}</td>

                                    {{-- 🔑 CUERPO CORREGIDO: Muestra el nombre y DNI en la misma celda --}}
                                    <td>
                                        <div style="font-weight: 600;">{{ $renta->nombre_completo }}</div>
                                        {{-- **ASUME** que el DNI está en la relación $renta->cliente->dni. --}}
                                        @if(isset($renta->cliente->dni))
                                            <div style="font-size: 0.85em; color: #6c757d;">
                                                ({{ $renta->cliente->dni }})
                                            </div>
                                        @endif
                                    </td>
                                    {{-- FIN DE LA CORRECCIÓN --}}

                                    <td>{{ $renta->destino }}</td>
                                    <td>
                                        Inicio: {{ \Carbon\Carbon::parse($renta->fecha_inicio)->format('d/m/Y') }}<br>
                                        Fin: {{ \Carbon\Carbon::parse($renta->fecha_fin)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $renta->tipo_evento }}</td>
                                    <td>
                                        {{ $renta->num_pasajeros_confirmados ?? $renta->num_pasajeros_estimados ?? 'N/A' }}
                                    </td>

                                    {{-- CORRECCIÓN: Usando el campo 'total_tarifa' que se calcula y se guarda en el Controlador --}}
                                    <td>
                                        <strong>{{ number_format($renta->total_tarifa, 2) }}</strong>
                                    </td>

                                    <td>{{ number_format($renta->anticipo, 2) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Botón para Editar - COLOR AZUL --}}
                                            <a href="{{ route('rentas.edit', $renta->id) }}" class="btn btn-sm btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>

                                            {{-- Botón para Eliminar - COLOR ROJO --}}
                                            <form action="{{ route('rentas.destroy', $renta->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Está seguro de que desea eliminar esta renta?')">
                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Paginación --}}
        <div class="mt-3">
            {{ $rentas->links() }}
        </div>
    </div>
@endsection
