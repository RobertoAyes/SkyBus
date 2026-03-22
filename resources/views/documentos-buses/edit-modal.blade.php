{{--
    Vista parcial: recursos/vistas/documentos-buses/edit-modal.blade.php
    Se retorna como HTML puro (sin layout) para inyectarse en el modal.
--}}
@php
    $diasRestantes = $documento->dias_hasta_vencimiento;
    if ($documento->estaVencido()) {
        $alertColor = 'danger';
        $alertMsg   = 'Este documento está VENCIDO desde hace ' . abs($diasRestantes) . ' días.';
    } elseif ($documento->estaPorVencer()) {
        $alertColor = 'warning';
        $alertMsg   = 'Este documento vencerá en ' . $diasRestantes . ' días.';
    } else {
        $alertColor = 'success';
        $alertMsg   = 'Este documento está vigente por ' . $diasRestantes . ' días más.';
    }
@endphp

{{-- Estado actual del documento --}}
<div class="alert alert-{{ $alertColor }} d-flex align-items-center mb-3">
    <i class="fas fa-info-circle fa-lg me-2"></i>
    <span>{{ $alertMsg }}</span>
</div>

<form action="{{ route('documentos-buses.update', $documento->id) }}"
      method="POST" enctype="multipart/form-data" id="formEditar">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="editar_bus_id" class="form-label">
                <i class="fas fa-bus text-primary"></i> Bus <span class="text-danger">*</span>
            </label>
            <select name="bus_id" id="editar_bus_id" class="form-select" required>
                <option value="">Seleccione un bus</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}"
                        {{ $documento->bus_id == $bus->id ? 'selected' : '' }}>
                        Bus {{ $bus->numero_bus }} - Placa: {{ $bus->placa }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="editar_tipo_documento" class="form-label">
                <i class="fas fa-file-contract text-primary"></i> Tipo de Documento <span class="text-danger">*</span>
            </label>
            <select name="tipo_documento" id="editar_tipo_documento" class="form-select" required>
                <option value="">Seleccione tipo</option>
                @foreach($tiposDocumento as $key => $tipo)
                    <option value="{{ $key }}"
                        {{ $documento->tipo_documento == $key ? 'selected' : '' }}>
                        {{ $tipo }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="editar_numero_documento" class="form-label">
                <i class="fas fa-hashtag text-primary"></i> Número de Documento <span class="text-danger">*</span>
            </label>
            <input type="text" name="numero_documento" id="editar_numero_documento"
                   class="form-control"
                   value="{{ $documento->numero_documento }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="editar_archivo" class="form-label">
                <i class="fas fa-upload text-primary"></i> Archivo Digital
            </label>
            @if($documento->archivo_url)
                <div class="alert alert-info p-2 mb-2 d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-file"></i> Archivo actual:
                        <a href="{{ route('documentos-buses.descargar', $documento->id) }}" target="_blank">Descargar</a>
                    </span>
                    <small class="text-muted">Subir uno nuevo reemplazará el actual</small>
                </div>
            @endif
            <input type="file" name="archivo" id="editar_archivo"
                   class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            <small class="text-muted">Formatos: PDF, JPG, PNG. Máximo 5MB</small>
            <div id="editar_preview" class="mt-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="editar_fecha_emision" class="form-label">
                <i class="fas fa-calendar-plus text-primary"></i> Fecha de Emisión <span class="text-danger">*</span>
            </label>
            <input type="date" name="fecha_emision" id="editar_fecha_emision"
                   class="form-control"
                   value="{{ $documento->fecha_emision->format('Y-m-d') }}"
                   max="{{ date('Y-m-d') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="editar_fecha_vencimiento" class="form-label">
                <i class="fas fa-calendar-times text-primary"></i> Fecha de Vencimiento <span class="text-danger">*</span>
            </label>
            <input type="date" name="fecha_vencimiento" id="editar_fecha_vencimiento"
                   class="form-control"
                   value="{{ $documento->fecha_vencimiento->format('Y-m-d') }}" required>
            <div id="editar_dias_vigencia" class="mt-2"></div>
        </div>
    </div>

    <div class="mb-3">
        <label for="editar_observaciones" class="form-label">
            <i class="fas fa-comment-alt text-primary"></i> Observaciones
        </label>
        <textarea name="observaciones" id="editar_observaciones" rows="3"
                  class="form-control">{{ $documento->observaciones }}</textarea>
    </div>

    <div id="editar_alerta" class="alert d-none"></div>
</form>

{{-- Historial (si existe) --}}
@if($documento->historial->count() > 0)
    <hr>
    <h6 class="text-secondary"><i class="fas fa-history"></i> Historial de Cambios</h6>
    <div class="timeline mt-2">
        @foreach($documento->historial->sortByDesc('created_at') as $historial)
            <div class="timeline-item">
                <div class="timeline-marker bg-primary"></div>
                <div class="timeline-content card card-body p-2 mb-2 bg-light">
                    <h6 class="mb-1 text-primary small">{{ ucfirst($historial->accion) }}</h6>
                    <p class="mb-1 small">{{ $historial->descripcion }}</p>
                    <small class="text-muted">
                        {{ $historial->created_at->format('d/m/Y H:i') }}
                        por {{ $historial->usuario->name ?? 'Sistema' }}
                    </small>
                </div>
            </div>
        @endforeach
    </div>
@endif

<style>
    .timeline { position: relative; padding: 0; list-style: none; }
    .timeline-item { position: relative; padding-left: 30px; }
    .timeline-marker {
        position: absolute; left: 0; top: 6px;
        width: 10px; height: 10px; border-radius: 50%;
        background-color: #0d6efd; z-index: 1;
    }
    .timeline::before {
        content: ''; position: absolute;
        top: 0; bottom: 0; left: 4px;
        width: 2px; background-color: #dee2e6;
    }
</style>
