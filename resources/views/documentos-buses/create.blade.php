@extends('layouts.layoutadmin')

@section('title', 'Registrar Documento de Bus')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">
                        <i class="fas fa-file-medical text-primary"></i> Registrar Nuevo Documento
                    </h2>
                    <a href="{{ route('documentos-buses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Gestionar
                    </a>
                </div>

                <!-- Formulario -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-file-alt"></i> Información del Documento</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('documentos-buses.store') }}" method="POST" enctype="multipart/form-data" id="formDocumento">
                            @csrf

                            <div class="row">
                                <!-- Selección de Bus -->
                                <div class="col-md-6 mb-3">
                                    <label for="bus_id" class="form-label">
                                        <i class="fas fa-bus text-primary"></i> Bus <span class="text-danger">*</span>
                                    </label>
                                    <select name="bus_id" id="bus_id" class="form-select @error('bus_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un bus</option>
                                        @foreach($buses as $bus)
                                            <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
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
                                            <option value="{{ $key }}" {{ old('tipo_documento') == $key ? 'selected' : '' }}>
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
                                           value="{{ old('numero_documento') }}"
                                           placeholder="Ej: ABC-12345-2024" required>
                                    @error('numero_documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Archivo -->
                                <div class="col-md-6 mb-3">
                                    <label for="archivo" class="form-label">
                                        <i class="fas fa-upload text-primary"></i> Archivo Digital (Opcional)
                                    </label>
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
                                           value="{{ old('fecha_emision') }}"
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
                                           value="{{ old('fecha_vencimiento') }}" required>
                                    @error('fecha_vencimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="dias_vigencia" class="mt-2"></div>
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">
                                    <i class="fas fa-comment-alt text-primary"></i> Observaciones (Opcional)
                                </label>
                                <textarea name="observaciones" id="observaciones" rows="3"
                                          class="form-control @error('observaciones') is-invalid @enderror"
                                          placeholder="Notas adicionales sobre el documento...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alerta de Validación -->
                            <div id="alertaValidacion" class="alert alert-info d-none">
                                <i class="fas fa-info-circle"></i> <span id="mensajeValidacion"></span>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('documentos-buses.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Registrar Documento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="card shadow mt-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-lightbulb"></i> Información Importante</h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Los documentos con <strong>menos de 30 días</strong> para vencer mostrarán alerta amarilla</li>
                            <li>Los documentos vencidos mostrarán alerta roja</li>
                            <li>El sistema enviará notificaciones automáticas antes del vencimiento</li>
                            <li>Es recomendable subir el archivo digital del documento para consultas rápidas</li>
                        </ul>
                    </div>
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

            // Calcular días de vigencia
            function calcularDiasVigencia() {
                if (fechaEmision.value && fechaVencimiento.value) {
                    const emision = new Date(fechaEmision.value);
                    const vencimiento = new Date(fechaVencimiento.value);
                    const hoy = new Date();

                    // Validar que vencimiento sea mayor a emisión
                    if (vencimiento <= emision) {
                        diasVigencia.innerHTML = '<span class="badge bg-danger">La fecha de vencimiento debe ser posterior a la emisión</span>';
                        alertaValidacion.classList.remove('d-none', 'alert-info', 'alert-success');
                        alertaValidacion.classList.add('alert-danger');
                        mensajeValidacion.textContent = 'Fechas inválidas';
                        return;
                    }

                    const diffTime = vencimiento - hoy;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    let badgeClass = 'success';
                    let mensaje = '';

                    if (diffDays < 0) {
                        badgeClass = 'danger';
                        mensaje = `Este documento estará VENCIDO (${Math.abs(diffDays)} días atrás)`;
                        alertaValidacion.classList.remove('d-none', 'alert-info', 'alert-success');
                        alertaValidacion.classList.add('alert-warning');
                    } else if (diffDays <= 30) {
                        badgeClass = 'warning';
                        mensaje = `Este documento estará próximo a vencer`;
                        alertaValidacion.classList.remove('d-none', 'alert-danger', 'alert-success');
                        alertaValidacion.classList.add('alert-warning');
                    } else {
                        mensaje = `Documento válido por ${diffDays} días`;
                        alertaValidacion.classList.remove('d-none', 'alert-danger', 'alert-warning');
                        alertaValidacion.classList.add('alert-success');
                    }

                    diasVigencia.innerHTML = `<span class="badge bg-${badgeClass}">Vigencia: ${diffDays} días desde hoy</span>`;
                    mensajeValidacion.textContent = mensaje;
                }
            }

            // Preview de archivo
            archivoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    const fileType = file.type;

                    if (fileSize > 5) {
                        preview.innerHTML = '<span class="badge bg-danger">El archivo supera 5MB</span>';
                        archivoInput.value = '';
                        return;
                    }

                    preview.innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-file"></i> <strong>${file.name}</strong><br>
                    <small>Tamaño: ${fileSize} MB | Tipo: ${fileType}</small>
                </div>
            `;
                }
            });

            fechaEmision.addEventListener('change', calcularDiasVigencia);
            fechaVencimiento.addEventListener('change', calcularDiasVigencia);

            // Validar al enviar el formulario
            document.getElementById('formDocumento').addEventListener('submit', function(e) {
                const emision = new Date(fechaEmision.value);
                const vencimiento = new Date(fechaVencimiento.value);

                if (vencimiento <= emision) {
                    e.preventDefault();
                    alert('La fecha de vencimiento debe ser posterior a la fecha de emisión');
                    return false;
                }
            });
        });
    </script>

    <style>
        .card {
            border-radius: 10px;
        }
        .form-label {
            font-weight: 600;
        }
        .text-danger {
            font-weight: bold;
        }
    </style>
@endsection
