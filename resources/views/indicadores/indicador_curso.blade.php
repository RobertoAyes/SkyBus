@extends('layouts.layoutadmin')

@section('title', 'Indicador de viaje en curso')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-route me-2"></i>Indicador de viajes de hoy</h4>
            <span class="badge bg-light text-primary fs-6"><i class="fas fa-calendar me-1"></i>{{ now()->format('d/m/Y') }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                    <tr>
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
                            $tieneSalida  = !is_null($viaje->hora_salida);

                            $atrasado = !$tieneSalida && $ahora > $horaEstimada;
                        @endphp
                        <tr class="{{ $atrasado ? 'table-danger' : '' }}">
                            <td>
                                <i class="fas fa-user me-1 text-secondary"></i>{{ $viaje->chofer->name ?? 'N/D' }}
                            </td>
                            <td>
                                <i class="fas fa-map-marker-alt me-1 text-secondary"></i>{{$viaje->ruta->origen.'→'. $viaje->ruta->destino ?? 'N/D' }}
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
                                        $horaEstimada = strtotime($viaje->fecha);
                                        $horaReal = strtotime($viaje->hora_salida);
                                        $difeminutos = floor(($horaReal - $horaEstimada) / 60);
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
                                        $horaEstimada = strtotime($viaje->fecha);
                                        $ahora = time();
                                        $difeminutos = floor(($ahora - $horaEstimada) / 60);
                                    @endphp
                                    <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i>{{ $difeminutos }} min sin salir</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($viaje->hora_salida && $viaje->hora_llegada)
                                    <span class="badge bg-secondary">Completado</span>
                                @elseif($viaje->hora_salida)
                                    <span class="badge bg-success">En curso</span>
                                @elseif($atrasado)
                                    <span class="badge bg-danger">Atrasado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted"><i class="fas fa-bus fa-2x mb-2 d-block"></i>No hay viajes programados para hoy.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($viajes->hasPages())
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Mostrando {{ $viajes->firstItem() }} - {{ $viajes->lastItem() }} de {{ $viajes->total() }} registros
                </small>
                {{ $viajes->links() }}
            </div>
        @endif
    </div>
@endsection
