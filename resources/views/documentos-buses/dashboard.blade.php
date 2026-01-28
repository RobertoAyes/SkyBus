@extends('layouts.layoutadmin')

@section('title', 'Dashboard - Documentación de Buses')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-chart-line text-primary"></i> Dashboard de Documentación
            </h2>
            <div>
                <a href="{{ route('documentos-buses.create') }}" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Nuevo Documento
                </a>
                <a href="{{ route('documentos-buses.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Ver Lista Completa
                </a>
            </div>
        </div>

        <!-- Estadísticas Generales -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Documentos
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Documentos Vigentes
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['vigentes'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Por Vencer (30 días)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['por_vencer'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Documentos Vencidos
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['vencidos'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Documentos Vencidos -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3 bg-danger text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-times-circle"></i> Documentos Vencidos ({{ $vencidos->count() }})
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($vencidos as $doc)
                            <div class="alert alert-danger d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>Bus #{{ $doc->bus->id }}</strong> - {{ $doc->tipo_documento_nombre }}<br>
                                    <small>Vencido hace {{ abs($doc->dias_hasta_vencimiento) }} días</small>
                                </div>
                                <a href="{{ route('documentos-buses.show', $doc->id) }}" class="btn btn-sm btn-dark">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-check-circle fa-3x mb-3"></i>
                                <p>No hay documentos vencidos</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Próximos a Vencer -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3 bg-warning text-dark">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-exclamation-triangle"></i> Próximos a Vencer ({{ $proximosVencer->count() }})
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($proximosVencer as $doc)
                            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>Bus {{ $doc->bus->numero_bus }}</strong> - {{ $doc->tipo_documento_nombre }}<br>
                                    <small>Vence en {{ $doc->dias_hasta_vencimiento }} días ({{ $doc->fecha_vencimiento->format('d/m/Y') }})</small>
                                </div>
                                <a href="{{ route('documentos-buses.show', $doc->id) }}" class="btn btn-sm btn-dark">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-check-circle fa-3x mb-3"></i>
                                <p>No hay documentos próximos a vencer</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Buses con Alertas -->
        @if($busesAlerta->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3 bg-info text-white">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-bus"></i> Buses que Requieren Atención ({{ $busesAlerta->count() }})
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Bus</th>
                                        <th>Placa</th>
                                        <th>Documentos Pendientes</th>
                                        <th>Estado Crítico</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($busesAlerta as $bus)
                                        <tr>
                                            <td><strong>{{ $bus->numero_bus }}</strong></td>
                                            <td>{{ $bus->placa }}</td>
                                            <td>
                                                @foreach($bus->documentos as $doc)
                                                    <span class="badge bg-{{ $doc->getColorEstado() }}">
                                                    {{ $doc->tipo_documento_nombre }}
                                                </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                    $vencidos = $bus->documentos->where('estado', 'vencido')->count();
                                                    $porVencer = $bus->documentos->where('estado', 'por_vencer')->count();
                                                @endphp
                                                @if($vencidos > 0)
                                                    <span class="badge bg-danger">{{ $vencidos }} Vencido(s)</span>
                                                @endif
                                                @if($porVencer > 0)
                                                    <span class="badge bg-warning">{{ $porVencer }} Por vencer</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('documentos-buses.index', ['bus_id' => $bus->id]) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Ver Documentos
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }
        .border-left-success {
            border-left: 4px solid #1cc88a !important;
        }
        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }
        .border-left-danger {
            border-left: 4px solid #e74a3b !important;
        }
    </style>
@endsection
