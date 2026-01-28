@extends('layouts.layoutadmin')

@section('title', 'Editar Documento de Bus')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a href="{{ route('documentos-buses.show', $documento->id) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye"></i> Ver Detalles
                        </a>
                        <a href="{{ route('documentos-buses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Gestionar
                        </a>
                    </div>
                </div>

                <!-- Estado Actual -->
                <div class="alert alert-{{ $documento->getColorEstado() }} d-flex align-items-center mb-4">
                    <i class="fas {{ $documento->getIconoEstado() }} fa-2x me-3"></i>
                    <div>
                        <h5 class="mb-1">Estado Actual: {!! $documento->estado_badge !!}</h5>
                        <p class="mb-0">
                            @if($documento->estaVencido())
                                Este documento está VENCIDO desde hace {{ abs($documento->dias_hasta_vencimiento) }} días
                            @elseif($documento->estaPorVencer())
                                Este documento vencerá en {{ $documento->dias_hasta_vencimiento }} días
                            @else
                                Este documento está vigente por {{ $documento->dias_hasta_vencimiento }} días más
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Formulario -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-file-alt"></i> Actualizar Información del Documento</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('documentos-buses.update', $documento->id) }}" method="POST" enctype="multipart/form-data" id="formDocumento">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Selección de Bus -->
                                <div class="col-md-6 mb-3">
                                    <label for="bus_id" class="form-label">
                                        <i class="fas fa-bus text-primary"></i> Bus <span class="text-danger">*</span>
                                    </label>
                                    <select name="bus_id" id="bus_id" class="form-select @error('bus_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un bus</option>
                                        @foreach($buses as $bus)
                                            <option value="{{ $bus->id }}" {{ (old('bus_id', $documento->bus_id) == $bus->id) ? 'selected' : '' }}>
                                                Bus {{ $bus->numero_bus }} - Placa: {{ $bus->placa }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bus_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tipo de Documento -->
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_documento" class="form-label">
                                        <i class="fas fa-file-contract text-primary"></i> Tipo de Documento <span class="text-danger">*</span>
                                    </label>
                                    <select name="tipo_documento" id="tipo_documento" class="form-select @error('tipo_documento') is-invalid @enderror" required>
                                        <option value="">Seleccione tipo</option>
                                        @foreach($tiposDocumento as $key => $tipo)
                                            <option value="{{ $key }}" {{ (old('tipo_documento', $documento->tipo_documento) == $key) ? 'selected' : '' }}>
                                                {{ $tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipo_documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Número de Documento -->
                                <div class="col-md-6 mb-3">
                                    <label for="numero_documento" class="form-label">
                                        <i class="fas fa-hashtag text-primary"></i> Número de Documento <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="numero_documento" id="numero_documento"
                                           class="form-control @error('numero_documento') is-invalid @enderror"
                                           value="{{ old('numero_documento', $documento->numero_documento) }}" required>
                                    @error('numero_documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Archivo -->
                                <div class="col-md-6 mb-3">
                                    <label for="archivo" class="form-label">
                                        <i class="fas fa-upload text-primary"></i> Archivo Digital
                                    </label>

                                    @if($documento->archivo_url)
                                        <div class="alert alert-info mb-2 d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-file"></i> Archivo actual:
                                            <a href="{{ route('documentos-buses.descargar', $documento->id) }}" target="_blank">
                                                Descargar
                                            </a>
                                        </span>
                                            <small class="text-muted">Subir nuevo archivo reemplazará el actual</small>
                                        </div>
                                    @endif

                                    <input type="file" name="archivo" id="archivo"
                                           class="form-control @error('archivo') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Formatos: PDF, JPG, PNG. Máximo 5MB</small>
                                    @error('archivo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="preview" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Fecha de Emisión -->
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_emision" class="form-label">
                                        <i class="fas fa-calendar-plus text-primary"></i> Fecha de Emisión <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="fecha_emision" id="fecha_emision"
                                           class="form-control @error('fecha_emision') is-invalid @enderror"
                                           value="{{ old('fecha_emision', $documento->fecha_emision->format('Y-m-d')) }}"
                                           max="{{ date('Y-m-d') }}" required>
                                    @error('fecha_emision')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Fecha de Vencimiento -->
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_vencimiento" class="form-label">
                                        <i class="fas fa-calendar-times text-primary"></i> Fecha de Vencimiento <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                                           class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                                           value="{{ old('fecha_vencimiento', $documento->fecha_vencimiento->format('Y-m-d')) }}" required>
                                    @error('fecha_vencimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="dias_vigencia" class="mt-2"></div>
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">
                                    <i class="fas fa-comment-alt text-primary"></i> Observaciones
                                </label>
                                <textarea name="observaciones" id="observaciones" rows="3"
                                          class="form-control @error('observaciones') is-invalid @enderror">{{ old('observaciones', $documento->observaciones) }}</textarea>
                                @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alerta de Validación -->
                            <div id="alertaValidacion" class="alert d-none">
                                <i class="fas fa-info-circle"></i> <span id="mensajeValidacion"></span>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('documentos-buses.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="button" id="btnActualizar" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Documento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Historial de Cambios -->
                @if($documento->historial->count() > 0)
                    <div class="card shadow mt-4">
                        <div class="card-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white;">
                            <h6 class="mb-0"><i class="fas fa-history"></i> Historial de Cambios</h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @foreach($documento->historial->sortByDesc('created_at') as $historial)
                                    <div class="timeline-item mb-3">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-circle text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <strong>{{ ucfirst($historial->accion) }}</strong>
                                                <p class="mb-0 text-muted">{{ $historial->descripcion }}</p>
                                                <small class="text-muted">
                                                    {{ $historial->created_at->format('d/m/Y H:i') }} -
                                                    {{ $historial->usuario->name ?? 'Sistema' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalConfirmacionLabel">
                        <i class="fas fa-question-circle"></i> Confirmar Actualización
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">¿Está seguro que desea actualizar este documento?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarActualizacion">
                        <i class="fas fa-check"></i> Sí, Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Error de Fechas -->
    <div class="modal fade" id="modalErrorFechas" tabindex="-1" aria-labelledby="modalErrorFechasLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalErrorFechasLabel">
                        <i class="fas fa-exclamation-triangle"></i> Error de Validación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">La fecha de vencimiento debe ser posterior a la fecha de emisión.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fas fa-check"></i> Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Error de Archivo -->
    <div class="modal fade" id="modalErrorArchivo" tabindex="-1" aria-labelledby="modalErrorArchivoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalErrorArchivoLabel">
                        <i class="fas fa-exclamation-triangle"></i> Archivo Demasiado Grande
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">El archivo supera el tamaño máximo permitido de 5MB. Por favor, seleccione un archivo más pequeño.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fas fa-check"></i> Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaEmision = document.getElementById('fecha_emision');
            const fechaVencimiento = document.getElementById('fecha_vencimiento');
            const diasVigencia = document.getElementById('dias_vigencia');
            const archivoInput = document.getElementById('archivo');
            const preview = document.getElementById('preview');
            const alertaValidacion = document.getElementById('alertaValidacion');
            const mensajeValidacion = document.getElementById('mensajeValidacion');
            const btnActualizar = document.getElementById('btnActualizar');
            const formDocumento = document.getElementById('formDocumento');

            // Modales
            const modalConfirmacion = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
            const modalErrorFechas = new bootstrap.Modal(document.getElementById('modalErrorFechas'));
            const modalErrorArchivo = new bootstrap.Modal(document.getElementById('modalErrorArchivo'));

            function calcularDiasVigencia() {
                if (fechaEmision.value && fechaVencimiento.value) {
                    const emision = new Date(fechaEmision.value);
                    const vencimiento = new Date(fechaVencimiento.value);
                    const hoy = new Date();

                    if (vencimiento <= emision) {
                        diasVigencia.innerHTML = '<span class="badge bg-danger">La fecha de vencimiento debe ser posterior a la emisión</span>';
                        alertaValidacion.classList.remove('d-none');
                        alertaValidacion.className = 'alert alert-danger';
                        mensajeValidacion.textContent = 'Fechas inválidas';
                        return;
                    }

                    const diffTime = vencimiento - hoy;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    let badgeClass = 'success';
                    let alertClass = 'alert-success';
                    let mensaje = '';

                    if (diffDays < 0) {
                        badgeClass = 'danger';
                        alertClass = 'alert-danger';
                        mensaje = `Este documento estará VENCIDO (${Math.abs(diffDays)} días atrás)`;
                    } else if (diffDays <= 30) {
                        badgeClass = 'warning';
                        alertClass = 'alert-warning';
                        mensaje = `Este documento estará próximo a vencer en ${diffDays} días`;
                    } else {
                        mensaje = `✓ Documento válido por ${diffDays} días`;
                    }

                    diasVigencia.innerHTML = `<span class="badge bg-${badgeClass}">Vigencia: ${diffDays} días desde hoy</span>`;
                    alertaValidacion.classList.remove('d-none');
                    alertaValidacion.className = `alert ${alertClass}`;
                    mensajeValidacion.textContent = mensaje;
                }
            }

            archivoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);

                    if (fileSize > 5) {
                        preview.innerHTML = '<span class="badge bg-danger">El archivo supera 5MB</span>';
                        archivoInput.value = '';
                        modalErrorArchivo.show();
                        return;
                    }

                    preview.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-file"></i> <strong>${file.name}</strong><br>
                            <small>Tamaño: ${fileSize} MB</small>
                        </div>
                    `;
                }
            });

            fechaEmision.addEventListener('change', calcularDiasVigencia);
            fechaVencimiento.addEventListener('change', calcularDiasVigencia);

            // Calcular al cargar
            calcularDiasVigencia();

            // Botón de actualizar - muestra modal de confirmación
            btnActualizar.addEventListener('click', function() {
                const emision = new Date(fechaEmision.value);
                const vencimiento = new Date(fechaVencimiento.value);

                if (vencimiento <= emision) {
                    modalErrorFechas.show();
                    return false;
                }

                modalConfirmacion.show();
            });

            // Confirmar actualización
            document.getElementById('btnConfirmarActualizacion').addEventListener('click', function() {
                modalConfirmacion.hide();
                formDocumento.submit();
            });
        });
    </script>

    <style>
        .timeline-item {
            border-left: 2px solid #dee2e6;
            padding-left: 20px;
        }

        /* Estilos personalizados para azul oscuro y claro */
        .bg-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
        }

        .modal-header {
            border-radius: 10px 10px 0 0;
        }
    </style>
@endsection
