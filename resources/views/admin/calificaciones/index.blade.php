@extends('layouts.layoutadmin')

@section('title', 'Calificaciones de Choferes')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-sm border-0">


            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-comments me-2"></i>Comentarios de Usuarios
                </h2>
            </div>

            <div class="card-body">


                <form method="GET" action="{{ route('calificaciones.index') }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Búsqueda General
                        </label>

                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar por chofer, cliente o comentario..."
                                       value="{{ request('buscar') }}">
                            </div>

                            <div class="col-md-5 d-flex align-items-end gap-2">
                                <button class="btn btn-primary flex-fill">
                                    <i class="fas fa-search me-2"></i>Buscar
                                </button>

                                <button class="btn btn-outline-primary flex-fill" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                                    <i class="fas fa-sliders-h me-2"></i>Filtros
                                </button>

                                @if(request()->hasAny(['buscar','estrellas','fecha']))
                                    <a href="{{ route('calificaciones.index') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="fas fa-times me-2"></i>Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="collapse" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">Filtros Adicionales</h6>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-star text-warning me-1"></i> Estrellas
                                        </label>
                                        <select name="estrellas" class="form-select select2">
                                            <option value=""></option>
                                            @for($i=5;$i>=1;$i--)
                                                <option value="{{ $i }}" {{ request('estrellas')==$i?'selected':'' }}>
                                                    {{ $i }} estrellas
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-primary me-1"></i> Fecha
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
                                    class="form-select form-select-sm border-primary"
                                    style="width:90px;"
                                    onchange="this.form.submit()">

                                <option value="5"  {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>

                            </select>
                            <span>registros</span>
                        </div>
                    </div>

                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Chofer</th>
                            <th>Cliente</th>
                            <th class="text-center">Estrellas</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($comentarios as $key => $cal)

                            <tr>
                                <td>
                                    {{ ($comentarios->currentPage() - 1) * $comentarios->perPage() + $key + 1 }}
                                </td>

                                <td>{{ $cal->chofer_nombre ?? '—' }}</td>

                                <td>{{ $cal->usuario_nombre ?? '—' }}</td>

                                <td class="text-center">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="fas fa-star"
                                           style="color:#fbbf24;{{ $s>$cal->estrellas?'opacity:.2':'' }}">
                                        </i>
                                    @endfor

                                </td>

                                <td style="max-width:250px;">
                                    {{ $cal->comentario ?? '—' }}
                                </td>

                                <td>
                                    {{ $cal->created_at ? \Carbon\Carbon::parse($cal->created_at)->format('d/m/Y') : '—' }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-comments fa-2x mb-2 d-block"></i>
                                    No hay comentarios registrados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="d-flex justify-content-between align-items-center">

                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $comentarios->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $comentarios->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $comentarios->total() }}</span>
                        comentarios
                    </div>

                    @if($comentarios->hasPages())
                        <nav>
                            <ul class="pagination pagination-sm mb-0">

                                <li class="page-item {{ $comentarios->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link"
                                       href="{{ $comentarios->appends(request()->all())->previousPageUrl() }}">
                                        Anterior
                                    </a>
                                </li>

                                @for($page = 1; $page <= $comentarios->lastPage(); $page++)
                                    <li class="page-item {{ $page == $comentarios->currentPage() ? 'active' : '' }}">
                                        <a class="page-link"
                                           href="{{ $comentarios->appends(request()->all())->url($page) }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endfor

                                <li class="page-item {{ $comentarios->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link"
                                       href="{{ $comentarios->appends(request()->all())->nextPageUrl() }}">
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


    <style>
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
            border-color: #e5e7eb;
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Seleccionar...',
                allowClear: true,
            });
        });
    </script>

@endsection
