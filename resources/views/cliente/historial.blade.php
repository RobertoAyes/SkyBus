@extends('layouts.layoutuser')

@section('title', 'Historial de Viajes')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-history me-2"></i> Historial de Viajes
                </h2>
                <a href="{{ route('cliente.reserva.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Nueva Reserva
                </a>
            </div>

            <div class="card-body">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        <strong class="me-2">Error:</strong> {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- TABLA DE RESERVAS --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th class="text-center">Fecha Reserva</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th class="text-center">Salida</th>
                            <th class="text-center">Llegada</th>
                            <th class="text-center">Asiento</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reservas as $reserva)
                            <tr>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y H:i') }}
                                </td>
                                <td>{{ $reserva->viaje->origen->nombre ?? '-' }}</td>
                                <td>{{ $reserva->viaje->destino->nombre ?? '-' }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    {{ $reserva->viaje->fecha_llegada
                                        ? \Carbon\Carbon::parse($reserva->viaje->fecha_llegada)->format('d/m/Y H:i')
                                        : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $reserva->asiento ? '#'.$reserva->asiento->numero_asiento : '-' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge
                                        {{ $reserva->estado === 'confirmada' ? 'bg-success' :
                                           ($reserva->estado === 'cancelada' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($reserva->estado) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($reserva->estado === 'confirmada' && !$reserva->viaje->calificacion)
                                        <a href="{{ route('calificacion.create', $reserva->id) }}" class="btn btn-warning btn-sm me-1">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <a href="{{ route('puntos.create', $reserva->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-coins"></i>
                                        </a>
                                    @elseif($reserva->estado === 'confirmada' && $reserva->viaje->calificacion)
                                        <span class="text-success fw-bold">Calificado</span>
                                        <a href="{{ route('puntos.create', $reserva->id) }}" class="btn btn-info btn-sm ms-2">
                                            <i class="fas fa-coins"></i> Registrar
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                    No tienes reservas realizadas.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- PAGINACIÓN --}}
            @if($reservas->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $reservas->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $reservas->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $reservas->total() }}</span>
                        registros
                    </div>

                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item {{ $reservas->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $reservas->appends(request()->all())->previousPageUrl() }}">Anterior</a>
                            </li>
                            @for($page = 1; $page <= $reservas->lastPage(); $page++)
                                <li class="page-item {{ $page == $reservas->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $reservas->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $reservas->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $reservas->appends(request()->all())->nextPageUrl() }}">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif

        </div>
    </div>

    <style>
        .table { table-layout: fixed; width: 100%; }
        tbody { min-height: 300px; display: table-row-group; }
        .table-responsive { min-height: 320px; }
        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            margin: 0 2px;
        }
        .pagination .page-link:hover { background-color: #1e63b8; color: #fff; }
        .pagination .page-item.active .page-link { background-color: #1e63b8; border-color: #1e63b8; color: #fff; }
        .pagination .page-item.disabled .page-link { color: #9ca3af; background: #f3f4f6; border-color: #e5e7eb; }
    </style>
@endsection
