@extends('layouts.layoutuser')

@section('contenido')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Viajes Disponibles</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Hora Salida</th>
                    <th>Asientos Disp.</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($viajes as $viaje)
                    <tr>
                        <td>{{ $viaje->origen->nombre }}</td>
                        <td>{{ $viaje->destino->nombre }}</td>
                        <td>{{ $viaje->fecha_hora_salida }}</td>
                        <td>{{ $viaje->asientos_count }}</td>
                        <td>
                            <a href="{{ route('cliente.reserva.asientos', $viaje->id) }}" class="btn btn-info">Seleccionar Asiento</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
