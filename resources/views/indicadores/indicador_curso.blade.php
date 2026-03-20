@extends('layouts.layoutadmin')

@section('title', 'Indicador de viaje en curso')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-route me-2"></i>Indicador de viajes de hoy
                </h2>
                <span class="badge bg-light text-primary fs-6">
                {{ now()->format('d/m/Y') }}
            </span>
            </div>

            <div class="card-body">

                {{-- FILTROS --}}
                <form method="GET" action="{{ request()->url() }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda general</label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar por chofer o ruta..."
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
                                @if(request()->hasAny(['buscar','estado','fecha']))
                                    <a href="{{ request()->url() }}" class="btn btn-outline-secondary flex-fill">
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
                                <h6 class="mb-0 text-primary">Filtros adicionales</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            Estado del viaje
                                        </label>
                                        <select name="estado" class="form-select select2" data-placeholder="Todos">
                                            <option value=""></option>
                                            <option value="Pendiente" {{ request('estado') === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="En ruta" {{ request('estado') === 'En ruta' ? 'selected' : '' }}>En ruta</option>
                                            <option value="Atrasado" {{ request('estado') === 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
                                            <option value="Finalizado" {{ request('estado') === 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Fecha</label>
                                        <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MOSTRAR REGISTROS --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold">Mostrar:</label>
                            <select name="per_page" class="form-select form-select-sm border-primary" style="width:90px;" onchange="this.form.submit()">
                                @foreach([5,10,25,50] as $option)
                                    <option value="{{ $option }}" {{ request('per_page') == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            <span>registros</span>
                        </div>
                        <small class="text-muted">
                            Total: {{ $viajes->total() }} registros
                        </small>
                    </div>
                </form>

                {{-- TABLA --}}
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
                        @forelse($viajes as $viaje)
                            @php
                                $horaEstimada = $viaje->fecha;
                                $ahora = date('Y-m-d H:i:s');
                                $tieneSalida = !is_null($viaje->hora_salida);
                                $atrasado = !$tieneSalida && $ahora > $horaEstimada;
                            @endphp
                            <tr class="{{ $atrasado ? 'table-danger' : '' }}">
                                <td>{{ $viajes->firstItem() + $loop->index }}</td>
                                <td>{{ $viaje->chofer->name ?? 'N/D' }}</td>
                                <td>{{ $viaje->ruta->origen . ' → ' . $viaje->ruta->destino ?? 'N/D' }}</td>
                                <td class="fw-bold">{{ date('H:i', strtotime($viaje->fecha)) }}</td>
                                <td>
                                    @if($viaje->hora_salida)
                                        <span class="text-success fw-bold">{{ date('H:i', strtotime($viaje->hora_salida)) }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Sin registrar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($viaje->hora_salida)
                                        @php
                                            $difeminutos = floor((strtotime($viaje->hora_salida) - strtotime($viaje->fecha)) / 60);
                                        @endphp
                                        <span class="badge {{ $difeminutos == 0 ? 'bg-success' : ($difeminutos > 0 ? 'bg-danger' : 'bg-primary') }}">
                                            {{ $difeminutos == 0 ? 'A tiempo' : ($difeminutos > 0 ? $difeminutos.' min tarde' : abs($difeminutos).' min antes') }}
                                        </span>
                                    @elseif($atrasado)
                                        @php $difeminutos = floor((time() - strtotime($viaje->fecha)) / 60); @endphp
                                        <span class="badge bg-danger">{{ $difeminutos }} min sin salir</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge
                                        {{ $viaje->estado_viaje=='Finalizado' ? 'bg-secondary' :
                                           ($viaje->estado_viaje=='En ruta' ? 'bg-success' :
                                           ($viaje->estado_viaje=='Atrasado' ? 'bg-danger' : 'bg-warning text-dark')) }}">
                                        {{ $viaje->estado_viaje ?? 'Pendiente' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No hay viajes programados para hoy.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                @if($viajes->hasPages())
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Mostrando {{ $viajes->firstItem() }} - {{ $viajes->lastItem() }}
                            de {{ $viajes->total() }} registros
                        </small>
                        {{ $viajes->appends(request()->all())->links('pagination.numeros') }}
                    </div>
                @endif

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
        .table { table-layout: fixed; width: 100%; }
    </style>

    {{-- SELECT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: function(){
                    return $(this).data('placeholder') || 'Seleccionar...';
                },
                allowClear: true
            });
        });
    </script>

@endsection
