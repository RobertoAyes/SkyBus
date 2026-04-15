@extends('layouts.layoutuser')

@section('title', 'Mis Consultas')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-headset me-2"></i> Mis Consultas
                </h2>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaConsulta">
                    <i class="fas fa-plus me-1"></i> Nueva consulta
                </button>
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

                {{-- FILTROS --}}
                <form method="GET" action="{{ url('/mis-solicitudes') }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda General</label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar por asunto o mensaje..."
                                       value="{{ request('buscar') }}">
                            </div>
                            <div class="col-md-5 d-flex align-items-end gap-2">
                                <button class="btn btn-primary flex-fill" type="submit" name="filtrar" value="1">
                                    <i class="fas fa-search me-2"></i>Buscar
                                </button>
                                <button class="btn btn-outline-primary flex-fill" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                                    <i class="fas fa-sliders-h me-2"></i>Filtros
                                </button>
                                @if(request()->hasAny(['buscar','fecha_inicio','fecha_fin']))
                                    <a href="{{ url('/mis-solicitudes') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="fas fa-times me-2"></i>Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- FILTROS ADICIONALES --}}
                    <div class="collapse {{ request()->hasAny(['fecha','respuesta']) ? 'show' : '' }}" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">Filtros Adicionales</h6>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    {{-- FECHA --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-primary me-1"></i> Fecha
                                        </label>
                                        <input type="date"
                                               name="fecha"
                                               class="form-control"
                                               value="{{ request('fecha') }}">
                                    </div>

                                    {{-- ESTADO RESPUESTA --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-reply text-primary me-1"></i> Respuesta
                                        </label>

                                        <select name="respuesta" class="form-control">
                                            <option value="">Todos</option>
                                            <option value="respondido" {{ request('respuesta')=='respondido' ? 'selected' : '' }}>
                                                Respondido
                                            </option>
                                            <option value="pendiente" {{ request('respuesta')=='pendiente' ? 'selected' : '' }}>
                                                Sin respuesta
                                            </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MOSTRAR REGISTROS --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold">Mostrar:</label>
                            <select name="per_page"
                                    class="form-select form-select-sm border-primary"
                                    style="width:90px;"
                                    onchange="this.form.submit()">
                                @foreach([5, 10, 25, 50] as $option)
                                    <option value="{{ $option }}" {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            <span>registros</span>
                        </div>
                        <small class="text-muted">Total: {{ $consultas->total() }} registros</small>
                    </div>
                </form>

                {{-- TABLA --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th style="width:60px;" class="text-center">#</th>
                            <th>Asunto</th>
                            <th>Mensaje</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Respuesta</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($consultas as $key => $consulta)
                            <tr>
                                <td class="text-center">{{ ($consultas->currentPage()-1)*$consultas->perPage() + $key + 1 }}</td>
                                <td>{{ $consulta->asunto }}</td>
                                <td>{{ $consulta->mensaje }}</td>
                                <td class="text-center">{{ $consulta->created_at->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    @if($consulta->respuesta_admin)
                                        <button class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#respuesta{{ $consulta->id }}">
                                            Ver respuesta
                                        </button>
                                    @else
                                        <span class="text-muted">Sin respuesta</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fas fa-headset fa-2x mb-2 d-block"></i>
                                    No has enviado ninguna consulta aún.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @foreach($consultas as $consulta)

                        <div class="modal fade" id="respuesta{{ $consulta->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header bg-success text-white">
                                        <h5 class="mb-0">Respuesta del soporte</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <strong>Tu consulta:</strong>
                                        <p class="mb-3">{{ $consulta->mensaje }}</p>

                                        <strong>Respuesta:</strong>

                                        <p style="background:#f0fdf4;padding:10px;border-radius:8px;">
                                            {{ $consulta->respuesta_admin }}
                                        </p>

                                        <small class="text-muted">
                                            Estado: {{ ucfirst($consulta->estado ?? 'pendiente') }}
                                        </small>

                                    </div>

                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
                <div class="modal fade" id="modalNuevaConsulta" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-headset me-2"></i> Nueva Consulta
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="POST" action="{{ route('soporte.enviar') }}">
                                @csrf

                                <div class="modal-body">

                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Nombre</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="nombre"
                                                   value="{{ auth()->user()->name }}"
                                                   required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Correo</label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="correo"
                                                   value="{{ auth()->user()->email }}"
                                                   required>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold">Asunto</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="asunto"
                                                   required>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold">Mensaje</label>
                                            <textarea class="form-control"
                                                      name="mensaje"
                                                      rows="5"
                                                      required></textarea>
                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-1"></i> Enviar
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                {{-- PAGINACIÓN --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $consultas->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $consultas->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $consultas->total() }}</span>
                        registros
                    </div>

                    @if($consultas->hasPages())
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $consultas->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $consultas->appends(request()->all())->previousPageUrl() }}">Anterior</a>
                                </li>
                                @for($page = 1; $page <= $consultas->lastPage(); $page++)
                                    <li class="page-item {{ $page == $consultas->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $consultas->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $consultas->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $consultas->appends(request()->all())->nextPageUrl() }}">Siguiente</a>
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

        tbody {
            min-height: 300px;
            display: table-row-group;
        }

        .table-responsive {
            min-height: 320px;
        }
    </style>
@endsection
