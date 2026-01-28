@extends('layouts.layoutuser')

@section('title', 'Registrar Puntos')

@section('contenido')
    <div class="container mt-4">
        <h3 class="mb-3 text-primary">Puntos de tu viaje</h3>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <p><strong>Origen:</strong> {{ $reserva->viaje->origen->nombre ?? '-' }}</p>
                <p><strong>Destino:</strong> {{ $reserva->viaje->destino->nombre ?? '-' }}</p>
                <p><strong>Fecha Salida:</strong> {{ \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('d/m/Y ') }}</p>
                <p><strong>Fecha Llegada:</strong> {{ $reserva->viaje->fecha_llegada ? \Carbon\Carbon::parse($reserva->viaje->fecha_llegada)->format('d/m/Y ') : '-' }}</p>
                <p><strong>Asiento:</strong> {{ $reserva->asiento ? '#'.$reserva->asiento->numero_asiento : '-' }}</p>

                <form method="POST" action="{{ route('puntos.store', $reserva->id) }}">
                    @csrf

                    <div class="mb-3">
                        <p class="text-muted">Puntos que ganarás por este viaje</p>
                        <h1 class="text-primary">10</h1>
                        <input type="hidden" name="puntos" value="10">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Guardar puntos
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

