@extends('layouts.layoutuser')

@section('title', 'Mis Puntos y Canjes')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-gift me-2"></i> Mis Puntos y Canjes
                </h2>
            </div>

            <div class="card-body">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-circle-check me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                {{-- PUNTOS TOTALES --}}
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-body text-center bg-primary text-white rounded">
                        <h5 class="card-title">Tus Puntos Acumulados</h5>

                        <h1 class="display-4 fw-bold">
                            {{ $puntosTotales }}
                        </h1>

                        <p class="card-text">
                            Disponibles para canjear por beneficios exclusivos
                        </p>
                    </div>
                </div>


                {{-- BENEFICIOS --}}
                <h4 class="mb-3 text-secondary">
                    Beneficios Disponibles
                </h4>


                @if($beneficios->count() > 0)

                    @foreach($beneficios as $beneficio)

                        <div class="card shadow-sm mb-3 border-0">
                            <div class="card-body d-flex justify-content-between align-items-center">

                                <div>
                                    <h5 class="card-title text-primary">
                                        {{ $beneficio->nombre }}
                                    </h5>

                                    <p class="text-muted mb-1">
                                        {{ $beneficio->descripcion }}
                                    </p>

                                    <span class="badge bg-warning text-dark">
                                    {{ $beneficio->puntos_requeridos }} Puntos
                                </span>
                                </div>


                                <div>

                                    @if($puntosTotales >= $beneficio->puntos_requeridos)

                                        <form action="{{ route('puntos.canjear', $beneficio->id) }}" method="POST">
                                            @csrf

                                            <button class="btn btn-success btn-lg"
                                                    onclick="return confirm('¿Deseas canjear este beneficio?')">

                                                Canjear Ahora

                                            </button>

                                        </form>

                                    @else

                                        <button class="btn btn-secondary btn-lg" disabled>
                                            Puntos Insuficientes
                                        </button>

                                    @endif

                                </div>

                            </div>
                        </div>

                    @endforeach


                @else

                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-gift fa-2x mb-2 d-block"></i>
                        <p>No hay beneficios disponibles.</p>
                    </div>

                @endif



                {{-- HISTORIAL DE VIAJES --}}
                <h4 class="mb-3 mt-5 text-secondary">
                    Historial de Viajes
                </h4>


                @if($viajes->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-hover table-bordered align-middle">

                            <thead class="table-primary">

                            <tr>
                                <th>Viaje</th>
                                <th>Fecha Reserva</th>
                                <th>Puntos Recibidos</th>
                            </tr>

                            </thead>


                            <tbody>

                            @foreach($viajes as $reserva)

                                @php
                                    $registro = $puntosRegistros
                                        ->where('reserva_id', $reserva->id)
                                        ->first();
                                @endphp


                                <tr>

                                    <td>
                                        Viaje #{{ $reserva->viaje->id ?? 'N/A' }}
                                    </td>


                                    <td>
                                        {{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y H:i') }}
                                    </td>


                                    <td class="text-center">

                                    <span class="badge bg-success fs-6">

                                        +{{ $registro->puntos ?? 10 }}

                                    </span>

                                    </td>


                                </tr>


                            @endforeach


                            </tbody>

                        </table>

                    </div>


                @else

                    <div class="text-center py-5 text-muted">

                        <i class="fas fa-bus fa-2x mb-2 d-block"></i>

                        <p>No tienes viajes registrados.</p>

                    </div>

                @endif



            </div>

        </div>
    </div>


    <style>

        .bg-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }

        .table-responsive {
            min-height: 320px;
        }

    </style>

@endsection
