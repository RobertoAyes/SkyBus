@extends('layouts.layoutadmin')

@section('title', 'Panel Administrativo')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-road me-2"></i>Listado de Rutas
                </h2>
            </div>

            <div class="card-body">

                <a href="{{ route('rutas.create') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-lg"></i> Nueva Ruta
                </a>


                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Distancia</th>
                            <th>Duración</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rutas as $ruta)
                            <tr>
                                <td>{{ $ruta->origen }}</td>
                                <td>{{ $ruta->destino }}</td>
                                <td>{{ $ruta->distancia }} km</td>
                                <td>{{ $ruta->duracion_estimada }} min</td>
                                <td class="text-center">

                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $ruta->id }}">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>


                                    <div class="modal fade" id="editModal{{ $ruta->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $ruta->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-sm border-0">

                                                <div class="modal-header bg-white border-bottom-0">
                                                    <h5 class="modal-title" id="editModalLabel{{ $ruta->id }}" style="color:#1e63b8; font-weight:600; font-size:1.5rem;">
                                                        <i class="fas fa-road me-2"></i>Editar Ruta
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>


                                                <div class="modal-body">
                                                    <form action="{{ route('rutas.update', $ruta->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-bold"><i class="fas fa-location-arrow me-1"></i>Origen</label>
                                                            <input type="text" name="origen" class="form-control"
                                                                   value="{{ old('origen', $ruta->origen) }}"
                                                                   onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                                                                   required>

                                                            @error('origen')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-bold"><i class="fas fa-map-marker-alt me-1"></i>Destino</label>
                                                            <input type="text" name="destino" class="form-control"
                                                                   value="{{ old('destino', $ruta->destino) }}"
                                                                   onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                                                                   required>

                                                            @error('destino')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-bold"><i class="fas fa-road me-1"></i>Distancia (km)</label>
                                                            <input type="number" step="0.01" name="distancia" class="form-control" value="{{ old('distancia', $ruta->distancia) }}" min="5"required>
                                                            @error('distancia')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-bold"><i class="fas fa-clock me-1"></i>Duración estimada (min)</label>
                                                            <input type="number" name="duracion_estimada" class="form-control" value="{{ old('duracion_estimada', $ruta->duracion_estimada) }}" min="15" required>
                                                            @error('duracion_estimada')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="d-flex justify-content-between mt-4">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Cancelar
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-save me-1"></i>Guardar Cambios
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-road fa-2x mb-2 d-block"></i>No hay rutas registradas
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

