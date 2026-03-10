@extends('layouts.layoutadmin')

@section('title', 'Consultas de Soporte Técnico')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <!-- Encabezado -->
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-headset me-2"></i>Consultas de Chofer
                </h2>
            </div>

            <div class="card-body">

                <!-- Mensajes de sesión -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-triangle-exclamation me-2"></i>
                        <strong>¡Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                <!-- Buscador y filtros -->
                <form method="GET" action="{{ route('chofer.soporte.index') }}" class="mb-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">
                                <i class="fas fa-search text-primary me-2"></i>Búsqueda General
                            </label>
                            <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar por título o descripción"
                                       value="{{ request('buscar') }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button class="btn btn-primary flex-fill" type="submit">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                            <button class="btn btn-outline-primary flex-fill" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados"
                                    aria-expanded="false">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>
                            @if(request()->hasAny(['buscar','estado']))
                                <a href="{{ route('chofer.soporte.index') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="collapse" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-filter me-2"></i>Filtros Adicionales
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-2"></i>Estado
                                        </label>
                                        <select name="estado" class="form-select">
                                            <option value="">Todos</option>
                                            <option value="pendiente" {{ request('estado')=='pendiente' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="en_proceso" {{ request('estado')=='en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                            <option value="resuelto" {{ request('estado')=='resuelto' ? 'selected' : '' }}>Resuelto</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Tabla de solicitudes -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th class="text-center">Acciones</th>
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
                                    {{ $solicitud->estado == 'pendiente' ? 'bg-warning text-dark' : ($solicitud->estado == 'en_proceso' ? 'bg-info' : 'bg-success') }}">
                                    {{ ucfirst($solicitud->estado) }}
                                </span>
                                </td>
                                <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-info btn-sm w-100px" data-bs-toggle="modal" data-bs-target="#detalleModal{{ $solicitud->id }}">
                                            <i class="fas fa-eye me-1"></i>Ver
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detalle -->
                            <div class="modal fade" id="detalleModal{{ $solicitud->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content shadow-sm border-0 rounded-3">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-eye me-2"></i>Detalle Solicitud #{{ $solicitud->id }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Título:</strong> {{ $solicitud->titulo }}</p>
                                            <p><strong>Descripción:</strong> {{ $solicitud->descripcion }}</p>
                                            <p><strong>Estado:</strong> {{ ucfirst($solicitud->estado) }}</p>
                                            <p><strong>Fecha:</strong> {{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-headset fa-2x mb-2 d-block"></i>No hay solicitudes registradas
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $solicitudes->appends(request()->all())->links('vendor.pagination.bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>

    <style>
        .w-100px { width: 110px !important; }
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
