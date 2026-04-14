@extends('layouts.layoutadmin')

@section('title', 'Consultas de Choferes')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-envelope me-2"></i>Solicitudes soporte chofer
                </h2>
            </div>

            <div class="card-body">

                {{-- ALERTA --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- FORM --}}
                <form method="GET" action="{{ route('admin.soportes') }}">

                    {{-- BUSQUEDA --}}
                    <div class="row g-3 mb-3">
                        <label class="form-label fw-bold">
                            </i> Búsqueda General
                        </label>
                        <div class="col-md-7">
                            <input type="text" name="buscar" class="form-control"
                                   placeholder="Buscar por título o descripción"
                                   value="{{ request('buscar') }}">
                        </div>

                        <div class="col-md-5 d-flex gap-2">
                            <button class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>

                            <button class="btn btn-outline-primary flex-fill"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#filtrosAvanzados">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>

                            @if(request()->hasAny(['buscar','estado','fecha']))
                                <a href="{{ route('admin.soportes') }}" class="btn btn-outline-secondary flex-fill">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- FILTROS AVANZADOS --}}
                    <div class="collapse" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">Filtros Adicionales</h6>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    {{-- ESTADO --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-1"></i>Estado
                                        </label>
                                        <select name="estado" class="form-select">
                                            <option value="">Todos</option>
                                            <option value="pendiente" {{ request('estado')=='pendiente'?'selected':'' }}>Pendiente</option>
                                            <option value="en_proceso" {{ request('estado')=='en_proceso'?'selected':'' }}>En proceso</option>
                                            <option value="resuelto" {{ request('estado')=='resuelto'?'selected':'' }}>Resuelto</option>
                                        </select>
                                    </div>

                                    {{-- FECHA --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-primary me-1"></i>Fecha
                                        </label>
                                        <input type="date" name="fecha" class="form-control"
                                               value="{{ request('fecha') }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MOSTRAR REGISTROS --}}
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <label class="mb-0 fw-semibold">Mostrar:</label>
                        <select name="per_page" class="form-select"
                                style="width:90px;"
                                onchange="this.form.submit()">
                            <option value="5"  {{ request('per_page')==5?'selected':'' }}>5</option>
                            <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
                            <option value="25" {{ request('per_page')==25?'selected':'' }}>25</option>
                            <option value="50" {{ request('per_page')==50?'selected':'' }}>50</option>
                        </select>
                        <span>registros</span>
                    </div>

                </form>

                {{-- TABLA --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Chofer</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($solicitudes as $solicitud)
                            <tr>
                                <td>{{ ($solicitudes->currentPage()-1)*$solicitudes->perPage()+$loop->iteration }}</td>

                                <td>{{ $solicitud->titulo }}</td>

                                <td>{{ $solicitud->chofer->name ?? 'Sin chofer' }}</td>

                                <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>

                                <td>
                                    @if($solicitud->estado=='pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($solicitud->estado=='en_proceso')
                                        <span class="badge bg-info text-dark">En Proceso</span>
                                    @else
                                        <span class="badge bg-success">Resuelto</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <button class="btn btn-info btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalVer{{ $solicitud->id }}">
                                        <i class="fas fa-eye me-1"></i> Ver
                                    </button>

                                    <button class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#responderModal{{ $solicitud->id }}">
                                        <i class="fas fa-reply me-1"></i>Responder
                                    </button>
                                </td>
                            </tr>

                            {{-- MODAL VER --}}
                            <div class="modal fade" id="modalVer{{ $solicitud->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3">

                                        <div class="modal-header text-white" style="background:#1e63b8;">
                                            <h5 class="mb-0">
                                                <i class="fas fa-eye me-2"></i>Detalle de solicitud
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p><strong>Chofer:</strong> {{ $solicitud->chofer->name ?? 'Sin chofer' }}</p>
                                            <p><strong>Título:</strong> {{ $solicitud->titulo }}</p>
                                            <p><strong>Descripción:</strong> {{ $solicitud->descripcion }}</p>
                                            <p><strong>Fecha:</strong> {{ $solicitud->created_at->format('d/m/Y') }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- MODAL RESPONDER (IMPORTANTE: AQUÍ ESTÁ EL FIX) --}}
                            <div class="modal fade" id="responderModal{{ $solicitud->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3">

                                        <form action="{{ route('consultas.responderConsulta', $solicitud->id) }}" method="POST">
                                            @csrf

                                            <div class="modal-header text-white" style="background:#1e63b8;">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-reply me-2"></i>Responder solicitud
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Mensaje del chofer</label>
                                                    <textarea class="form-control" rows="4" readonly>{{ $solicitud->mensaje ?? $solicitud->descripcion }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Respuesta</label>
                                                    <textarea name="respuesta_admin" rows="5"
                                                              class="form-control"
                                                              required>{{ $solicitud->respuesta_admin }}</textarea>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-paper-plane me-1"></i>Enviar
                                                </button>

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Cancelar
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No hay solicitudes
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                <div class="d-flex justify-content-between align-items-center">

                    <div class="text-muted small">
                        Mostrando {{ $solicitudes->firstItem() ?? 0 }}
                        – {{ $solicitudes->lastItem() ?? 0 }}
                        de {{ $solicitudes->total() }}
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted small">
                            Mostrando
                            <span class="fw-semibold">{{ $solicitudes->firstItem() ?? 0 }}</span>
                            –
                            <span class="fw-semibold">{{ $solicitudes->lastItem() ?? 0 }}</span>
                            de
                            <span class="fw-semibold">{{ $solicitudes->total() }}</span>
                            solicitudes
                        </div>

                        @if($solicitudes->hasPages())
                            <nav>
                                <ul class="pagination pagination-sm mb-0">

                                    {{-- ANTERIOR --}}
                                    <li class="page-item {{ $solicitudes->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                           href="{{ $solicitudes->appends(request()->all())->previousPageUrl() }}">
                                            Anterior
                                        </a>
                                    </li>

                                    {{-- NUMEROS --}}
                                    @for($page = 1; $page <= $solicitudes->lastPage(); $page++)
                                        <li class="page-item {{ $page == $solicitudes->currentPage() ? 'active' : '' }}">
                                            <a class="page-link"
                                               href="{{ $solicitudes->appends(request()->all())->url($page) }}">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endfor

                                    {{-- SIGUIENTE --}}
                                    <li class="page-item {{ $solicitudes->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link"
                                           href="{{ $solicitudes->appends(request()->all())->nextPageUrl() }}">
                                            Siguiente
                                        </a>
                                    </li>

                                </ul>
                            </nav>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
