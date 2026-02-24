@extends('layouts.layoutchofer')

@section('title', 'Confirmar salida y llegada')

@section('contenido')
    <div class="chofer-wrapper">
        <div class="page-inner">


            <div class="greeting-banner">
                <div class="greeting-text">
                    <div class="greeting-title">Confirmar salida / llegada</div>
                    <div class="greeting-sub">Gestiona tus viajes y marca su estado en tiempo real.</div>
                </div>
                <div class="greeting-icon-wrap">
                    <i class="fas fa-bus"></i>
                </div>
            </div>


            @if(!$itinerarios->isEmpty())
                <div class="summary-chips">
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-play"></i></div>
                        <div>
                            <div class="chip-value">{{ $itinerarios->where('estado_viaje', 'Pendiente')->count() }}</div>
                            <div class="chip-label">Pendientes</div>
                        </div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-road"></i></div>
                        <div>
                            <div class="chip-value">{{ $itinerarios->where('estado_viaje', 'En ruta')->count() }}</div>
                            <div class="chip-label">En ruta</div>
                        </div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-flag-checkered"></i></div>
                        <div>
                            <div class="chip-value">{{ $itinerarios->where('estado_viaje', 'Finalizado')->count() }}</div>
                            <div class="chip-label">Finalizados</div>
                        </div>
                    </div>
                </div>
            @endif


            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-primary">
                    <tr>
                        <th>Ruta</th>
                        <th>Fecha</th>
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
                                <span class="fw-bold">{{ $itinerario->ruta->origen ?? 'N/A' }}</span>
                                <i class="fas fa-arrow-right mx-2 text-primary"></i>
                                <span class="fw-bold">{{ $itinerario->ruta->destino ?? 'N/A' }}</span>
                            </td>

                            <td>{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y') : '-' }}</td>
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
                            <td colspan="6" class="text-center text-muted py-4">
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
    </div>

    <style>

        .chofer-wrapper { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f7ff; padding: 2rem; }
        .greeting-banner {
            background: linear-gradient(135deg,#3a9fd6 0%,#5bb8e8 100%);
            border-radius: 20px; padding: 1.8rem 2rem; margin-bottom: 1.8rem;
            color: #fff; display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 8px 28px rgba(58,159,214,0.25);
        }
        .greeting-title { font-weight: 800; font-size: 1.5rem; }
        .greeting-sub { font-size: 0.9rem; opacity: 0.85; }
        .greeting-icon-wrap { font-size: 1.6rem; }
        .summary-chips { display: flex; gap: 1rem; margin-bottom: 1.8rem; flex-wrap: wrap; }
        .chip { background: #fff; border: 1px solid #d0e8f8; border-radius: 14px; padding: 0.8rem 1rem; display: flex; align-items: center; gap: 0.7rem; min-width: 120px; }
        .chip-icon { background: #e0f3fc; color: #3a9fd6; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .chip-value { font-family: 'JetBrains Mono', monospace; font-weight: 800; font-size: 1.2rem; }
        .chip-label { font-size: 0.7rem; color: #7aaac8; text-transform: uppercase; }

        .table-hover tbody tr:hover { background-color: #e3f2fd; }
        .badge { font-size: 0.85rem; padding: 0.45em 0.7em; border-radius: 0.375rem; }
        .w-100px { width: 110px !important; }
        .pagination .page-link { color: #1e63b8; border-radius: 0.375rem; border: 1px solid #1e63b8; margin: 0 2px; }
        .pagination .page-link:hover { background-color: #1e63b8; color: #fff; }
        .pagination .page-item.active .page-link { background-color: #1e63b8; border-color: #1e63b8; color: #fff; }
    </style>
@endsection
