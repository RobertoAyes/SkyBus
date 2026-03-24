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

                {{-- FILTROS Y BUSCADOR --}}
                <form method="GET" action="{{ route('servicios_reserva.index') }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda General</label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar por código de reserva o extras..."
                                       value="{{ request('buscar') }}">
                            </div>
                            <div class="col-md-5 d-flex align-items-end gap-2">
                                <button class="btn btn-primary flex-fill" type="submit">
                                    <i class="fas fa-search me-2"></i>Buscar
                                </button>
                                <button class="btn btn-outline-primary flex-fill" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                                    <i class="fas fa-sliders-h me-2"></i>Filtros
                                </button>
                                @if(request()->hasAny(['buscar','fecha_desde','fecha_hasta']))
                                    <a href="{{ route('servicios_reserva.index') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="fas fa-times me-2"></i>Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- FILTROS AVANZADOS (FECHAS) --}}
                    <div class="collapse {{ request()->hasAny(['fecha_desde','fecha_hasta']) ? 'show' : '' }}" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">Filtros Adicionales</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-primary me-1"></i> Fecha inicio
                                        </label>
                                        <input type="date" name="fecha_desde" class="form-control"
                                               value="{{ request('fecha_desde') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-primary me-1"></i> Fecha fin
                                        </label>
                                        <input type="date" name="fecha_hasta" class="form-control"
                                               value="{{ request('fecha_hasta') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MOSTRAR REGISTROS --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold">Mostrar:</label>
                            <select name="per_page" class="form-select form-select-sm border-primary"
                                    style="width:90px;" onchange="this.form.submit()">
                                @foreach([5,10,25,50] as $option)
                                    <option value="{{ $option }}" {{ request('per_page',5) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            <span>registros</span>
                        </div>
                        <small class="text-muted">Total: {{ $extras->total() }} registros</small>
                    </div>
                </form>

                {{-- TABLA --}}
                <div class="table-responsive" style="min-height:320px;">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th style="width:60px;" class="text-center">#</th>
                            <th>Código de Reserva</th>
                            <th class="text-center">Fecha</th>
                            <th>Extras</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($extras as $key => $servicio)
                            <tr>
                                <td class="text-center">{{ ($extras->currentPage()-1)*$extras->perPage() + $key + 1 }}</td>
                                <td>{{ $servicio->reserva->codigo_reserva ?? 'Sin reserva' }}</td>
                                <td class="text-center">{{ $servicio->fecha ? date('d-m-Y', strtotime($servicio->fecha)) : 'N/D' }}</td>
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
                                <td colspan="4" class="text-center text-muted py-5">
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
        tbody { min-height: 300px; display: table-row-group; }
        .table-responsive { min-height: 320px; }
    </style>
@endsection
