@extends('layouts.layoutadmin')

@section('title', 'Gestión de Documentación de Buses')

@section('content')
    <div class="container-fluid mt-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h2 class="h4 m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-alt"></i> Gestión de Documentación de Buses
                </h2>
                {{-- Ahora abre el modal de crear en lugar de ir a otra página --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
                    <i class="fas fa-plus"></i> Nuevo Documento
                </button>
            </div>

            <div class="card-body">

                <!-- Tarjetas de Estadísticas -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col me-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Documentos</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['total'] }}</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-file-alt fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col me-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Vigentes</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['vigentes'] }}</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col me-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Por Vencer</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['por_vencer'] }}</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col me-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Vencidos</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['vencidos'] }}</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- Filtros -->
                <div class="mb-4 p-3 bg-light rounded shadow-sm">
                    <h5 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-filter"></i> Opciones de Filtrado
                    </h5>
                    <form method="GET" action="{{ route('documentos-buses.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4 col-lg-3">
                                <label for="search" class="form-label">Buscar:</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       placeholder="Placa o N de documento..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="estado" class="form-label">Estado:</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="vigente" {{ request('estado') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                                    <option value="por_vencer" {{ request('estado') == 'por_vencer' ? 'selected' : '' }}>Por Vencer</option>
                                    <option value="vencido" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
                                <select name="tipo_documento" id="tipo_documento" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="permiso_operacion" {{ request('tipo_documento') == 'permiso_operacion' ? 'selected' : '' }}>Permiso de Operación</option>
                                    <option value="revision_tecnica" {{ request('tipo_documento') == 'revision_tecnica' ? 'selected' : '' }}>Revisión Técnica</option>
                                    <option value="seguro_vehicular" {{ request('tipo_documento') == 'seguro_vehicular' ? 'selected' : '' }}>Seguro Vehicular</option>
                                    <option value="matricula" {{ request('tipo_documento') == 'matricula' ? 'selected' : '' }}>Matrícula</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="bus_id" class="form-label">Bus:</label>
                                <select name="bus_id" id="bus_id" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($buses as $bus)
                                        <option value="{{ $bus->id }}" {{ request('bus_id') == $bus->id ? 'selected' : '' }}>
                                            {{ $bus->numero_bus }} - {{ $bus->placa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-2 d-flex align-items-end pt-3 pt-md-0">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <hr class="mt-4 mb-4">

                <!-- Tabla de Documentos -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark m-0">
                        <i class="fas fa-list"></i> Listado de Documentos
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-primary text-white">
                        <tr>
                            <th>Bus / Placa</th>
                            <th>Tipo Documento</th>
                            <th>N° Documento</th>
                            <th>Emisión</th>
                            <th>Vencimiento</th>
                            <th>Días Restantes</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($documentos as $documento)
                            <tr class="{{ $documento->estado === 'vencido' ? 'table-danger' : ($documento->estado === 'por_vencer' ? 'table-warning' : '') }}">
                                <td>
                                    <small class="text-muted">{{ $documento->bus->placa ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $documento->tipo_documento_nombre }}</td>
                                <td>{{ $documento->numero_documento }}</td>
                                <td>{{ $documento->fecha_emision->format('d/m/Y') }}</td>
                                <td>{{ $documento->fecha_vencimiento->format('d/m/Y') }}</td>
                                <td>
                                    @if($documento->dias_hasta_vencimiento < 0)
                                        <span class="badge bg-danger">Vencido ({{ abs($documento->dias_hasta_vencimiento) }} días)</span>
                                    @else
                                        <span class="badge {{ $documento->dias_hasta_vencimiento <= 30 ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ $documento->dias_hasta_vencimiento }} días
                                        </span>
                                    @endif
                                </td>
                                <td>{!! $documento->estado_badge !!}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        {{-- Ver detalles en modal --}}
                                        <button type="button"
                                                class="btn btn-sm btn-info text-white btn-ver-detalle"
                                                data-id="{{ $documento->id }}"
                                                title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        {{-- Editar en modal --}}
                                        <button type="button"
                                                class="btn btn-sm btn-primary btn-editar"
                                                data-id="{{ $documento->id }}"
                                                title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        {{-- Descargar archivo --}}
                                        @if($documento->archivo_url)
                                            <a href="{{ route('documentos-buses.descargar', $documento->id) }}"
                                               class="btn btn-sm btn-success" title="Descargar archivo">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        {{-- Eliminar --}}
                                        <button type="button"
                                                class="btn btn-sm btn-danger btn-eliminar"
                                                data-id="{{ $documento->id }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $documento->id }}"
                                              action="{{ route('documentos-buses.destroy', $documento->id) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                    <p class="text-muted h5">No se encontraron documentos.</p>
                                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
                                        <i class="fas fa-plus"></i> Registrar documento
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Mostrando {{ $documentos->firstItem() ?? 0 }} a {{ $documentos->lastItem() ?? 0 }}
                        de {{ $documentos->total() }} documentos
                    </div>
                    <div>{{ $documentos->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
         MODAL: CREAR NUEVO DOCUMENTO
    ================================================================ --}}
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalCrearLabel">
                        <i class="fas fa-file-medical"></i> Registrar Nuevo Documento
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('documentos-buses.store') }}" method="POST" enctype="multipart/form-data" id="formCrear">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_bus_id" class="form-label">
                                    <i class="fas fa-bus text-primary"></i> Bus <span class="text-danger">*</span>
                                </label>
                                <select name="bus_id" id="crear_bus_id" class="form-select" required>
                                    <option value="">Seleccione un bus</option>
                                    @foreach($buses as $bus)
                                        <option value="{{ $bus->id }}">
                                            Bus {{ $bus->numero_bus }} - Placa: {{ $bus->placa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_tipo_documento" class="form-label">
                                    <i class="fas fa-file-contract text-primary"></i> Tipo de Documento <span class="text-danger">*</span>
                                </label>
                                <select name="tipo_documento" id="crear_tipo_documento" class="form-select" required>
                                    <option value="">Seleccione tipo</option>
                                    <option value="permiso_operacion">Permiso de Operación</option>
                                    <option value="revision_tecnica">Revisión Técnica</option>
                                    <option value="seguro_vehicular">Seguro Vehicular</option>
                                    <option value="matricula">Matrícula</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_numero_documento" class="form-label">
                                    <i class="fas fa-hashtag text-primary"></i> Número de Documento <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="numero_documento" id="crear_numero_documento"
                                       class="form-control" placeholder="Ej: ABC-12345-2024" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_archivo" class="form-label">
                                    <i class="fas fa-upload text-primary"></i> Archivo Digital (Opcional)
                                </label>
                                <input type="file" name="archivo" id="crear_archivo"
                                       class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Formatos: PDF, JPG, PNG. Máximo 5MB</small>
                                <div id="crear_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_fecha_emision" class="form-label">
                                    <i class="fas fa-calendar-plus text-primary"></i> Fecha de Emisión <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="fecha_emision" id="crear_fecha_emision"
                                       class="form-control" max="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_fecha_vencimiento" class="form-label">
                                    <i class="fas fa-calendar-times text-primary"></i> Fecha de Vencimiento <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="fecha_vencimiento" id="crear_fecha_vencimiento"
                                       class="form-control" required>
                                <div id="crear_dias_vigencia" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="crear_observaciones" class="form-label">
                                <i class="fas fa-comment-alt text-primary"></i> Observaciones (Opcional)
                            </label>
                            <textarea name="observaciones" id="crear_observaciones" rows="3"
                                      class="form-control" placeholder="Notas adicionales..."></textarea>
                        </div>
                        <div id="crear_alerta" class="alert d-none"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnGuardarCrear">
                        <i class="fas fa-save"></i> Registrar Documento
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
         MODAL: VER DETALLES
    ================================================================ --}}
    <div class="modal fade" id="modalDetalle" tabindex="-1" aria-labelledby="modalDetalleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalDetalleLabel">
                        <i class="fas fa-info-circle"></i> Detalles del Documento
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalDetalleBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando información...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
         MODAL: EDITAR DOCUMENTO
    ================================================================ --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarLabel">
                        <i class="fas fa-edit"></i> Editar Documento
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalEditarBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando formulario...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnGuardarEditar">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
         MODAL: CONFIRMAR ELIMINACIÓN
    ================================================================ --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalEliminarLabel">
                        <i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="h6">¿Está seguro que desea eliminar este documento?</p>
                    <small class="text-muted">Esta acción no se puede deshacer.</small>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
        .card.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
        .card.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
        .card.border-left-danger  { border-left: 0.25rem solid #e74a3b !important; }

        /* Timeline en modal detalle */
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

        .bg-dark-blue { background-color: #004d99 !important; }
        .bg-light-blue { background-color: #f0f7ff; border: 1px solid #cce5ff; }

        @media (max-width: 768px) {
            .table-responsive .table td:nth-child(5),
            .table-responsive .table th:nth-child(5),
            .table-responsive .table td:nth-child(6),
            .table-responsive .table th:nth-child(6) { display: none; }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ─── UTILIDADES ────────────────────────────────────────────────────────────

            function calcularDias(inputEmision, inputVencimiento, badgeContainer, alertContainer) {
                if (!inputEmision.value || !inputVencimiento.value) return;

                const emision    = new Date(inputEmision.value);
                const vencimiento = new Date(inputVencimiento.value);
                const hoy        = new Date();

                if (vencimiento <= emision) {
                    badgeContainer.innerHTML = '<span class="badge bg-danger">La fecha de vencimiento debe ser posterior a la emisión</span>';
                    if (alertContainer) {
                        alertContainer.className = 'alert alert-danger';
                        alertContainer.textContent = 'Fechas inválidas';
                    }
                    return;
                }

                const diffDays = Math.ceil((vencimiento - hoy) / (1000 * 60 * 60 * 24));
                let badgeClass = 'success', alertClass = 'alert-success', mensaje = '';

                if (diffDays < 0) {
                    badgeClass = 'danger'; alertClass = 'alert-warning';
                    mensaje = `Este documento estará VENCIDO (${Math.abs(diffDays)} días atrás)`;
                } else if (diffDays <= 30) {
                    badgeClass = 'warning'; alertClass = 'alert-warning';
                    mensaje = `Este documento estará próximo a vencer en ${diffDays} días`;
                } else {
                    mensaje = `✓ Documento válido por ${diffDays} días`;
                }

                badgeContainer.innerHTML = `<span class="badge bg-${badgeClass}">Vigencia: ${diffDays} días desde hoy</span>`;
                if (alertContainer) {
                    alertContainer.className = `alert ${alertClass}`;
                    alertContainer.textContent = mensaje;
                }
            }

            function validarArchivo(input, previewContainer) {
                const file = input.files[0];
                if (!file) return true;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                if (fileSize > 5) {
                    previewContainer.innerHTML = '<span class="badge bg-danger">El archivo supera 5MB</span>';
                    input.value = '';
                    return false;
                }
                previewContainer.innerHTML = `
            <div class="alert alert-success p-2">
                <i class="fas fa-file"></i> <strong>${file.name}</strong>
                <small class="d-block">Tamaño: ${fileSize} MB</small>
            </div>`;
                return true;
            }

            // ─── MODAL CREAR ───────────────────────────────────────────────────────────

            const crearEmision      = document.getElementById('crear_fecha_emision');
            const crearVencimiento  = document.getElementById('crear_fecha_vencimiento');
            const crearDias         = document.getElementById('crear_dias_vigencia');
            const crearAlerta       = document.getElementById('crear_alerta');
            const crearArchivo      = document.getElementById('crear_archivo');
            const crearPreview      = document.getElementById('crear_preview');

            crearEmision.addEventListener('change',     () => calcularDias(crearEmision, crearVencimiento, crearDias, crearAlerta));
            crearVencimiento.addEventListener('change', () => calcularDias(crearEmision, crearVencimiento, crearDias, crearAlerta));
            crearArchivo.addEventListener('change',     () => validarArchivo(crearArchivo, crearPreview));

            document.getElementById('btnGuardarCrear').addEventListener('click', function () {
                const emision    = new Date(crearEmision.value);
                const vencimiento = new Date(crearVencimiento.value);
                if (vencimiento <= emision) {
                    crearAlerta.className = 'alert alert-danger';
                    crearAlerta.textContent = 'La fecha de vencimiento debe ser posterior a la fecha de emisión.';
                    return;
                }
                document.getElementById('formCrear').submit();
            });

            // Limpiar modal crear al cerrar
            document.getElementById('modalCrear').addEventListener('hidden.bs.modal', function () {
                document.getElementById('formCrear').reset();
                crearDias.innerHTML   = '';
                crearPreview.innerHTML = '';
                crearAlerta.className = 'alert d-none';
                crearAlerta.textContent = '';
            });

            // ─── MODAL VER DETALLE ─────────────────────────────────────────────────────

            const modalDetalle     = new bootstrap.Modal(document.getElementById('modalDetalle'));
            const modalDetalleBody = document.getElementById('modalDetalleBody');

            document.querySelectorAll('.btn-ver-detalle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    modalDetalleBody.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Cargando información...</p>
                </div>`;
                    modalDetalle.show();

                    fetch(`/documentos-buses/${id}/detalle-modal`)
                        .then(res => {
                            if (!res.ok) throw new Error('Error al cargar');
                            return res.text();
                        })
                        .then(html => { modalDetalleBody.innerHTML = html; })
                        .catch(() => {
                            modalDetalleBody.innerHTML = `<div class="alert alert-danger">Error al cargar los detalles.</div>`;
                        });
                });
            });

            // ─── MODAL EDITAR ──────────────────────────────────────────────────────────

            const modalEditar     = new bootstrap.Modal(document.getElementById('modalEditar'));
            const modalEditarBody = document.getElementById('modalEditarBody');
            let   editarDocumentoId = null;

            document.querySelectorAll('.btn-editar').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    editarDocumentoId = this.dataset.id;
                    modalEditarBody.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Cargando formulario...</p>
                </div>`;
                    modalEditar.show();

                    fetch(`/documentos-buses/${editarDocumentoId}/editar-modal`)
                        .then(res => {
                            if (!res.ok) throw new Error('Error al cargar');
                            return res.text();
                        })
                        .then(html => {
                            modalEditarBody.innerHTML = html;
                            inicializarFormEditar();
                        })
                        .catch(() => {
                            modalEditarBody.innerHTML = `<div class="alert alert-danger">Error al cargar el formulario.</div>`;
                        });
                });
            });

            function inicializarFormEditar() {
                const editEmision     = document.getElementById('editar_fecha_emision');
                const editVencimiento = document.getElementById('editar_fecha_vencimiento');
                const editDias        = document.getElementById('editar_dias_vigencia');
                const editAlerta      = document.getElementById('editar_alerta');
                const editArchivo     = document.getElementById('editar_archivo');
                const editPreview     = document.getElementById('editar_preview');

                if (editEmision && editVencimiento) {
                    calcularDias(editEmision, editVencimiento, editDias, editAlerta);
                    editEmision.addEventListener('change',     () => calcularDias(editEmision, editVencimiento, editDias, editAlerta));
                    editVencimiento.addEventListener('change', () => calcularDias(editEmision, editVencimiento, editDias, editAlerta));
                }
                if (editArchivo) {
                    editArchivo.addEventListener('change', () => validarArchivo(editArchivo, editPreview));
                }
            }

            document.getElementById('btnGuardarEditar').addEventListener('click', function () {
                const form = document.getElementById('formEditar');
                if (!form) return;

                const editEmision     = document.getElementById('editar_fecha_emision');
                const editVencimiento = document.getElementById('editar_fecha_vencimiento');
                const editAlerta      = document.getElementById('editar_alerta');

                if (editEmision && editVencimiento) {
                    const emision    = new Date(editEmision.value);
                    const vencimiento = new Date(editVencimiento.value);
                    if (vencimiento <= emision) {
                        if (editAlerta) {
                            editAlerta.className = 'alert alert-danger';
                            editAlerta.textContent = 'La fecha de vencimiento debe ser posterior a la fecha de emisión.';
                        }
                        return;
                    }
                }
                form.submit();
            });

            // ─── MODAL ELIMINAR ────────────────────────────────────────────────────────

            const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'));
            let   formEliminar  = null;

            document.querySelectorAll('.btn-eliminar').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    formEliminar = document.getElementById(`delete-form-${id}`);
                    modalEliminar.show();
                });
            });

            document.getElementById('btnConfirmarEliminar').addEventListener('click', function () {
                if (formEliminar) formEliminar.submit();
            });

            document.getElementById('modalEliminar').addEventListener('hidden.bs.modal', function () {
                formEliminar = null;
            });

        });
    </script>
@endsection
