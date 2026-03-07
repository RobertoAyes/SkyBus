@extends('layouts.layoutuser')

@section('title', 'Lista de Servicios Adicionales')

@section('contenido')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-list me-2"></i>Lista de Servicios Adicionales por Reserva
            </h4>
            <a href="{{ route('servicios_reserva.create') }}" class="btn btn-light btn-sm">
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
                        <th>Código de Reserva</th>
                        <th>Fecha de adición de servicios</th>
                        <th>Extras</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($servicios_extras as $servicio)
                        <tr>
                            <td>{{ $servicio->reserva->codigo_reserva ?? 'Sin reserva' }}</td>
                            <td>{{ date('d-m-Y', strtotime($servicio->fecha)) ?? 'N/D' }}</td>
                            <td>
                                <div>
                                    @forelse($servicio->extras as $extra)
                                        <span class="badge bg-primary me-1 mb-1">{{ $extra->nombre ?? 'N/D' }}</span>
                                    @empty
                                        <span class="text-muted">No hay extras asociados</span>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">
                                No hay servicios adicionales registrados.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        @if($servicios_extras->hasPages())
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Mostrando {{ $servicios_extras->firstItem() }} - {{ $servicios_extras->lastItem() }} de {{ $servicios_extras->total() }} registros
                </small>
            </div>
        @endif
    </div>
@endsection
