{{-- Esta vista muestra todos los incidentes
     registrados por el empleado que inició sesión --}}

@extends('layouts.layoutempleado') {{-- Usa el layout del empleado --}}

@section('contenido')

    <div class="container mt-4">

        <h2>Mis Incidentes Registrados</h2>

        <hr>

        {{-- Verificamos si el empleado tiene incidentes --}}
        @if($incidentes->isEmpty())

            <div class="alert alert-info">
                No tienes incidentes registrados.
            </div>

        @else

            {{-- Imprimir el historial de los incidentes --}}
            <div class="mb-3 text-end">
                <button onclick="window.print()" class="btn btn-primary">
                    Imprimir historial
                </button>
            </div>

            {{-- Tabla donde se mostrarán los incidentes --}}
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Bus</th>
                    <th>Ruta</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                </tr>
                </thead>

                <tbody>

                {{-- Recorremos cada incidente encontrado --}}
                @foreach($incidentes as $incidente)

                    <tr>
                        {{-- Fecha y hora del incidente --}}
                        <td>{{ $incidente->fecha_hora }}</td>

                        {{-- Número del bus --}}
                        <td>{{ $incidente->bus_numero }}</td>

                        {{-- Ruta donde ocurrió --}}
                        <td>{{ $incidente->ruta }}</td>

                        {{-- Tipo de incidente --}}
                        <td>{{ $incidente->tipo_incidente }}</td>

                        {{-- Descripción del problema --}}
                        <td>{{ $incidente->descripcion }}</td>
                    </tr>

                @endforeach

                </tbody>

            </table>

        @endif

    </div>

    <style>
        @media print {

            body * {
                visibility: hidden;
            }

            table, table * {
                visibility: visible;
            }

            table {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

        }
    </style>

@endsection
