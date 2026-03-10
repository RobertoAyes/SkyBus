@extends('layouts.layoutadmin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 style="margin:0; color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-tools me-2"></i>Solicitudes de Soporte Técnico
                </h2>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-primary">
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th class="text-center">Ver</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($solicitudes->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-tools fa-2x mb-2 d-block"></i>
                                    No hay solicitudes de soporte enviadas por los choferes
                                </td>
                            </tr>
                        @else
                            @foreach($solicitudes as $solicitud)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $solicitud->titulo }}</span></td>
                                    <td>{{ Str::limit($solicitud->descripcion, 60) }}</td>
                                    <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#soporteModal{{ $solicitud->id }}">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="soporteModal{{ $solicitud->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-tools me-2"></i>Detalle de la Solicitud
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Título:</strong></p>
                                                <p>{{ $solicitud->titulo }}</p>
                                                <hr>
                                                <p><strong>Descripción:</strong></p>
                                                <p>{{ $solicitud->descripcion }}</p>
                                                <hr>
                                                <p><strong>Fecha enviada:</strong> {{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $solicitudes->links() }}</div>
            </div>
        </div>
    </div>
@endsection
