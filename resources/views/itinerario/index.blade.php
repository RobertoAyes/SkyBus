@extends('layouts.layoutuser')

@section('title', 'Itinerario de Viajes')

@section('contenido')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8;">
                    <i class="fas fa-route me-2"></i>Itinerario de Viajes
                </h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDescargaPDF">
                    <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                </button>
            </div>
            <div class="card-body">
                <h5 class="mb-4"><i class="fas fa-user me-2"></i>Pasajero: {{ $usuario->name ?? 'N/A' }}</h5>

                @forelse($reservas as $reserva)
                    <div class="border-start border-4 border-primary p-3 mb-4 rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">
                                <i class="fas fa-bus me-2 text-primary"></i>
                                {{ optional($reserva->viaje->origen)->nombre ?? 'Origen' }} a {{ optional($reserva->viaje->destino)->nombre ?? 'Destino' }}
                            </h5>
                            <span class="badge
                            {{ $reserva->estado === 'confirmada' ? 'bg-success' : ($reserva->estado === 'pendiente' ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ strtoupper($reserva->estado ?? 'N/A') }}
                        </span>
                        </div>
                        <hr class="mt-1 mb-3">

                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Origen:</strong> {{ optional($reserva->viaje->origen)->nombre ?? 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-flag-checkered me-2 text-primary"></i><strong>Destino:</strong> {{ optional($reserva->viaje->destino)->nombre ?? 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-calendar-alt me-2 text-primary"></i><strong>Fecha:</strong> {{ optional($reserva->viaje->fecha_hora_salida) ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('d/m/Y') : 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-clock me-2 text-primary"></i><strong>Hora:</strong> {{ optional($reserva->viaje->fecha_hora_salida) ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('H:i') : 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-chair me-2 text-primary"></i><strong>Asiento:</strong> {{ optional($reserva->asiento)->numero_asiento ?? 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-ticket-alt me-2 text-primary"></i><strong>Código de Reserva:</strong> <span class="badge bg-info text-dark">{{ $reserva->codigo_reserva ?? 'N/A' }}</span></p>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-outline-primary btn-sm btn-compartir"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalCompartir"
                                    data-reserva-id="{{ $reserva->id }}">
                                <i class="fas fa-share-alt me-1"></i>Compartir
                            </button>
                            <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $reserva->id }}">
                                <i class="fas fa-edit me-1"></i>Editar
                            </button>
                        </div>
                    </div>

                    {{-- MODAL DE EDICIÓN --}}
                    <div class="modal fade" id="modalEditar{{ $reserva->id }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $reserva->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalEditarLabel{{ $reserva->id }}">
                                        <i class="fas fa-edit me-2"></i>Editar Detalles de la Reserva
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('reserva.update', $reserva->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="ciudad_origen_id{{ $reserva->id }}" class="form-label"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Origen</label>
                                            <select name="ciudad_origen_id" id="ciudad_origen_id{{ $reserva->id }}" class="form-select">
                                                @foreach($ciudades as $ciudad)
                                                    <option value="{{ $ciudad->id }}" {{ optional($reserva->viaje)->ciudad_origen_id == $ciudad->id ? 'selected' : '' }}>
                                                        {{ $ciudad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ciudad_destino_id{{ $reserva->id }}" class="form-label"><i class="fas fa-flag-checkered me-2 text-primary"></i>Destino</label>
                                            <select name="ciudad_destino_id" id="ciudad_destino_id{{ $reserva->id }}" class="form-select">
                                                @foreach($ciudades as $ciudad)
                                                    <option value="{{ $ciudad->id }}" {{ optional($reserva->viaje)->ciudad_destino_id == $ciudad->id ? 'selected' : '' }}>
                                                        {{ $ciudad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="fecha_salida{{ $reserva->id }}" class="form-label"><i class="fas fa-calendar-alt me-2 text-primary"></i>Fecha</label>
                                                <input type="date" name="fecha_salida" id="fecha_salida{{ $reserva->id }}" class="form-control" value="{{ optional($reserva->viaje)->fecha_hora_salida ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('Y-m-d') : '' }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="hora_salida{{ $reserva->id }}" class="form-label"><i class="fas fa-clock me-2 text-primary"></i>Hora</label>
                                                <input type="time" name="hora_salida" id="hora_salida{{ $reserva->id }}" class="form-control" value="{{ optional($reserva->viaje)->fecha_hora_salida ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('H:i') : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="asiento_id{{ $reserva->id }}" class="form-label"><i class="fas fa-chair me-2 text-primary"></i>Asiento</label>
                                            <select name="asiento_id" id="asiento_id{{ $reserva->id }}" class="form-select">
                                                @foreach($asientos as $asiento)
                                                    <option value="{{ $asiento->id }}" {{ $reserva->asiento_id == $asiento->id ? 'selected' : '' }}>
                                                        {{ $asiento->numero_asiento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i>Guardar Cambios</button>
                                    </div>
                                </form>
                                <div class="p-3 text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>No tienes reservas registradas aún.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Resto de modales y scripts permanece igual --}}
@endsection
