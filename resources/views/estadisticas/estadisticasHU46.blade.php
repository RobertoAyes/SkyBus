@extends('layouts.layoutadmin')

@section('title', 'Panel Administrativo')

@section('content')
    <style>
        .stats-header {
            background: linear-gradient(135deg, #1e63b8 0%, #0d6efd 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(30, 99, 184, 0.3);
        }

        .stat-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: white;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12) !important;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .badge-trend {
            font-size: 11px;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .btn-apply {
            background: linear-gradient(135deg, #1e63b8 0%, #0d6efd 100%);
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 99, 184, 0.4);
            color: white;
        }

        .btn-clear {
            background: #f3f4f6;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #374151;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-clear:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }
        .chart-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .chart-header {
            border-bottom: 1px solid #f3f4f6;
            padding: 1.25rem 1.5rem;
        }

        .chart-container {
            position: relative;
            padding: 1.5rem;
        }

        .table-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .table-header {
            background: linear-gradient(135deg, #1e63b8 0%, #0d6efd 100%);
            padding: 1.25rem 1.5rem;
        }

        .progress-bar-custom {
            height: 6px;
            border-radius: 10px;
            background: #e5e7eb;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        .form-label-custom {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .form-control-custom {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>

    <div class="container-fluid px-3 py-3">


        <div class="stats-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 56px; height: 56px; background: rgba(255,255,255,0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-chart-line" style="font-size: 28px;"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 fw-bold" style="font-size: 1.75rem;">Estadísticas</h2>
                    </div>
                </div>
            </div>
        </div>


        <div class="filter-card mb-4">
            <div class="p-4">
                <form method="GET" action="{{ route('estadistica') }}" class="row g-3 align-items-end">


                    <div class="col-lg-5 col-md-6">
                        <label class="form-label-custom">
                            <i class="fas fa-calendar me-1"></i> Período de Tiempo
                        </label>
                        <select name="periodo" id="periodo" class="form-select form-control-custom">
                            <option value="">Seleccionar período</option>
                            <option value="semana" {{ request('periodo') == 'semana' ? 'selected' : '' }}>Última semana</option>
                            <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Último mes</option>
                            <option value="anio" {{ request('periodo') == 'anio' ? 'selected' : '' }}>Último año</option>
                        </select>
                    </div>


                    <div class="col-lg-5 col-md-6">
                        <label class="form-label-custom">
                            <i class="fas fa-toggle-on me-1"></i> Estado de Usuario
                        </label>
                        <select name="estado" class="form-select form-control-custom">
                            <option value="">Todos</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>


                    <div class="col-lg-2 col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-apply w-50">
                            <i class=""></i>Filtrar
                        </button>
                        <a href="{{ route('estadistica') }}" class="btn btn-clear w-50">
                            <i class=""></i>Limpiar
                        </a>
                    </div>

                </form>
            </div>
        </div>


        <div class="row g-3 mb-4">

            <div class="col-lg-3 col-md-6">
                <div class="stat-card shadow-sm p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="stat-icon" style="background: #ecfdf5;">
                            <i class="fas fa-user-check" style="color: #10b981;"></i>
                        </div>
                        <span class="badge-trend" style="background: #d1fae5; color: #065f46;">
                        <i class="fas fa-arrow-up"></i> 12%
                    </span>
                    </div>
                    <p class="text-muted mb-1 fw-semibold" style="font-size: 0.85rem;">Usuarios Activos</p>
                    <h2 class="fw-bold mb-1" style="color: #111827; font-size: 2rem;">{{ $usuariosActivos }}</h2>
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <i class="fas fa-info-circle me-1"></i>En el sistema
                    </small>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="stat-card shadow-sm p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="stat-icon" style="background: #fef2f2;">
                            <i class="fas fa-user-times" style="color: #ef4444;"></i>
                        </div>
                        <span class="badge-trend" style="background: #fee2e2; color: #991b1b;">
                        <i class="fas fa-arrow-down"></i> 5%
                    </span>
                    </div>
                    <p class="text-muted mb-1 fw-semibold" style="font-size: 0.85rem;">Usuarios Inactivos</p>
                    <h2 class="fw-bold mb-1" style="color: #111827; font-size: 2rem;">{{ $usuariosInactivos }}</h2>
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <i class="fas fa-info-circle me-1"></i>Sin actividad
                    </small>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="stat-card shadow-sm p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="stat-icon" style="background: #eff6ff;">
                            <i class="fas fa-users" style="color: #3b82f6;"></i>
                        </div>
                        <span class="badge-trend" style="background: #dbeafe; color: #1e40af;">
                        <i class="fas fa-arrow-up"></i> 8%
                    </span>
                    </div>
                    <p class="text-muted mb-1 fw-semibold" style="font-size: 0.85rem;">Total Usuarios</p>
                    <h2 class="fw-bold mb-1" style="color: #111827; font-size: 2rem;">{{ $usuariosActivos + $usuariosInactivos }}</h2>
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <i class="fas fa-info-circle me-1"></i>Registrados
                    </small>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="stat-card shadow-sm p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="stat-icon" style="background: #fef3c7;">
                            <i class="fas fa-percentage" style="color: #f59e0b;"></i>
                        </div>
                        <span class="badge-trend" style="background: #fef3c7; color: #92400e;">
                        <i class="fas fa-arrow-up"></i> 3%
                    </span>
                    </div>
                    <p class="text-muted mb-1 fw-semibold" style="font-size: 0.85rem;">Tasa de Actividad</p>
                    <h2 class="fw-bold mb-1" style="color: #111827; font-size: 2rem;">
                        @php
                            $total = $usuariosActivos + $usuariosInactivos;
                            $tasa = $total > 0 ? round(($usuariosActivos / $total) * 100, 1) : 0;
                        @endphp
                        {{ $tasa }}%
                    </h2>
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <i class="fas fa-info-circle me-1"></i>Proporción activos
                    </small>
                </div>
            </div>
        </div>


        <div class="row g-3 mb-4">

            <div class="col-lg-8">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #111827;">
                                    <i class="fas fa-chart-line me-2" style="color: #667eea;"></i>
                                    Evolución de Usuarios
                                </h5>
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">Crecimiento registrado en el período seleccionado</p>
                            </div>
                            <div style="font-size: 0.75rem;">
                            <span class="d-inline-flex align-items-center gap-1">
                                <span style="width: 12px; height: 12px; background: #667eea; border-radius: 3px; display: inline-block;"></span>
                                <span class="text-muted">Usuarios</span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartCrecimiento" height="90"></canvas>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="fw-bold mb-1" style="color: #111827;">
                            <i class="fas fa-user-tag me-2" style="color: #667eea;"></i>
                            Distribución por Rol
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Usuarios según su tipo</p>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartRoles" height="185"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-card">
            <div class="table-header">
                <h5 class="mb-0 text-white fw-bold">
                    <i class="fas fa-table me-2"></i>Detalle de Usuarios por Rol
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                    <thead style="background: #f9fafb;">
                    <tr>
                        <th class="border-0 fw-bold text-uppercase py-3 px-4" style="font-size: 0.7rem; color: #6b7280; letter-spacing: 0.5px;">Rol</th>
                        <th class="border-0 fw-bold text-uppercase py-3 px-4" style="font-size: 0.7rem; color: #6b7280; letter-spacing: 0.5px;">Cantidad</th>
                        <th class="border-0 fw-bold text-uppercase py-3 px-4" style="font-size: 0.7rem; color: #6b7280; letter-spacing: 0.5px;">Porcentaje</th>
                        <th class="border-0 fw-bold text-uppercase py-3 px-4" style="font-size: 0.7rem; color: #6b7280; letter-spacing: 0.5px;">Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total = $usuariosActivos + $usuariosInactivos;
                        $colores = ['#667eea', '#10b981', '#f59e0b', '#ef4444', '#3b82f6'];
                        $index = 0;
                    @endphp

                    @foreach($detallePorRol as $rol => $datosEstado)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 8px; height: 32px; background: {{ $colores[$index % count($colores)] }}; border-radius: 4px;"></div>
                                    <span class="fw-semibold" style="color: #111827;">{{ $rol }}</span>
                                </div>
                            </td>

                            <td class="px-4 py-3 fw-bold" style="color: #111827;">
                                @if(is_array($datosEstado) || $datosEstado instanceof \Illuminate\Support\Collection)
                                    {{ collect($datosEstado)->sum() }}
                                @else
                                    {{ $datosEstado }}
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @php
                                    $cantidadRol = is_array($datosEstado) || $datosEstado instanceof \Illuminate\Support\Collection
                                        ? collect($datosEstado)->sum()
                                        : $datosEstado;
                                    $porcentaje = $total > 0 ? round(($cantidadRol / $total) * 100, 1) : 0;
                                @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress-bar-custom" style="width: 100px;">
                                        <div class="progress-fill" style="width: {{ $porcentaje }}%; background: {{ $colores[$index % count($colores)] }};"></div>
                                    </div>
                                    <span class="fw-semibold text-muted" style="font-size: 0.85rem;">{{ $porcentaje }}%</span>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                @if(is_array($datosEstado) || $datosEstado instanceof \Illuminate\Support\Collection)
                                    @foreach($datosEstado as $estado => $cant)
                                        @if($estado === 'activo')
                                            <span class="badge rounded-pill me-1" style="background: #d1fae5; color: #065f46; font-size: 0.75rem; padding: 6px 12px; font-weight: 600;">
                            <i class="fas fa-check-circle me-1"></i>Activo
                        </span>
                                        @else
                                            <span class="badge rounded-pill me-1" style="background: #fee2e2; color: #991b1b; font-size: 0.75rem; padding: 6px 12px; font-weight: 600;">
                            <i class="fas fa-times-circle me-1"></i>Inactivo
                        </span>
                                        @endif
                                    @endforeach
                                @else
                                    @if($tipoEstado == 'activo')
                                        <span class="badge rounded-pill" style="background: #d1fae5; color: #065f46; font-size: 0.75rem; padding: 6px 12px; font-weight: 600;">
                        <i class="fas fa-check-circle me-1"></i>Activo
                    </span>
                                    @elseif($tipoEstado == 'inactivo')
                                        <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; font-size: 0.75rem; padding: 6px 12px; font-weight: 600;">
                                        <i class="fas fa-times-circle me-1"></i>Inactivo
                    </span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @php $index++; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Colores modernos
        const colors = {
            primary: '#667eea',
            secondary: '#764ba2',
            success: '#10b981',
            danger: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };


        const ctxCrecimiento = document.getElementById('chartCrecimiento');
        const gradientCrecimiento = ctxCrecimiento.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradientCrecimiento.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
        gradientCrecimiento.addColorStop(1, 'rgba(102, 126, 234, 0)');

        new Chart(ctxCrecimiento, {
            type: 'line',
            data: {
                labels: {!! json_encode($usuariosPorFecha->keys()) !!},
                datasets: [{
                    label: 'Usuarios Registrados',
                    data: {!! json_encode($usuariosPorFecha->values()) !!},
                    borderColor: colors.primary,
                    backgroundColor: gradientCrecimiento,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: colors.primary,
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 12,
                        borderRadius: 8,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        displayColors: false,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6', drawBorder: false },
                        ticks: { color: '#6b7280', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#6b7280', font: { size: 11 } }
                    }
                }
            }
        });


        const ctxRoles = document.getElementById('chartRoles');
        new Chart(ctxRoles, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($usuariosPorRol->keys()) !!},
                datasets: [{
                    data: {!! json_encode($usuariosPorRol->values()) !!},
                    backgroundColor: [colors.primary, colors.success, colors.warning, colors.danger, colors.info],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 12 },
                            color: '#6b7280',
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 12,
                        borderRadius: 8,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 }
                    }
                }
            }
        });
    </script>
@endsection

