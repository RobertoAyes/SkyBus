@extends('layouts.layoutchofer')

@section('title', 'Confirmar salida y llegada')

@section('contenido')
    <div class="container mt-4">
        <h2 class="mb-4" style="color:#1e63b8; font-weight:600;">
            <i class="fas fa-bus me-2"></i>Confirmar salida / llegada
        </h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-circle-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-triangle-exclamation me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th>Ruta</th>
                    <th>Hora Salida</th>
                    <th>Hora Llegada</th>
                    <th>Estado</th>
                    <th class="text-center">Acción</th>
                </tr>
                </thead>
                <tbody>
                @forelse($itinerarios as $itinerario)
                    <tr>
                        <td>
                            <span class="fw-bold">{{ $itinerario->ruta->origen->nombre ?? 'N/A' }}</span>
                            <i class="fas fa-arrow-right mx-2 text-primary"></i>
                            <span class="fw-bold">{{ $itinerario->ruta->destino->nombre ?? 'N/A' }}</span>
                        </td>
                        <td>{{ $itinerario->hora_salida ? $itinerario->hora_salida->format('H:i:s') : '-' }}</td>
                        <td>{{ $itinerario->hora_llegada ? $itinerario->hora_llegada->format('H:i:s') : '-' }}</td>
                        <td>
                            <span class="badge
                                {{ $itinerario->estado_viaje=='Finalizado' ? 'bg-success' : ($itinerario->estado_viaje=='En ruta' ? 'bg-info text-white' : 'bg-warning text-dark') }}
                                text-uppercase">
                                {{ $itinerario->estado_viaje ?? 'Pendiente' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($itinerario->estado_viaje == 'Pendiente')
                                <form action="{{ route('viaje.salida', $itinerario->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary btn-sm w-100px">
                                        <i class="fas fa-play me-1"></i>Salida
                                    </button>
                                </form>
                            @elseif($itinerario->estado_viaje == 'En ruta')
                                <form action="{{ route('viaje.llegada', $itinerario->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm w-100px">
                                        <i class="fas fa-flag-checkered me-1"></i>Llegada
                                    </button>
                                </form>
                            @else
                                <span class="text-success fw-bold">Viaje finalizado</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-bus fa-2x mb-2 d-block"></i>No tienes viajes asignados
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $itinerarios->appends(request()->all())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <style>
        .w-100px { width: 110px !important; }

        .table-hover tbody tr:hover {
            background-color: #e3f2fd;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.45em 0.7em;
            border-radius: 0.375rem;
        }

        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #1e63b8;
            margin: 0 2px;
        }

        .pagination .page-link:hover {
            background-color: #1e63b8;
            color: #fff;
        }

        .pagination .page-item.active .page-link {
            background-color: #1e63b8;
            border-color: #1e63b8;
            color: #fff;
        }
    </style>
@endsection
