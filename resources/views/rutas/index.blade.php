@extends('layouts.layoutadmin')

@section('title', 'Panel Administrativo')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-route"></i> Rutas
                </h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaRuta">
                    <i class="fas fa-plus"></i> Nueva Ruta
                </button>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif


                <form method="GET" action="{{ route('rutas.index') }}" id="formFiltros">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda General</label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar por origen o destino..."
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
                                @if(request()->hasAny(['buscar','estado','distancia','duracion']))
                                    <a href="{{ route('rutas.index') }}" class="btn btn-outline-secondary flex-fill">
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
                                            <i class="fas fa-toggle-on text-success me-1"></i> Estado
                                        </label>
                                        <select name="estado" class="form-select select2" data-placeholder="Todos">
                                            <option value=""></option>
                                            <option value="activa"    {{ request('estado') == 'activa'    ? 'selected' : '' }}>Activa</option>
                                            <option value="bloqueada" {{ request('estado') == 'bloqueada' ? 'selected' : '' }}>Bloqueada</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-road text-primary me-1"></i> Distancia
                                        </label>
                                        <select name="distancia" class="form-select select2" data-placeholder="Todos">
                                            <option value=""></option>
                                            <option value="corta" {{ request('distancia') == 'corta' ? 'selected' : '' }}>Corta (menos de 50 km)</option>
                                            <option value="media" {{ request('distancia') == 'media' ? 'selected' : '' }}>Media (50 – 150 km)</option>
                                            <option value="larga" {{ request('distancia') == 'larga' ? 'selected' : '' }}>Larga (más de 150 km)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-clock text-warning me-1"></i> Duración
                                        </label>
                                        <select name="duracion" class="form-select select2" data-placeholder="Todos">
                                            <option value=""></option>
                                            <option value="rapida" {{ request('duracion') == 'rapida' ? 'selected' : '' }}>Rápida (menos de 60 min)</option>
                                            <option value="normal" {{ request('duracion') == 'normal' ? 'selected' : '' }}>Normal (60 – 180 min)</option>
                                            <option value="larga"  {{ request('duracion') == 'larga'  ? 'selected' : '' }}>Larga (más de 180 min)</option>
                                        </select>
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
                                <option value="5"  {{ request('per_page') == 5  ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <span>registros</span>
                        </div>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="tablaRutas">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Distancia</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rutas as $key => $ruta)
                            <tr>
                                <td>{{ ($rutas->currentPage() - 1) * $rutas->perPage() + $key + 1 }}</td>
                                <td>{{ $ruta->origen }}</td>
                                <td>{{ $ruta->destino }}</td>
                                <td>{{ $ruta->distancia }} km</td>
                                <td>{{ $ruta->duracion_estimada }} min</td>
                                <td>
                                    @if($ruta->estado)
                                        <span class="badge bg-success" style="font-size:0.85rem;">Activa</span>
                                    @else
                                        <span class="badge bg-danger" style="font-size:0.85rem;">Bloqueada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">


                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $ruta->id }}">
                                            <i class="fas fa-edit me-1"></i> Editar
                                        </button>


                                        <form action="{{ route('rutas.bloquear', $ruta->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            @if($ruta->estado)
                                                <button class="btn btn-sm btn-bloquear">
                                                    <i class="fas fa-ban me-1"></i> Bloquear
                                                </button>
                                            @else
                                                <button class="btn btn-success btn-sm btn-activar">
                                                    <i class="fas fa-check me-1"></i> Activar
                                                </button>
                                            @endif
                                        </form>

                                    </div>
                                </td>
                            </tr>


                            <div class="modal fade" id="modalNuevaRuta" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3" style="overflow:hidden;">
                                        <form action="{{ route('rutas.store') }}" method="POST">
                                            @csrf

                                            <div class="modal-header text-white border-0" style="background:#1e63b8; padding:1.25rem 1.5rem;">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                         style="width:34px; height:34px; background:rgba(255,255,255,0.2);">
                                                        <i class="fas fa-plus" style="font-size:13px;"></i>
                                                    </div>
                                                    <span style="font-size:15px; font-weight:500;">Nueva Ruta</span>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body" style="padding:1.5rem;">

                                                @if($errors->has('duplicado'))
                                                    <div class="alert alert-danger py-2 mb-3">
                                                        <i class="fas fa-exclamation-circle me-1"></i>
                                                        {{ $errors->first('duplicado') }}
                                                    </div>
                                                @endif

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label text-muted small mb-1">Origen</label>
                                                        <input type="text" name="origen" class="form-control"
                                                               value="{{ old('origen') }}"
                                                               onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                                                               placeholder="Ej: Tegucigalpa" required>
                                                        @error('origen') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label text-muted small mb-1">Destino</label>
                                                        <input type="text" name="destino" class="form-control"
                                                               value="{{ old('destino') }}"
                                                               onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                                                               placeholder="Ej: San Pedro Sula" required>
                                                        @error('destino') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label text-muted small mb-1">Distancia (km)</label>
                                                        <input type="number" step="0.01" name="distancia" class="form-control"
                                                               value="{{ old('distancia') }}" min="5"
                                                               placeholder="Ej: 250" required>
                                                        @error('distancia') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label text-muted small mb-1">Duración estimada (min)</label>
                                                        <input type="number" name="duracion_estimada" class="form-control"
                                                               value="{{ old('duracion_estimada') }}" min="15"
                                                               placeholder="Ej: 180" required>
                                                        @error('duracion_estimada') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer border-top d-flex justify-content-end gap-2" style="border-color:#e5e7eb !important; padding:1rem 1.5rem;">
                                                <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-2" data-bs-dismiss="modal" style="min-width:100px; justify-content:center;">
                                                    <i class="fas fa-times" style="font-size:12px;"></i> Cancelar
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-2" style="min-width:100px; justify-content:center;">
                                                    <i class="fas fa-save" style="font-size:12px;"></i> Guardar
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="editModal{{ $ruta->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3" style="overflow:hidden;">
                                        <form action="{{ route('rutas.update', $ruta->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header text-white border-0" style="background:#1e63b8; padding:1.25rem 1.5rem;">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                         style="width:34px; height:34px; background:rgba(255,255,255,0.2);">
                                                        <i class="fas fa-edit" style="font-size:13px;"></i>
                                                    </div>
                                                    <span style="font-size:15px; font-weight:500;">Editar Ruta</span>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body" style="padding:1.5rem;">

                                                @if($errors->has('duplicado'))
                                                    <div class="alert alert-danger py-2 mb-3">
                                                        <i class="fas fa-exclamation-circle me-1"></i>
                                                        {{ $errors->first('duplicado') }}
                                                    </div>
                                                @endif

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label text-muted small mb-1">Origen</label>
                                                        <input type="text" name="origen" class="form-control"
                                                               value="{{ old('origen', $ruta->origen) }}"
                                                               onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                                                               required>
                                                        @error('origen') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label text-muted small mb-1">Destino</label>
                                                        <input type="text" name="destino" class="form-control"
                                                               value="{{ old('destino', $ruta->destino) }}"
                                                               onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                                                               required>
                                                        @error('destino') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label text-muted small mb-1">Distancia (km)</label>
                                                        <input type="number" step="0.01" name="distancia" class="form-control"
                                                               value="{{ old('distancia', $ruta->distancia) }}" min="5" required>
                                                        @error('distancia') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">
                                                        </label>
                                                        <label class="form-label text-muted small mb-1">Duración estimada (min)</label>
                                                        <input type="number" name="duracion_estimada" class="form-control"
                                                               value="{{ old('duracion_estimada', $ruta->duracion_estimada) }}" min="15" required>
                                                        @error('duracion_estimada') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer border-top d-flex justify-content-end gap-2" style="border-color:#e5e7eb !important; padding:1rem 1.5rem;">
                                                <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-2" data-bs-dismiss="modal" style="min-width:100px; justify-content:center;">
                                                    <i class="fas fa-times" style="font-size:12px;"></i> Cancelar
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-2" style="min-width:100px; justify-content:center;">
                                                    <i class="fas fa-save" style="font-size:12px;"></i> Guardar
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-road fa-2x mb-2 d-block"></i>
                                    No hay rutas registradas
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $rutas->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $rutas->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $rutas->total() }}</span>
                        rutas
                    </div>

                    @if($rutas->hasPages())
                        <nav aria-label="Paginación de rutas">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $rutas->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $rutas->appends(request()->all())->previousPageUrl() }}">Anterior</a>
                                </li>
                                @for($page = 1; $page <= $rutas->lastPage(); $page++)
                                    <li class="page-item {{ $page == $rutas->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $rutas->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $rutas->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $rutas->appends(request()->all())->nextPageUrl() }}">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <style>
        .btn-bloquear {
            background-color: #f59e0b;
            border-color: #d97706;
            color: #fff;
            min-width: 100px;
        }
        .btn-bloquear:hover {
            background-color: #d97706;
            border-color: #b45309;
            color: #fff;
        }
        .btn-activar {
            min-width: 100px;
        }
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
