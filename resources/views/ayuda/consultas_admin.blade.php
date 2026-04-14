@extends('layouts.layoutadmin')

@section('title', 'Consultas de Usuarios')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-envelope me-2"></i>Consultas de Usuarios
                </h2>
            </div>

            <div class="card-body">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
                        <i class="fas fa-triangle-exclamation me-2"></i>
                        <strong class="me-2">¡Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- FORMULARIO --}}
                <form method="GET" action="{{ route('consultas.listar') }}">

                    {{-- BUSQUEDA --}}
                    <div class="row g-3 mb-3">
                        <label class="form-label fw-bold">
                            </i> Búsqueda General
                        </label>
                        <div class="col-md-8">
                            <input type="text" name="buscar" class="form-control"
                                   placeholder="Buscar por nombre o asunto"
                                   value="{{ request('buscar') }}">
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>

                            <button class="btn btn-outline-primary flex-fill"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#filtrosAvanzados">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>

                            @if(request()->hasAny(['buscar','estado']))
                                <a href="{{ route('consultas.listar') }}" class="btn btn-outline-secondary flex-fill">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- FILTROS --}}
                    <div class="collapse" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">

                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-filter me-2"></i>Filtros Adicionales
                                </h6>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    {{-- ESTADO --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-1"></i>Estado
                                        </label>
                                        <select name="estado" class="form-select">
                                            <option value="">Todos</option>
                                            <option value="Pendiente" {{ request('estado')=='Pendiente'?'selected':'' }}>Pendiente</option>
                                            <option value="Respondida" {{ request('estado')=='Respondida'?'selected':'' }}>Respondida</option>
                                        </select>
                                    </div>

                                    {{-- FECHA --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-primary me-1"></i>Fecha de consulta
                                        </label>
                                        <input type="date" name="fecha" class="form-control"
                                               value="{{ request('fecha') }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold">Mostrar:</label>

                            <select name="per_page"
                                    class="form-select form-select-sm"
                                    style="width:90px;"
                                    onchange="this.form.submit()">

                                <option value="5"  {{ request('per_page')==5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page')==10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page')==25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page')==50 ? 'selected' : '' }}>50</option>

                            </select>

                            <span>registros</span>
                        </div>

                    </div>
                </form>


                {{-- TABLA --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Asunto</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($consultas as $key => $consulta)
                            <tr>

                                {{-- NUMERACION --}}
                                <td>
                                    {{ ($consultas->currentPage() - 1) * $consultas->perPage() + $key + 1 }}
                                </td>

                                <td>{{ $consulta->nombre_completo }}</td>
                                <td>{{ $consulta->asunto }}</td>
                                <td>{{ $consulta->created_at->format('d/m/Y H:i') }}</td>

                                <td>
                                <span class="badge {{ $consulta->estado=='Respondida' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $consulta->estado ?? 'Pendiente' }}
                                </span>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-info btn-sm w-100px"
                                                data-bs-toggle="modal"
                                                data-bs-target="#detalleModal{{ $consulta->id }}">
                                            <i class="fas fa-eye me-1"></i>Ver
                                        </button>

                                        <button class="btn btn-success btn-sm w-100px"
                                                data-bs-toggle="modal"
                                                data-bs-target="#responderModal{{ $consulta->id }}">
                                            <i class="fas fa-reply me-1"></i>Responder
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL VER --}}
                            <div class="modal fade" id="detalleModal{{ $consulta->id }}">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3">

                                        <div class="modal-header text-white" style="background:#1e63b8;">
                                            <h5 class="mb-0">
                                                <i class="fas fa-eye me-2"></i>Detalle de consulta
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p><strong>Nombre:</strong> {{ $consulta->nombre_completo }}</p>
                                            <p><strong>Correo:</strong> {{ $consulta->correo }}</p>
                                            <p><strong>Asunto:</strong> {{ $consulta->asunto }}</p>
                                            <p><strong>Mensaje:</strong> {{ $consulta->mensaje }}</p>

                                            <p><strong>Estado:</strong>
                                                <span class="badge {{ $consulta->estado=='Respondida' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $consulta->estado ?? 'Pendiente' }}
                                            </span>
                                            </p>

                                            @if($consulta->respuesta_admin)
                                                <hr>
                                                <p><strong>Respuesta:</strong> {{ $consulta->respuesta_admin }}</p>
                                            @endif
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                                Cerrar
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- MODAL RESPONDER --}}
                            <div class="modal fade" id="responderModal{{ $consulta->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3">

                                        <form action="{{ route('consultas.responder', $consulta->id) }}" method="POST">
                                            @csrf

                                            <div class="modal-header text-white" style="background:#1e63b8;">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-reply me-2"></i>Responder
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                            <textarea name="respuesta_admin" rows="5"
                                                      class="form-control"
                                                      required>{{ $consulta->respuesta_admin }}</textarea>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Enviar
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
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
                                    No hay consultas registradas
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACION --}}
                <div class="d-flex justify-content-between align-items-center mt-3">

                    <div class="text-muted small">
                        Mostrando
                        <strong>{{ $consultas->firstItem() ?? 0 }}</strong>
                        –
                        <strong>{{ $consultas->lastItem() ?? 0 }}</strong>
                        de
                        <strong>{{ $consultas->total() }}</strong>
                    </div>

                    @if($consultas->hasPages())
                        <ul class="pagination pagination-sm mb-0">

                            <li class="page-item {{ $consultas->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link"
                                   href="{{ $consultas->appends(request()->all())->previousPageUrl() }}">
                                    Anterior
                                </a>
                            </li>

                            @for($i = 1; $i <= $consultas->lastPage(); $i++)
                                <li class="page-item {{ $i == $consultas->currentPage() ? 'active' : '' }}">
                                    <a class="page-link"
                                       href="{{ $consultas->appends(request()->all())->url($i) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            <li class="page-item {{ $consultas->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link"
                                   href="{{ $consultas->appends(request()->all())->nextPageUrl() }}">
                                    Siguiente
                                </a>
                            </li>

                        </ul>
                    @endif

                </div>

            </div>
        </div>
    </div>

    <style>
        .w-100px { width: 110px !important; }

        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
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

        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
            background: #f3f4f6;
        }
    </style>

@endsection
