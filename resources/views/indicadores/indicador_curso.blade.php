@extends('layouts.layoutadmin')

@section('title', 'Indicador de viaje en curso')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">


            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-calendar me-2"></i>Indicador de viajes de hoy
                </h2>
            </div>

            <div class="card-body">


                <form method="GET" action="{{ route('indicador_en_curso.index') }}" id="formFiltros">

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Búsqueda General
                        </label>

                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <input type="text" name="buscar" class="form-control"
                                           placeholder="Buscar por chofer..."
                                           value="{{ request('buscar') }}">
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
                                @if(request()->hasAny(['buscar','estado','ruta_id','hora']))
                                    <a href="{{ route('indicador_en_curso.index') }}" class="btn btn-outline-secondary flex-fill">
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
                                            <option value="en_curso"   {{ request('estado') == 'en_curso'   ? 'selected' : '' }}>En curso</option>
                                            <option value="pendiente"  {{ request('estado') == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                                            <option value="atrasado"   {{ request('estado') == 'atrasado'   ? 'selected' : '' }}>Atrasado</option>
                                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-map-marker-alt text-warning me-1"></i> Ruta
                                        </label>
                                        <select name="ruta_id" class="form-select select2" data-placeholder="Todas">
                                            <option value=""></option>
                                            @foreach($rutas as $ruta)
                                                <option value="{{ $ruta->id }}"
                                                    {{ request('ruta_id') == $ruta->id ? 'selected' : '' }}>
                                                    {{ $ruta->origen }} → {{ $ruta->destino }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-clock text-primary me-1"></i> Hora Estimada
                                        </label>
                                        <input type="time" name="hora" class="form-control"
                                               value="{{ request('hora') }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Chofer</th>
                            <th>Ruta</th>
                            <th>Hora Estimada</th>
                            <th>Hora Real de Salida</th>
                            <th>Diferencia</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($viajes as $key => $viaje)
                            @php
                                $horaEstimada = $viaje->fecha;
                                $ahora        = date('Y-m-d H:i:s');
                                $tieneSalida  = !is_null($viaje->hora_salida);
                                $atrasado     = !$tieneSalida && $ahora > $horaEstimada;
                            @endphp
                            <tr>

                                <td>{{ ($viajes->currentPage() - 1) * $viajes->perPage() + $key + 1 }}</td>
                                <td>{{ $viaje->chofer->name ?? 'N/D' }}</td>
                                <td>{{ ($viaje->ruta->origen ?? '') . ' → ' . ($viaje->ruta->destino ?? 'N/D') }}</td>

                                <td>
                                    {{ date('H:i', strtotime($viaje->fecha)) }}
                                </td>

                                <td>
                                    @if($viaje->hora_salida)
                                        {{ date('H:i', strtotime($viaje->hora_salida)) }}
                                    @else
                                        <span style="color:#adb5bd;">Sin registrar</span>

                                    @endif
                                </td>

                                <td>
                                    @if($viaje->hora_salida)
                                        @php
                                            $he  = strtotime($viaje->fecha);
                                            $hr  = strtotime($viaje->hora_salida);
                                            $dif = floor(($hr - $he) / 60);
                                        @endphp
                                        @if($dif == 0)
                                            <span class="badge bg-success" style="font-size:0.82rem;">A tiempo</span>
                                        @elseif($dif > 0)
                                            <span class="badge bg-danger" style="font-size:0.82rem;">{{ $dif }} min tarde</span>
                                        @else
                                            <span class="badge" style="background:#1e63b8; font-size:0.82rem;">{{ abs($dif) }} min antes</span>
                                        @endif
                                    @elseif($atrasado)
                                        @php
                                            $he  = strtotime($viaje->fecha);
                                            $dif = floor((time() - $he) / 60);
                                        @endphp
                                        <span class="badge bg-danger" style="font-size:0.82rem;">{{ $dif }} min sin salir</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    @if($viaje->hora_salida && $viaje->hora_llegada)
                                        <span class="badge bg-secondary" style="font-size:0.85rem;">Completado</span>
                                    @elseif($viaje->hora_salida)
                                        <span class="badge bg-success" style="font-size:0.85rem;">En curso</span>
                                    @elseif($atrasado)
                                        <span class="badge bg-danger" style="font-size:0.85rem;">Atrasado</span>
                                    @else
                                        <span class="badge bg-warning text-dark" style="font-size:0.85rem;">Pendiente</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-bus fa-2x mb-2 d-block"></i>
                                    No hay viajes programados para hoy.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $viajes->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $viajes->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $viajes->total() }}</span>
                        viajes
                    </div>

                    @if($viajes->hasPages())
                        <nav aria-label="Paginación de viajes">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $viajes->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $viajes->previousPageUrl() }}">Anterior</a>
                                </li>
                                @for($page = 1; $page <= $viajes->lastPage(); $page++)
                                    <li class="page-item {{ $page == $viajes->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $viajes->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $viajes->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $viajes->nextPageUrl() }}">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <style>
        .pagination .page-link { color: #1e63b8; border-radius: 0.375rem; border: 1px solid #dee2e6; margin: 0 2px; }
        .pagination .page-link:hover               { background-color: #1e63b8; color: #fff; }
        .pagination .page-item.active .page-link   { background-color: #1e63b8; border-color: #1e63b8; color: #fff; }
        .pagination .page-item.disabled .page-link { color: #9ca3af; background: #f3f4f6; border-color: #e5e7eb; }
        .table-primary th { background-color: #d0e4f7; color: #212529;  }
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

