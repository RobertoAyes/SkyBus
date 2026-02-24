@extends('layouts.layoutadmin')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Lista de servicios de la terminal {{ $terminal->nombre }}
            </h4>
        </div> <br>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive border-top border-bottom py-2">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>Nombre del servicio</th>
                        <th>Descripción</th>
                        <th class="text-center" width="120">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($terminal->servicios as $servicio)
                        <tr>
                            <td class="fw-semibold">{{ $servicio->nombre }}</td>
                            <td class="text-muted">{{ $servicio->descripcion }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $servicio->id }}">
                                    Eliminar
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="deleteModal{{ $servicio->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h6 class="modal-title">
                                            Confirmar eliminación
                                        </h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        ¿Está seguro de que desea borrar el servicio "{{$servicio->nombre}}"?
                                    </div>
                                    <div class="modal-footer justify-content-center border-0">
                                        <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Sí, eliminar
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                            Cancelar
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No hay servicios registrados para esta terminal.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <a href="{{ route('terminales.index') }}" class="btn btn-secondary">
                    Regresar
                </a>
            </div>
        </div>
    </div>

@endsection
