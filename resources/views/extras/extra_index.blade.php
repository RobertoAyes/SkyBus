@extends('layouts.layoutuser')

@section('title', 'Lista de Servicios Adicionales')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-concierge-bell me-2"></i> Historial de Servicios Adicionales
                </h2>
                <a href="{{ route('servicios_reserva.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Agregar servicio
                </a>
            </div>

            <div class="card-body">

                {{-- ALERTAS --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        <strong class="me-2">Error:</strong> {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- SELECTOR DE REGISTROS POR PÁGINA --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form method="GET" action="{{ route('servicios_reserva.index') }}" id="perPageForm">
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold">Mostrar:</label>
                            <select name="perPage" class="form-select form-select-sm border-primary" style="width:90px;"
                                    onchange="document.getElementById('perPageForm').submit()">
                                @foreach([5, 10, 25, 50] as $option)
                                    <option value="{{ $option }}" {{ request('perPage', 5) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            <span>registros</span>
                        </div>
                    </form>
                    <small class="text-muted">
                        Total: {{ $extras->total() }} registros
                    </small>
                </div>

                {{-- TABLA --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Código de Reserva</th>
                            <th>Fecha</th>
                            <th>Extras</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($extras as $servicio)
                            <tr>
                                <td>{{ $extras->firstItem() + $loop->index }}</td>
                                <td>{{ $servicio->reserva->codigo_reserva ?? 'Sin reserva' }}</td>
                                <td>{{ $servicio->fecha ? date('d-m-Y', strtotime($servicio->fecha)) : 'N/D' }}</td>
                                <td>
                                    @if($servicio->extras && $servicio->extras->count() > 0)
                                        @foreach($servicio->extras as $extra)
                                            <span class="badge bg-primary me-1 mb-1" style="font-size:0.85rem;">
                                    {{ $extra->nombre }}
                                </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No hay extras asociados</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No hay servicios adicionales registrados.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $extras->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $extras->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $extras->total() }}</span>
                        registros
                    </div>

                    @if($extras->hasPages())
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $extras->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $extras->appends(request()->all())->previousPageUrl() }}">Anterior</a>
                                </li>
                                @for($page = 1; $page <= $extras->lastPage(); $page++)
                                    <li class="page-item {{ $page == $extras->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $extras->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $extras->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $extras->appends(request()->all())->nextPageUrl() }}">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- ESTILOS --}}
    <style>
        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            margin: 0 2px;
        }
        .pagination .page-link:hover { background-color: #1e63b8; color: #fff; }
        .pagination .page-item.active .page-link { background-color: #1e63b8; border-color: #1e63b8; color: #fff; }
        .pagination .page-item.disabled .page-link { color: #9ca3af; background: #f3f4f6; border-color: #e5e7eb; }

        .table { table-layout: fixed; width: 100%; }
    </style>
@endsection
