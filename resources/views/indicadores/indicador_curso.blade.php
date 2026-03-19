@extends('layouts.layoutadmin')

@section('title', 'Indicador de viaje en curso')

@section('content')
    <div class="d-flex justify-content-center">
        <div style="width: 100%; max-width: 1100px;">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-route me-2"></i>Indicador de viajes de hoy
                    </h4>
                    <span class="badge bg-light text-primary fs-6">
                        <i class="fas fa-calendar me-1"></i>{{ now()->format('d/m/Y') }}
                    </span>
                </div>

                <div class="card-body">

                    {{-- Selector de registros por página --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <form method="GET" action="{{ request()->url() }}" id="perPageForm">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0 fw-bold">Mostrar:</label>
                                <select name="per_page" class="form-select form-select-sm" style="width: auto;"
                                        onchange="document.getElementById('perPageForm').submit()">
                                    @foreach([5, 10, 25, 50] as $option)
                                        <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>
                                            {{ $option }} registros
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <small class="text-muted">
                            Total: {{ $viajes->total() }} registros
                        </small>
                    </div>

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
                                    <td>
                                        <i class="fas fa-user me-1 text-secondary"></i>{{ $viaje->chofer->name ?? 'N/D' }}
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt me-1 text-secondary"></i>{{ $viaje->ruta->origen . '→' . $viaje->ruta->destino ?? 'N/D' }}
                                    </td>
                                    <td>
                                        <span class="fw-bold"><i class="fas fa-clock me-1 text-primary"></i>{{ date('H:i', strtotime($viaje->fecha)) }}</span>
                                    </td>
                                    <td>
                                        @if($viaje->hora_salida)
                                            <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>{{ date('H:i', strtotime($viaje->hora_salida)) }}</span>
                                        @else
                                            <span class="text-muted fst-italic"><i class="fas fa-hourglass-half me-1"></i>Sin registrar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($viaje->hora_salida)
                                            @php
                                                $horaEstimadaTs = strtotime($viaje->fecha);
                                                $horaReal = strtotime($viaje->hora_salida);
                                                $difeminutos = floor(($horaReal - $horaEstimadaTs) / 60);
                                            @endphp
                                            @if($difeminutos == 0)
                                                <span class="badge bg-success">A tiempo</span>
                                            @elseif($difeminutos > 0)
                                                <span class="badge bg-danger"><i class="fas fa-arrow-up me-1"></i>{{ $difeminutos }} min tarde</span>
                                            @else
                                                <span class="badge bg-primary"><i class="fas fa-arrow-down me-1"></i>{{ abs($difeminutos) }} min antes</span>
                                            @endif
                                        @elseif($atrasado)
                                            @php
                                                $horaEstimadaTs = strtotime($viaje->fecha);
                                                $ahoraTs = time();
                                                $difeminutos = floor(($ahoraTs - $horaEstimadaTs) / 60);
                                            @endphp
                                            <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i>{{ $difeminutos }} min sin salir</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- ESTADO CORREGIDO --}}
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
                                        <i class="fas fa-bus fa-2x mb-2 d-block"></i>No hay viajes programados para hoy.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($viajes->hasPages())
                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Mostrando {{ $viajes->firstItem() }} - {{ $viajes->lastItem() }}
                                de {{ $viajes->total() }} registros
                            </small>
                            {{ $viajes->appends(request()->only('per_page'))->links('pagination.numeros') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <style>
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
