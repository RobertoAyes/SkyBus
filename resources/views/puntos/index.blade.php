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
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Puntos Totales --}}
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-body text-center bg-primary text-white rounded">
                        <h5 class="card-title">Tus Puntos Acumulados</h5>
                        <h1 class="display-4 fw-bold">{{ $puntosTotales }}</h1>
                        <p class="card-text">Disponibles para canjear por beneficios exclusivos</p>
                    </div>
                </div>

                {{-- Beneficios Disponibles --}}
                <h4 class="mb-3 text-secondary">Beneficios Disponibles</h4>
                @if($beneficios->count() > 0)
                    @foreach($beneficios as $beneficio)
                        <div class="card shadow-sm mb-3 border-0">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-primary">{{ $beneficio->nombre }}</h5>
                                    <p class="card-text text-muted mb-1">{{ $beneficio->descripcion }}</p>
                                    <span class="badge bg-warning text-dark fs-6">{{ $beneficio->puntos_requeridos }} Puntos</span>
                                </div>
                                <div>
                                    @if($puntosTotales >= $beneficio->puntos_requeridos)
                                        <form action="{{ route('puntos.canjear', $beneficio->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-lg"
                                                    onclick="return confirm('¿Estás seguro de canjear {{ $beneficio->puntos_requeridos }} puntos por {{ $beneficio->nombre }}?')">
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
                        <p>No hay beneficios disponibles en este momento.</p>
                    </div>
                @endif

                {{-- Historial de Puntos --}}
                <h4 class="mb-3 mt-5 text-secondary">Historial de Puntos</h4>
                @if($puntosRegistros->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary">
                            <tr>
                                <th>Viaje</th>
                                <th>Puntos Ganados</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($puntosRegistros as $registro)
                                <tr>
                                    <td>
                                        @if($registro->reserva && $registro->reserva->viaje)
                                            {{ $registro->reserva->viaje->origen->nombre ?? 'N/A' }} →
                                            {{ $registro->reserva->viaje->destino->nombre ?? 'N/A' }}
                                        @else
                                            Viaje no disponible
                                        @endif
                                    </td>
                                    <td class="text-center"><span class="badge bg-success">+{{ $registro->puntos }}</span></td>
                                    <td class="text-center">{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-star fa-2x mb-2 d-block"></i>
                        <p>Aún no has acumulado puntos. Realiza viajes para empezar a ganar.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <style>
        .bg-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
        .table-responsive { min-height: 320px; }
        tbody { min-height: 300px; display: table-row-group; }
    </style>
@endsection
