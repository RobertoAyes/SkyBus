{{--
    Vista parcial: recursos/vistas/documentos-buses/show-modal.blade.php
    Se retorna como HTML puro (sin layout) para inyectarse en el modal.
--}}
@php
    $statusColor     = 'primary';
    $statusIcon      = 'fa-check-circle';
    $statusAlertColor = 'alert-primary';

    if ($documento->estaVencido()) {
        $statusColor      = 'danger';
        $statusIcon       = 'fa-times-circle';
        $statusAlertColor = 'alert-danger';
    } elseif ($documento->estaPorVencer()) {
        $statusColor      = 'info';
        $statusIcon       = 'fa-exclamation-triangle';
        $statusAlertColor = 'alert-info';
    }
@endphp

<div class="row">
    {{-- Columna principal --}}
    <div class="col-md-8 border-end">

        {{-- Estado --}}
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3 text-{{ $statusColor }}">
                <i class="fas {{ $statusIcon }}"></i>
                Estado Actual:
                <span class="badge bg-{{ $statusColor }}">{{ strtoupper($documento->estado) }}</span>
            </h5>
            <div class="alert {{ $statusAlertColor }}">
                @if($documento->estaVencido())
                    <h6><i class="fas fa-times-circle"></i> Documento VENCIDO</h6>
                    <p class="mb-0">Este documento expiró hace <strong>{{ abs($documento->dias_hasta_vencimiento) }} días</strong> y requiere una renovación urgente.</p>
                @elseif($documento->estaPorVencer())
                    <h6><i class="fas fa-exclamation-triangle"></i> Próximo a Vencer</h6>
                    <p class="mb-0">Este documento vencerá en <strong>{{ $documento->dias_hasta_vencimiento }} días</strong>. Se recomienda iniciar el proceso de renovación.</p>
                @else
                    <h6><i class="fas fa-check-circle"></i> Documento Vigente</h6>
                    <p class="mb-0">Este documento es válido por <strong>{{ $documento->dias_hasta_vencimiento }} días</strong> más.</p>
                @endif
            </div>
        </div>

        {{-- Datos del documento --}}
        <h5 class="border-bottom pb-2 mb-3 text-primary">
            <i class="fas fa-file-contract"></i> Datos del Documento
        </h5>
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
            <div class="mt-3">
                <a href="{{ route('documentos-buses.descargar', $documento->id) }}"
                   class="btn btn-success btn-sm" target="_blank">
                    <i class="fas fa-download"></i> Descargar Archivo Digital
                </a>
            </div>
        @endif

        {{-- Historial --}}
        @if($documento->historial->count() > 0)
            <div class="mt-4">
                <h5 class="border-bottom pb-2 mb-3 text-secondary">
                    <i class="fas fa-history"></i> Historial de Cambios
                </h5>
                <div class="timeline">
                    @foreach($documento->historial->sortByDesc('created_at') as $historial)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content card card-body p-2 mb-2 bg-light">
                                <h6 class="mb-1 text-primary">{{ ucfirst($historial->accion) }}</h6>
                                <p class="mb-1 small">{{ $historial->descripcion }}</p>
                                <small class="text-muted">
                                    {{ $historial->created_at->format('d/m/Y H:i') }}
                                    por {{ $historial->usuario->name ?? 'Sistema' }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Columna lateral --}}
    <div class="col-md-4">
        {{-- Info del bus --}}
        <div class="card mb-3" style="background-color:#f0f7ff; border:1px solid #cce5ff;">
            <div class="card-header border-0">
                <h6 class="mb-0"><i class="fas fa-bus"></i> Información del Bus</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Placa:</strong> {{ $documento->bus->placa ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Modelo:</strong> {{ $documento->bus->modelo ?? 'N/A' }}</p>
                <p class="mb-0"><strong>Capacidad:</strong> {{ $documento->bus->capacidad ?? 'N/A' }} pasajeros</p>
            </div>
        </div>

        {{-- Acciones rápidas --}}
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color:#004d99;">
                <h6 class="mb-0"><i class="fas fa-bolt"></i> Acciones Rápidas</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    {{-- Botón editar: cierra este modal y abre el de edición --}}
                    <button type="button" class="btn btn-info text-white"
                            data-bs-dismiss="modal"
                            onclick="abrirModalEditar({{ $documento->id }})">
                        <i class="fas fa-edit"></i> Modificar Documento
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

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
    .detail-table th { font-weight: 600; color: #34495e; }
</style>

<script>
    // Función disponible globalmente para abrir modal editar desde el parcial
    function abrirModalEditar(id) {
        const modalEditarEl = document.getElementById('modalEditar');
        const modalEditar   = bootstrap.Modal.getOrCreateInstance(modalEditarEl);
        const body          = document.getElementById('modalEditarBody');

        body.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Cargando formulario...</p>
            </div>`;
        modalEditar.show();

        fetch(`/documentos-buses/${id}/editar-modal`)
            .then(r => r.text())
            .then(html => {
                body.innerHTML = html;
                // Re-inicializar listeners del form editar
                const ev = new CustomEvent('editarModalCargado');
                document.dispatchEvent(ev);
            });
    }
</script>
