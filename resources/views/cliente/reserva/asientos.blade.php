@extends('layouts.layoutuser')

@section('contenido')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Asientos Disponibles para Viaje: {{ $viaje->origen->nombre }} a {{ $viaje->destino->nombre }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('cliente.reserva.store') }}" method="POST">
                @csrf
                <input type="hidden" name="viaje_id" value="{{ $viaje->id }}">
                <div class="mb-3">
                    <label>Seleccione Asiento</label>
                    <select name="asiento_id" class="form-select">
                        @foreach($asientos as $asiento)
                            <option value="{{ $asiento->id }}">Asiento #{{ $asiento->numero_asiento }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Reservar</button>
            </form>
        </div>
    </div>
@endsection
