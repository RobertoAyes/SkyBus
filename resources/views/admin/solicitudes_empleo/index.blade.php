@extends('layouts.layoutadmin')

@section('title', 'Solicitudes de Empleo')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-file-alt me-2"></i>Solicitudes de Empleo
                </h2>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2"> ¡Éxito! </strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="GET" action="{{ route('admin.solicitudes.empleo') }}" id="formFiltros">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda General</label>

                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <input type="text" name="puesto" class="form-control"
                                           placeholder="Buscar por nombre o puesto..."
                                           value="{{ request('puesto') }}">
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-items-end gap-2">
                                <button class="btn btn-primary flex-fill" type="submit">
                                    <i class="fas fa-search me-2"></i>Buscar
                                </button>
                                <button class="btn btn-outline-primary flex-fill" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                                    <i class="fas fa-sliders-h me-2"></i>Filtros
                                </button>
                                @if(request()->hasAny(['puesto','estado']))
                                    <a href="{{ route('admin.solicitudes.empleo') }}" class="btn btn-outline-secondary flex-fill">
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
                                            <option value="pendiente"  {{ request('estado') == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                                            <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                            <option value="atendida"   {{ request('estado') == 'atendida'   ? 'selected' : '' }}>Atendida</option>
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
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Contacto</th>
                            <th>Puesto</th>
                            <th>Estado</th>
                            <th>CV</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($solicitudes as $key => $solicitud)
                            @php $estado = strtolower($solicitud->estado ?? 'pendiente'); @endphp
                            <tr>
                                <td>{{ ($solicitudes->currentPage() - 1) * $solicitudes->perPage() + $key + 1 }}</td>
                                <td>{{ $solicitud->nombre_completo }}</td>
                                <td>{{ $solicitud->contacto }}</td>
                                <td>{{ $solicitud->puesto_deseado }}</td>
                                <td>
                                    @if($estado == 'pendiente')
                                        <span class="badge bg-warning text-dark" style="font-size:0.85rem;">Pendiente</span>
                                    @elseif($estado == 'en_proceso')
                                        <span class="badge bg-info text-dark" style="font-size:0.85rem;">En Proceso</span>
                                    @elseif($estado == 'atendida')
                                        <span class="badge bg-success" style="font-size:0.85rem;">Atendida</span>
                                    @endif
                                </td>
                                <td>
                                    @if($solicitud->cv)
                                        <a href="{{ asset('storage/' . $solicitud->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-pdf me-1"></i> Ver CV
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalVer{{ $solicitud->id }}">
                                        <i class="fas fa-eye me-1"></i> Ver
                                    </button>
                                </td>
                            </tr>


                            <div class="modal fade" id="modalVer{{ $solicitud->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3" style="overflow:hidden;">

                                        <div class="modal-header text-white border-0" style="background:#1e63b8; padding:1.25rem 1.5rem;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width:34px; height:34px; background:rgba(255,255,255,0.2);">
                                                    <i class="fas fa-eye" style="font-size:13px;"></i>
                                                </div>
                                                <span class="fw-500" style="font-size:15px;">Detalle de la solicitud</span>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body" style="padding:1.5rem;">


                                            <div class="d-flex align-items-center gap-3 pb-3 mb-3" style="border-bottom:0.5px solid #e5e7eb;">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-500"
                                                     style="width:48px; height:48px; background:#e6f1fb; color:#1e63b8; font-size:15px; flex-shrink:0;">
                                                    {{ strtoupper(substr($solicitud->nombre_completo ?? 'SC', 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-500" style="font-size:15px;">{{ $solicitud->nombre_completo }}</p>
                                                    <p class="mb-0 text-muted" style="font-size:12px;">{{ $solicitud->contacto }}</p>
                                                </div>
                                                <div class="ms-auto text-end">
                                                    <p class="mb-1 text-muted" style="font-size:11px;">
                                                        {{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y') }}
                                                    </p>
                                                    @if($estado == 'pendiente')
                                                        <span class="badge rounded-pill" style="background:#fff3cd; color:#856404; font-size:11px; padding:5px 12px;">Pendiente</span>
                                                    @elseif($estado == 'en_proceso')
                                                        <span class="badge rounded-pill" style="background:#cff4fc; color:#055160; font-size:11px; padding:5px 12px;">En Proceso</span>
                                                    @elseif($estado == 'atendida')
                                                        <span class="badge rounded-pill" style="background:#d1fae5; color:#065f46; font-size:11px; padding:5px 12px;">Atendida</span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                        <p class="mb-1 text-uppercase text-muted" style="font-size:11px; letter-spacing:0.05em;">Puesto deseado</p>
                                                        <p class="mb-0 fw-500" style="font-size:14px;">{{ $solicitud->puesto_deseado ?? '—' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                        <p class="mb-1 text-uppercase text-muted" style="font-size:11px; letter-spacing:0.05em;">CV adjunto</p>
                                                        <p class="mb-0" style="font-size:14px;">
                                                            @if($solicitud->cv)
                                                                <a href="{{ asset('storage/' . $solicitud->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-file-pdf me-1"></i> Ver CV
                                                                </a>
                                                            @else
                                                                <span class="text-muted">No adjunto</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                <p class="mb-1 text-uppercase text-muted" style="font-size:11px; letter-spacing:0.05em;">Experiencia laboral</p>
                                                <p class="mb-0" style="font-size:13px; line-height:1.6;">{{ $solicitud->experiencia_laboral ?? '—' }}</p>
                                            </div>

                                        </div>

                                        <div class="modal-footer border-top" style="border-color:#e5e7eb !important; padding:1rem 1.5rem;">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i> Cerrar
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                                    No hay solicitudes registradas
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $solicitudes->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $solicitudes->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $solicitudes->total() }}</span>
                        solicitudes
                    </div>

                    @if($solicitudes->hasPages())
                        <nav aria-label="Paginación de solicitudes">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $solicitudes->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $solicitudes->appends(request()->all())->previousPageUrl() }}">Anterior</a>
                                </li>
                                @for($page = 1; $page <= $solicitudes->lastPage(); $page++)
                                    <li class="page-item {{ $page == $solicitudes->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $solicitudes->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $solicitudes->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $solicitudes->appends(request()->all())->nextPageUrl() }}">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <style>
        .pagination .page-link { color:#1e63b8; border-radius:0.375rem; border:1px solid #dee2e6; margin:0 2px; }
        .pagination .page-link:hover { background-color:#1e63b8; color:#fff; }
        .pagination .page-item.active .page-link { background-color:#1e63b8; border-color:#1e63b8; color:#fff; }
        .pagination .page-item.disabled .page-link { color:#9ca3af; background:#f3f4f6; border-color:#e5e7eb; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').each(function() {
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

