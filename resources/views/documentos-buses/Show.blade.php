@extends('layouts.layoutadmin')

@section('title', 'Información Completa del Documento')

@section('content')
    <div class="container mt-4">
        <!-- Título Principal -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Custom style for 'azul marino' title -->
            <div>
                <a href="{{ route('documentos-buses.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Gestionar
                </a>
            </div>
        </div>

        <!-- Tarjeta Única de Detalles (Información, Estado, Historial) -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Detalles Generales del Documento</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Columna Principal: Información del Documento y Historial -->
                    <div class="col-md-8 border-end">

                        <!-- Estado del Documento (Refactorizado con Blue/Danger Palette) -->
                        @php
                            // New color mapping:
                            $statusColor = 'primary'; // Default for Vigente
                            $statusIcon = 'fa-check-circle';
                            $statusAlertColor = 'alert-primary';

                            if ($documento->estaVencido()) {
                                $statusColor = 'danger'; // Red for critical alert
                                $statusIcon = 'fa-times-circle';
                                $statusAlertColor = 'alert-danger';
                            } elseif ($documento->estaPorVencer()) {
                                $statusColor = 'info'; // Light Blue for upcoming warning
                                $statusIcon = 'fa-exclamation-triangle';
                                $statusAlertColor = 'alert-info';
                            }
                        @endphp
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3 text-{{ $statusColor }}">
                                <i class="fas {{ $statusIcon }}"></i>
                                Estado Actual: <span class="badge bg-{{ $statusColor }}">{{ strtoupper($documento->estado) }}</span>
                            </h5>

                            <div class="alert {{ $statusAlertColor }}">
                                @if($documento->estaVencido())
                                    <h6><i class="fas fa-times-circle"></i> Documento VENCIDO</h6>
                                    <p class="mb-0">Este documento expiró hace **{{ abs($documento->dias_hasta_vencimiento) }} días** y requiere una renovación urgente.</p>
                                @elseif($documento->estaPorVencer())
                                    <h6><i class="fas fa-exclamation-triangle"></i> Próximo a Vencer</h6>
                                    <p class="mb-0">Este documento vencerá en **{{ $documento->dias_hasta_vencimiento }} días**. Se recomienda iniciar el proceso de renovación.</p>
                                @else
                                    <h6><i class="fas fa-check-circle"></i> Documento Vigente</h6>
                                    <p class="mb-0">Este documento es válido por **{{ $documento->dias_hasta_vencimiento }} días** más.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Información Detallada del Documento -->
                        <h5 class="border-bottom pb-2 mb-3 text-primary"><i class="fas fa-file-contract"></i> Datos del Documento</h5>
                        <table class="table table-sm table-borderless detail-table">
                            <tr>
                                <th width="35%">Tipo de Documento:</th>
                                <td><span class="badge bg-info">{{ $documento->tipo_documento_nombre }}</span></td>
                            </tr>
                            <tr>
                                <th>Número de Documento:</th>
                                <td><strong>{{ $documento->numero_documento }}</strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-plus text-primary"></i> Fecha de Emisión:</th>
                                <td>{{ $documento->fecha_emision->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-times text-primary"></i> Fecha de Vencimiento:</th>
                                <td><strong class="text-{{ $statusColor }}">{{ $documento->fecha_vencimiento->format('d/m/Y') }}</strong></td>
                            </tr>
                            <tr>
                                <th>Registrado por:</th>
                                <td>{{ $documento->registradoPor->name ?? 'Sistema' }}</td>
                            </tr>
                            <tr>
                                <th>Fecha de Registro:</th>
                                <td>{{ $documento->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($documento->observaciones)
                                <tr>
                                    <th>Observaciones:</th>
                                    <td><p class="alert alert-light p-2 mb-0">{{ $documento->observaciones }}</p></td>
                                </tr>
                            @endif
                        </table>

                        @if($documento->archivo_url)
                            <div class="mt-4">
                                <a href="{{ route('documentos-buses.descargar', $documento->id) }}" class="btn btn-success" target="_blank">
                                    <i class="fas fa-download"></i> Descargar Archivo Digital
                                </a>
                            </div>
                        @endif

                        <!-- Historial de Cambios -->
                        @if($documento->historial->count() > 0)
                            <div class="mt-5">
                                <h5 class="border-bottom pb-2 mb-3 text-secondary"><i class="fas fa-history"></i> Historial de Cambios</h5>
                                <div class="timeline">
                                    @foreach($documento->historial->sortByDesc('created_at') as $historial)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-primary"></div>
                                            <div class="timeline-content card card-body p-2 mb-2 bg-light">
                                                <h6 class="mb-1 text-primary">
                                                    {{ ucfirst($historial->accion) }}
                                                </h6>
                                                <p class="mb-1 small">{{ $historial->descripcion }}</p>
                                                <small class="text-muted">
                                                    {{ $historial->created_at->format('d/m/Y H:i') }} por {{ $historial->usuario->name ?? 'Sistema' }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Columna Lateral: Bus Info y Acciones Rápidas -->
                    <div class="col-md-4">
                        <!-- Información del Bus -->
                        <div class="card bg-light-blue shadow-sm mb-4">
                            <div class="card-header text-dark-blue border-0">
                                <h6 class="mb-0"><i class="fas fa-bus"></i> Información del Bus</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Placa:</strong> {{ $documento->bus->placa ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Modelo:</strong> {{ $documento->bus->modelo ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Capacidad:</strong> {{ $documento->bus->capacidad ?? 'N/A' }} pasajeros</p>
                            </div>
                        </div>

                        <!-- Acciones Rápidas (Blue Palette) -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-dark-blue text-white">
                                <h6 class="mb-0"><i class="fas fa-bolt"></i> Acciones Rápidas</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('documentos-buses.edit', $documento->id) }}" class="btn btn-info text-white">
                                        <i class="fas fa-edit"></i> Modificar Documento
                                    </a>

                                    <!-- Botón que activa el modal de confirmación, eliminando el alert nativo -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fas fa-trash"></i> Eliminar Documento
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación (Bootstrap) -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está **absolutamente seguro** de que desea eliminar este documento?</p>
                    <p class="text-danger small">Esta acción es irreversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <!-- Formulario que se envía al confirmar -->
                    <form id="deleteForm" action="{{ route('documentos-buses.destroy', $documento->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sí, Eliminar Permanentemente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos Personalizados para la paleta de azules y el timeline -->
    <style>
        /* Color para el título 'azul marino' */
        .text-dark-blue-title {
            color: #003366 !important; /* Navy Blue */
        }
        /* Color para el header de la sidebar */
        .bg-dark-blue {
            background-color: #004d99 !important; /* Darker Blue */
        }
        /* Fondo para la tarjeta de Bus Info (Azul Claro) */
        .bg-light-blue {
            background-color: #f0f7ff;
            border: 1px solid #cce5ff;
        }

        /* Timeline Styling */
        .timeline {
            position: relative;
            padding: 0;
            list-style: none;
        }
        .timeline-item {
            position: relative;
            padding-left: 30px;
        }
        .timeline-marker {
            position: absolute;
            left: 0;
            top: 6px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #0d6efd; /* Bootstrap Primary */
            z-index: 1;
        }
        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 4px;
            width: 2px;
            background-color: #dee2e6;
        }
        .detail-table th {
            font-weight: 600;
            color: #34495e;
        }
    </style>
@endsection
