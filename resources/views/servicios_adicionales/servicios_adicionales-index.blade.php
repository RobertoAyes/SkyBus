@extends('layouts.layoutuser')

@section('title', 'Servicios Adicionales')

@section('contenido')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-history me-2"></i>Historial de Servicios Adicionales</h4>
            <a href="{{ route('servicios_adicionales.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Agregar servicios adicionales
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('error'))
                <div class="alert alert-danger m-2">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th class="text-center">Fecha</th>
                        <th>Código de Reserva</th>
                        <th>Almohada</th>
                        <th>Cobija</th>
                        <th>Orejeras</th>
                        <th>Snack</th>
                        <th>Refrescos</th>
                        <th>Café</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($extras as $extra)
                        <tr>
                            <td class="text-center">{{ date('d-m-Y', strtotime($extra->fecha)) }}</td>
                            <td>{{$extra->reserva->codigo_reserva}}</td>
                            <td>{{ $extra->almohada ? 'Sí' : 'No' }}</td>
                            <td>{{ $extra->manta ? 'Sí' : 'No' }}</td>
                            <td>{{ $extra->orejeras ? 'Sí' : 'No' }}</td>
                            <td>{{ $extra->snack ? 'Sí' : 'No' }}</td>
                            <td>{{ $extra->refrescos ? 'Sí' : 'No' }}</td>
                            <td>{{ $extra->cafe ? 'Sí' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                No tienes servicios adicionales registrados.
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
                    Mostrando {{ $extras->firstItem() }} - {{ $extras->lastItem() }} de {{ $extras->total() }} servicios adicionales
                </small>
            </div>
        @endif
    </div>
@endsection
