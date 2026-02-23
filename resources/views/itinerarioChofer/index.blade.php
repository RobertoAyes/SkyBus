@extends('layouts.layoutadmin')

@section('title', 'Itinerarios de Choferes')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-calendar-alt me-2"></i>Itinerarios Asignados
                </h2>
            </div>
            <div class="card-body">
                <a href="{{ route('itinerarioChofer.create') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-lg"></i> Asignar Itinerario
                </a>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm">
                        <i class="fas fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>Chofer</th>
                            <th>Ruta</th>
                            <th>Fecha y Hora</th>
                            <th class="text-center">Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($itinerarios as $itinerario)
                            <tr>
                                <td>{{ $itinerario->chofer->name ?? 'Sin chofer' }}</td>
                                <td>{{ $itinerario->ruta->origen ?? 'Sin origen' }} - {{ $itinerario->ruta->destino ?? 'Sin destino' }}</td>
                                <td>{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y H:i') : 'No asignada' }}</td>
                                <td class="text-center">


                                    <!-- Botón que abre el modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarModal{{ $itinerario->id }}">
                                        <i class="fas fa-trash me-1"></i>Eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de confirmación de eliminación -->
                            <div class="modal fade" id="eliminarModal{{ $itinerario->id }}" tabindex="-1" aria-labelledby="eliminarModalLabel{{ $itinerario->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="eliminarModalLabel{{ $itinerario->id }}">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro que deseas eliminar el itinerario de <strong>{{ $itinerario->chofer->name ?? 'Sin chofer' }}</strong> para la ruta <strong>{{ $itinerario->ruta->origen ?? '' }} - {{ $itinerario->ruta->destino ?? '' }}</strong> en <strong>{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y H:i') : 'No asignada' }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('itinerarioChofer.destroy', $itinerario->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-calendar-alt fa-2x mb-2 d-block"></i>No hay itinerarios asignados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
