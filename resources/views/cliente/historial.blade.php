@extends('layouts.layoutuser')

@section('title', 'Historial de Viajes')

@section('contenido')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-history me-2"></i>Historial de Viajes</h4>
            <a href="{{ route('cliente.reserva.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Nueva Reserva
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('error'))
                <div class="alert alert-danger m-2">
                    {{ session('error') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th class="text-center">Fecha Reserva</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th class="text-center">Salida</th>
                        <th class="text-center">Llegada</th>
                        <th class="text-center">Asiento</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reservas as $reserva)
                        <tr>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y H:i') }}
                            </td>
                            <td>{{ $reserva->viaje->origen->nombre ?? '-' }}</td>
                            <td>{{ $reserva->viaje->destino->nombre ?? '-' }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-center">
                                {{ $reserva->viaje->fecha_llegada
                                    ? \Carbon\Carbon::parse($reserva->viaje->fecha_llegada)->format('d/m/Y H:i')
                                    : '-' }}
                            </td>
                            <td class="text-center">
                                {{ $reserva->asiento ? '#'.$reserva->asiento->numero_asiento : '-' }}
                            </td>
                            <td class="text-center">
                                    <span class="badge
                                        {{ $reserva->estado === 'confirmada' ? 'bg-success' :
                                           ($reserva->estado === 'cancelada' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($reserva->estado) }}
                                    </span>
                            </td>

                            <td class="text-center">
                                @if($reserva->estado === 'confirmada' && !$reserva->viaje->calificacion)
                                    <a href="{{ route('calificacion.create', $reserva->id) }}"
                                       class="btn btn-warning btn-sm me-1">
                                        <i class="fas fa-star"></i>
                                    </a>

                                    {{-- Botón Registrar Puntos --}}
                                    <a href="{{ route('puntos.create', $reserva->id) }}"
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-coins"></i>
                                    </a>

                                @elseif($reserva->estado === 'confirmada' && $reserva->viaje->calificacion)
                                    <span class="text-success fw-bold">Calificado</span>


                                    <a href="{{ route('puntos.create', $reserva->id) }}"
                                       class="btn btn-info btn-sm ms-2">
                                        <i class="fas fa-coins"></i> Registrar
                                    </a>

                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                No tienes reservas realizadas.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($reservas->hasPages())
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Mostrando {{ $reservas->firstItem() }} - {{ $reservas->lastItem() }} de {{ $reservas->total() }} reservas
                </small>
            </div>
        @endif
    </div>
@endsection
