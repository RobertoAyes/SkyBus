@extends('layouts.layoutadmin')

@section('title', 'Itinerarios de Choferes')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <!-- HEADER -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-calendar-alt me-2"></i>Itinerarios de Choferes
                </h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAsignarItinerario">
                    <i class="fas fa-plus me-2"></i>Asignar Itinerario
                </button>
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

                {{-- FILTROS --}}
                <form method="GET" action="{{ route('itinerarioChofer.index') }}" class="mb-4">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda General</label>

                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar por chofer o ruta..."
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

                                @if(request()->hasAny(['buscar','chofer','fecha']))
                                    <a href="{{ route('itinerarioChofer.index') }}" class="btn btn-outline-secondary flex-fill">
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
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-filter me-2"></i>Filtros Adicionales
                                </h6>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">










                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-user text-primary me-1"></i>Chofer
                                        </label>
                                        <select name="chofer" class="form-select">
                                            <option value="" selected disabled>Seleccione un chofer</option>
                                            @foreach($choferes as $chofer)
                                                <option value="{{ $chofer->id }}" {{ request('chofer') == $chofer->id ? 'selected' : '' }}>
                                                    {{ $chofer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>














                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-success me-1"></i>Fecha
                                        </label>
                                        <input type="date" name="fecha" class="form-control"
                                               value="{{ request('fecha') }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MOSTRAR REGISTROS --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="fw-semibold mb-0">Mostrar:</label>
                            <select name="per_page" class="form-select form-select-sm border-primary"
                                    style="width:90px;" onchange="this.form.submit()">
                                <option value="5"  {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
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
                            <th class="text-center" style="width:60px;">#</th>
                            <th>Chofer</th>
                            <th>Ruta</th>
                            <th>Paradas</th>
                            <th>Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($itinerarios as $key => $itinerario)
                            <tr>

                                <td class="text-center">
                                    {{ ($itinerarios->currentPage() - 1) * $itinerarios->perPage() + $key + 1 }}
                                </td>

                                <td>{{ $itinerario->chofer->name ?? 'Sin chofer' }}</td>

                                <td>
                                    {{ $itinerario->ruta->origen ?? '?' }} →
                                    {{ $itinerario->ruta->destino ?? '?' }}
                                </td>

                                <td>
                                    @if($itinerario->paradas->count())
                                        @foreach($itinerario->paradas as $p)
                                            <div>{{ $p->lugar_parada }} ({{ $p->tiempo_parada }} min)</div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Sin paradas</span>
                                    @endif
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y H:i') }}
                                </td>

                                {{-- ACCIONES --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- EDITAR --}}
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalEditarItinerario{{ $itinerario->id }}">
                                    <span class="btn-icon-wrap">
                                        <i class="fas fa-pen-to-square"></i>Editar
                                    </span>
                                        </button>

                                        {{-- ELIMINAR --}}
                                        <form action="{{ route('itinerarioChofer.destroy', $itinerario->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL ELIMINAR --}}
                            <div class="modal fade" id="itnDel{{ $itinerario->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header bg-danger text-white">
                                            <h6 class="modal-title">
                                                <i class="fas fa-exclamation-triangle me-2"></i>Eliminar
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body small">
                                            ¿Eliminar itinerario de <b>{{ $itinerario->chofer->name }}</b>?
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>

                                            <form action="{{ route('itinerarioChofer.destroy', $itinerario->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- MODAL EDITAR --}}
                            <div class="modal fade" id="modalEditarItinerario{{ $itinerario->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Itinerario</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="{{ route('itinerarioChofer.update', $itinerario->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label>Chofer</label>
                                                    <select name="chofer_id" class="form-select">
                                                        @foreach($choferes as $chofer)
                                                            <option value="{{ $chofer->id }}" {{ $itinerario->chofer_id == $chofer->id ? 'selected' : '' }}>
                                                                {{ $chofer->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Ruta</label>
                                                    <select name="ruta_id" class="form-select">
                                                        @foreach($rutas as $ruta)
                                                            <option value="{{ $ruta->id }}" {{ $itinerario->ruta_id == $ruta->id ? 'selected' : '' }}>
                                                                {{ $ruta->origen }} → {{ $ruta->destino }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Fecha</label>
                                                    <input type="datetime-local" name="fecha" class="form-control"
                                                           value="{{ \Carbon\Carbon::parse($itinerario->fecha)->format('Y-m-d\TH:i') }}">
                                                </div>

                                                <div class="text-end">
                                                    <button class="btn btn-primary">Actualizar</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay itinerarios registrados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Mostrando
                        <strong>{{ $itinerarios->firstItem() ?? 0 }}</strong> –
                        <strong>{{ $itinerarios->lastItem() ?? 0 }}</strong>
                        de
                        <strong>{{ $itinerarios->total() }}</strong>
                    </div>

                    {{ $itinerarios->appends(request()->all())->links() }}
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL ASIGNAR ITINERARIO --}}
    <div class="modal fade" id="modalAsignarItinerario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content shadow-sm border-0">
                <div class="modal-header bg-white d-flex align-items-center justify-content-between">
                    <h5 class="modal-title" style="color:#1e63b8; font-weight:600;">
                        <i class="fas fa-calendar-plus me-2"></i>Asignar Itinerario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('itinerarioChofer.store') }}" method="POST">
                        @csrf
                        <div class="card border-0 shadow-sm mb-4" style="background:#f8faff;">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted small"><i class="fas fa-user me-1"></i>Chofer</label>
                                    <select name="chofer_id" class="form-select" required>
                                        @foreach($choferes as $chofer)
                                            <option value="{{ $chofer->id }}">{{ $chofer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted small"><i class="fas fa-route me-1"></i>Ruta</label>
                                    <select name="ruta_id" class="form-select" required>
                                        <option value="">Selecciona una ruta</option>
                                        @foreach($rutas as $ruta)
                                            <option value="{{ $ruta->id }}">{{ $ruta->origen }} → {{ $ruta->destino }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label fw-semibold text-muted small"><i class="fas fa-calendar-alt me-1"></i>Fecha y Hora</label>
                                    <input type="datetime-local" name="fecha" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        {{-- PARADAS --}}
                        <div class="card border-0 shadow-sm mb-4" style="background:#f8faff;">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3" style="color:#0284c7;font-size:.75rem;text-transform:uppercase;letter-spacing:.07em;">
                                    <i class="fas fa-map-marker-alt me-1"></i>Paradas intermedias
                                    <span class="text-muted fw-normal ms-1" style="font-size:.7rem;text-transform:none;">(opcional)</span>
                                </h6>
                                <div id="frm-paradas-container-asignar" class="d-flex flex-column gap-2">
                                    <div class="frm-parada-item d-flex align-items-center gap-2 p-2 rounded" style="background:#fff;border:1px solid #e2edf8;">
                                        <input type="text" name="paradas[lugar][]" placeholder="Ej: Terminal Norte" class="form-control form-control-sm">
                                        <input type="number" name="paradas[tiempo][]" placeholder="0" class="form-control form-control-sm" style="width:120px;flex-shrink:0;">
                                        <button type="button" class="btn btn-sm btn-outline-danger frm-btn-remove" style="width:34px;height:34px;flex-shrink:0;padding:0;"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm mt-3 btn-add-parada" data-target="#frm-paradas-container-asignar" style="background:#e0f2fe;color:#0284c7;border:1px dashed #bae6fd;font-weight:600;"><i class="fas fa-plus me-1"></i>Agregar parada</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Asignar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SELECT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                allowClear: true
            });
        });
    </script>

@endsection
