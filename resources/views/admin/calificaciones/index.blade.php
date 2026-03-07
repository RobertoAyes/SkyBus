@extends('layouts.layoutadmin')

@section('title', 'Calificaciones de Choferes')

@section('content')
    <style>
        .stats-header {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: none;
        }

        .driver-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .driver-card:hover {
            transform: translateX(4px);
            border-left-color: #fbbf24;
            background-color: #fefce8;
        }

        .rating-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #78350f;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
        }

        .count-badge {
            background: #f3f4f6;
            color: #374151;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
        }



        .stats-container {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #9ca3af;
        }

        .driver-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 1.05rem;
        }

        .driver-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }
    </style>

    <div class="stats-container">
        <!-- Header moderno -->
        <div class="mb-4">
            <h2 class="fw-light mb-2" style="color: #1f2937; font-size: 1.75rem; letter-spacing: -0.5px;">
                Estadísticas de Calificaciones
            </h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">
                Desempeño de conductores basado en evaluaciones de usuarios
            </p>
        </div>

        <!-- Card principal -->
        <div class="card shadow-sm border-0">
            <div class="card-header stats-header text-white" style="padding: 1rem 1.5rem;">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-normal" style="font-size: 0.875rem; letter-spacing: 1px; text-transform: uppercase;">
                        <i class="fas fa-chart-line me-2"></i>
                        Rendimiento General
                    </h6>
                    <span class="badge bg-white text-dark" style="font-weight: 500;">
                        {{ count($estadisticas) }} Conductores
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                @if(count($estadisticas) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <tr>
                                <th style="padding: 1rem 1.5rem; font-weight: 600; color: #6b7280; font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                    Conductor
                                </th>
                                <th class="text-center" style="padding: 1rem 1.5rem; font-weight: 600; color: #6b7280; font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                    Calificación
                                </th>
                                <th class="text-center" style="padding: 1rem 1.5rem; font-weight: 600; color: #6b7280; font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                    Evaluaciones
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $estadisticasOrdenadas = $estadisticas->sortByDesc(function($chofer) {
                                    return $chofer->calificaciones_recibidas_avg_estrellas ?? 0;
                                });
                                $mejorCalificacion = $estadisticasOrdenadas->first()->calificaciones_recibidas_avg_estrellas ?? 0;
                            @endphp

                            @foreach($estadisticasOrdenadas as $index => $chofer)
                                @php
                                    $promedio = $chofer->calificaciones_recibidas_avg_estrellas ?? 0;
                                    $esTopPerformer = $promedio == $mejorCalificacion && $promedio > 0;
                                @endphp
                                <tr class="driver-card {{ $esTopPerformer ? 'top-performer' : '' }}">
                                    <td style="padding: 1.25rem 1.5rem;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="driver-avatar">
                                                {{ strtoupper(substr($chofer->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="driver-name">{{ $chofer->name }}</div>
                                                @if($esTopPerformer)
                                                    <small class="text-warning" style="font-weight: 600; font-size: 0.75rem;">
                                                        <i class="fas fa-trophy"></i> Mejor Calificado
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center" style="padding: 1.25rem 1.5rem;">
                                        <div class="rating-badge">
                                            <i class="fas fa-star"></i>
                                            {{ number_format($promedio, 1) }}
                                        </div>
                                    </td>

                                    <td class="text-center" style="padding: 1.25rem 1.5rem;">
                                            <span class="count-badge">
                                                <i class="fas fa-comment-alt me-1" style="font-size: 0.75rem;"></i>
                                                {{ $chofer->calificaciones_recibidas_count }}
                                            </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-bar" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="mt-3 mb-0" style="font-size: 1.1rem;">No hay calificaciones disponibles</p>
                        <small>Las estadísticas aparecerán cuando los usuarios evalúen a los conductores</small>
                    </div>
                @endif
            </div>
        </div>

        <!-- Resumen rápido -->
        @if(count($estadisticas) > 0)
            <div class="row mt-4 g-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-star text-warning mb-2" style="font-size: 2rem;"></i>
                            <h3 class="fw-bold mb-1" style="color: #1f2937;">
                                {{ number_format($estadisticas->avg('calificaciones_recibidas_avg_estrellas'), 1) }}
                            </h3>
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">Promedio General</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-comments text-primary mb-2" style="font-size: 2rem;"></i>
                            <h3 class="fw-bold mb-1" style="color: #1f2937;">
                                {{ $estadisticas->sum('calificaciones_recibidas_count') }}
                            </h3>
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">Total Evaluaciones</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-users text-success mb-2" style="font-size: 2rem;"></i>
                            <h3 class="fw-bold mb-1" style="color: #1f2937;">
                                {{ count($estadisticas) }}
                            </h3>
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">Conductores Activos</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
