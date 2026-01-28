@extends('layouts.layoutuser')

@section('title', 'Mis Puntos y Canjes')

@section('contenido')
    <div class="container mt-4">
        <h3 class="mb-4 text-primary"> Mis Puntos de Lealtad</h3>

        {{-- Alertas --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                 {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tarjeta de Puntos Totales --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body text-center bg-primary text-white rounded">
                <h5 class="card-title">Tus Puntos Acumulados</h5>
                <h1 class="display-4 fw-bold">{{ $puntosTotales }}</h1>
                <p class="card-text">Disponibles para canjear por beneficios exclusivos</p>
            </div>
        </div>

        {{-- Beneficios Disponibles --}}
        <h4 class="mb-3 text-secondary"> Beneficios Disponibles</h4>

        @if($beneficios->count() > 0)
            @foreach($beneficios as $beneficio)
                <div class="card shadow-sm mb-3 border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title text-primary">{{ $beneficio->nombre }}</h5>
                                <p class="card-text text-muted">{{ $beneficio->descripcion }}</p>
                                <span class="badge bg-warning text-dark fs-6">{{ $beneficio->puntos_requeridos }} Puntos</span>
                            </div>
                            <div class="col-md-4 text-end">
                                {{-- Validación de puntos suficientes --}}
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
                </div>
            @endforeach
        @else
            <div class="alert alert-info">
                <p class="mb-0">No hay beneficios disponibles en este momento.</p>
            </div>
        @endif

        {{-- Historial de Puntos --}}
        <h4 class="mb-3 mt-5 text-secondary">Historial de Puntos</h4>
        @if($puntosRegistros->count() > 0)
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
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
                                    <td><span class="badge bg-success">+{{ $registro->puntos }}</span></td>
                                    <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <p class="mb-0">Aún no has acumulado puntos. Realiza viajes para empezar a ganar.</p>
            </div>
        @endif
    </div>

    <style>
        .bg-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
    </style>
@endsection
