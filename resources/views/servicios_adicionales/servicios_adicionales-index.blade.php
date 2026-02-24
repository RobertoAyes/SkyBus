@extends('layouts.layoutadmin')

@section('title', 'Lista de Servicios Adicionales')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-list me-2"></i>Lista de Servicios Adicionales
            </h4>
            <a href="{{ route('servicios_adicionales.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Agregar servicio
            </a>
        </div>

        <div class="card-body p-0">

            @if(session('error'))
                <div class="alert alert-danger m-2">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($extras as $extra)
                        <tr>
                            <td>{{ $extra->nombre }}</td>
                            <td>{{ $extra->descripcion }}</td>
                            <td>
                                @if($extra->imagen)
                                    <img src="{{ asset('storage/' . $extra->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height:100px; object-fit:cover;">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm {{ $extra->estado ? 'btn-danger' : 'btn-success' }}" data-bs-toggle="modal" data-bs-target="#modalEstado{{ $extra->id }}">{{ $extra->estado ? 'Desactivar' : 'Activar' }}</button>
                                </div>
                                <div class="modal fade" id="modalEstado{{ $extra->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header {{ $extra->estado ? 'bg-danger' : 'bg-success' }} text-white">
                                                <h5 class="modal-title">{{ $extra->estado ? 'Desactivar Servicio' : 'Activar Servicio' }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">¿Está seguro que desea <strong>{{ $extra->estado ? 'desactivar' : 'activar' }}</strong> el servicio "{{$extra->nombre}}"?</div>
                                            <div class="modal-footer justify-content-center">
                                                <form action="{{ route('servicios_adicionales.update', $extra->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm {{ $extra->estado ? 'btn-danger' : 'btn-success' }}">Sí, {{ $extra->estado ? 'desactivar' : 'activar' }}</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                No hay servicios adicionales registrados.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        @if($extras->hasPages())
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Mostrando {{ $extras->firstItem() }} - {{ $extras->lastItem() }} de {{ $extras->total() }} servicios
                </small>
            </div>
        @endif
    </div>
@endsection
