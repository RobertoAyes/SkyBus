@extends('layouts.layoutadmin')

@section('title', 'Servicios Adicionales')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-concierge-bell me-2"></i> Servicios Adicionales
                </h2>
                <a href="{{ route('servicios_adicionales.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Agregar
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
                        <button type="button" class="btn-close ms-auto"></button>
                    </div>
                @endif

                {{-- FILTROS --}}
                <form method="GET" action="{{ route('servicios_adicionales.index') }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda General</label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar servicio..."
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
                                @if(request()->hasAny(['buscar','estado']))
                                    <a href="{{ route('servicios_adicionales.index') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="fas fa-times me-2"></i>Limpiar
                                    </a>
                                @endif
                            </div>
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
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-1"></i> Estado
                                        </label>
                                        <select name="estado" class="form-select select2" data-placeholder="Todos">
                                            <option value=""></option>
                                            <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activos</option>
                                            <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivos</option>
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
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
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
                            <th>Descripción</th>
                            <th class="text-center">Imagen</th>
                            <th>Estado</th>
                            <th class="text-center">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($extras as $key => $extra)
                            <tr>
                                <td>{{ ($extras->currentPage() - 1) * $extras->perPage() + $key + 1 }}</td>
                                <td>{{ $extra->nombre }}</td>
                                <td>{{ $extra->descripcion }}</td>
                                <td class="text-center">
                                    @if($extra->imagen)
                                        <img src="{{ asset('storage/' . $extra->imagen) }}" class="rounded" style="height:60px; width:80px; object-fit:cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($extra->estado)
                                        <span class="badge bg-success" style="font-size:0.85rem;">Activo</span>
                                    @else
                                        <span class="badge bg-danger" style="font-size:0.85rem;">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm {{ $extra->estado ? 'btn-danger' : 'btn-success' }}" data-bs-toggle="modal" data-bs-target="#modalEstado{{ $extra->id }}">
                                            <strong>{{ $extra->estado ? 'Desactivar' : 'Activar' }}</strong>
                                        </button>
                                    </div>

                                    {{-- MODAL CONFIRMACION --}}
                                    <div class="modal fade" id="modalEstado{{ $extra->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header {{ $extra->estado ? 'bg-danger' : 'bg-success' }} text-white">
                                                    <h5 class="modal-title">{{ $extra->estado ? 'Desactivar Servicio' : 'Activar Servicio' }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    ¿Está seguro que desea <strong>{{ $extra->estado ? 'desactivar' : 'activar' }}</strong> el servicio "{{ $extra->nombre }}"?
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <form action="{{ route('servicios_adicionales.update', $extra->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm {{ $extra->estado ? 'btn-danger' : 'btn-success' }}">
                                                            Sí, {{ $extra->estado ? 'desactivar' : 'activar' }}
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-concierge-bell fa-2x mb-2 d-block"></i>
                                    No hay servicios registrados
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
        {{-- TABLA FIJA --}}
             .table {
                 table-layout: fixed;
                 width: 100%;
             }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').each(function () {
                $(this).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: $(this).data('placeholder') || 'Seleccionar...',
                    allowClear: true,
                });
            });
        });
    </script>


@endsection
