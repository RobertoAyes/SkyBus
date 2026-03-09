@extends('layouts.layoutchofer')

@section('title', 'Historial de Soporte Técnico')

@section('contenido')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-history me-2"></i>Historial de Soporte Técnico</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <tbody>
                @forelse($solicitudes as $solicitud)
                    <tr>
                        <td>{{ $solicitud->id }}</td>
                        <td>{{ $solicitud->titulo }}</td>
                        <td>{{ $solicitud->descripcion }}</td>
                        <td>
                        <span class="badge
                            {{ $solicitud->estado == 'pendiente' ? 'bg-warning' : ($solicitud->estado == 'en_proceso' ? 'bg-info' : 'bg-success') }}">
                            {{ ucfirst($solicitud->estado) }}
                        </span>
                        </td>
                        <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">No hay solicitudes registradas.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if($solicitudes->hasPages())
                <div class="mt-3">
                    {{ $solicitudes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
