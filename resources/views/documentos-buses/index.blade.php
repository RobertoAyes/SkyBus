@extends('layouts.layoutadmin')

@section('title', 'Gestión de Documentos')

@section('content')

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
            <i class="fas fa-file-alt me-2"></i> Registros de Documentos de Buses
        </h2>

        <!-- BOTÓN NUEVO -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
            <i class="fas fa-plus me-2"></i>Nuevo Documento
        </button>

    </div>

    <div class="card-body">

        <!-- ALERTA DE ÉXITO -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
                <i class="fas fa-circle-check me-2"></i>
                <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                <button class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- FILTROS -->
        <form method="GET" action="{{ route('documentos-buses.index') }}">
            <div class="mb-3">
                <label class="form-label fw-bold">Búsqueda General</label>

                <div class="row g-3 mb-3">
                    <div class="col-md-7">
                        <input type="text" name="search" class="form-control"
                               placeholder="Buscar por placa o documento..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-5 d-flex gap-2">
                        <button class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>

                        <button type="button" class="btn btn-outline-primary flex-fill"
                                data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                            <i class="fas fa-sliders-h me-2"></i>Filtros
                        </button>

                        @if(request()->hasAny(['search','estado','tipo_documento','fecha_emision']))
                            <a href="{{ route('documentos-buses.index') }}"
                               class="btn btn-outline-secondary flex-fill">
                                <i class="fas fa-times me-2"></i>Limpiar
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- FILTROS AVANZADOS -->
            <div class="collapse" id="filtrosAvanzados">
                <div class="card mb-3 bg-light border-primary">
                    <div class="card-header bg-primary bg-opacity-10">
                        <h6 class="mb-0 text-primary">Filtros Adicionales</h6>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-toggle-on text-success me-1"></i>Estado
                                </label>

                                <select name="estado" class="form-select select2" data-placeholder="Todos">
                                    <option value="">Todos</option>
                                    <option value="vigente" {{ request('estado')=='vigente'?'selected':'' }}>
                                        Vigente
                                    </option>
                                    <option value="por_vencer" {{ request('estado')=='por_vencer'?'selected':'' }}>
                                        Por vencer
                                    </option>
                                    <option value="vencido" {{ request('estado')=='vencido'?'selected':'' }}>
                                        Vencido
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-folder"></i> Tipo de Documento
                                </label>

                                <select name="tipo_documento" class="form-select select2" data-placeholder="Todos">
                                    <option value="">Todos</option>
                                    <option value="permiso_operacion"
                                        {{ request('tipo_documento')=='permiso_operacion'?'selected':'' }}>
                                        Permiso
                                    </option>
                                    <option value="revision_tecnica"
                                        {{ request('tipo_documento')=='revision_tecnica'?'selected':'' }}>
                                        Revisión
                                    </option>
                                    <option value="seguro_vehicular"
                                        {{ request('tipo_documento')=='seguro_vehicular'?'selected':'' }}>
                                        Seguro
                                    </option>
                                    <option value="matricula"
                                        {{ request('tipo_documento')=='matricula'?'selected':'' }}>
                                        Matrícula
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar text-primary me-1"></i>Fecha de Emisión
                                </label>

                                <input type="date"
                                       name="fecha_emision"
                                       class="form-control"
                                       value="{{ request('fecha_emision') }}">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 fw-semibold">Mostrar:</label>

                    <select name="per_page"
                            class="form-select form-select-sm border-primary"
                            style="width:90px;"
                            onchange="this.form.submit()">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>

                    <span>registros</span>
                </div>
            </div>
        </form>

        <!-- TABLA -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Bus</th>
                    <th>Tipo</th>
                    <th>N° Documento</th>
                    <th>Emisión</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
                </thead>

                <tbody>
                @forelse($documentos as $key => $doc)
                    <tr>
                        <td>{{ $documentos->firstItem() + $key }}</td>

                        <td>{{ $doc->bus->placa ?? '—' }}</td>

                        <td>{{ $doc->tipo_documento_nombre }}</td>

                        <td>{{ $doc->numero_documento }}</td>

                        <td>{{ $doc->fecha_emision->format('d/m/Y') }}</td>

                        <td>{{ $doc->fecha_vencimiento->format('d/m/Y') }}</td>

                        <td>{!! $doc->estado_badge !!}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <button class="btn btn-info btn-sm btn-ver"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalVer"
                                        data-id="{{ $doc->id }}">
                                    <i class="fas fa-eye me-1"></i> Ver
                                </button>

                                <button class="btn btn-primary btn-sm btn-editar"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditar"
                                        data-id="{{ $doc->id }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            No hay documentos registrados
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            <!-- PAGINACIÓN -->
            <div class="d-flex justify-content-end align-items-center mt-3">

                @if($documentos->hasPages())

                    <nav aria-label="Paginación de documentos">
                        <ul class="pagination pagination-sm mb-0">

                            <li class="page-item {{ $documentos->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link"
                                   href="{{ $documentos->previousPageUrl() }}">
                                    Anterior
                                </a>
                            </li>

                            @for($page = 1; $page <= $documentos->lastPage(); $page++)

                                <li class="page-item {{ $page == $documentos->currentPage() ? 'active' : '' }}">
                                    <a class="page-link"
                                       href="{{ $documentos->url($page) }}">
                                        {{ $page }}
                                    </a>
                                </li>

                            @endfor

                            <li class="page-item {{ $documentos->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link"
                                   href="{{ $documentos->nextPageUrl() }}">
                                    Siguiente
                                </a>
                            </li>

                        </ul>
                    </nav>

                @endif

            </div>

            <style>
                .pagination .page-link {
                    color: #1e63b8;
                    border-radius: 0.375rem;
                    border: 1px solid #dee2e6;
                    margin: 0 2px;
                }

                .pagination .page-link:hover {
                    background-color: #1e63b8;
                    color: #fff;
                }

                .pagination .page-item.active .page-link {
                    background-color: #1e63b8;
                    border-color: #1e63b8;
                    color: #fff;
                }

                .pagination .page-item.disabled .page-link {
                    color: #9ca3af;
                    background: #f3f4f6;
                    border-color: #e5e7eb;
                }

                .campo-error {
                    border-color: #dc3545 !important;
                }

                .mensaje-error-fecha {
                    color: #dc3545;
                    font-size: 0.875rem;
                    margin-top: 0.375rem;
                }
            </style>

        </div>
        ```

    </div>

    <!-- ========================================================= -->

    <!-- MODAL CREAR DOCUMENTO -->

    <!-- ========================================================= -->

    <div class="modal fade"
         id="modalCrear"
         tabindex="-1"
         aria-hidden="true">

        ```
        <div class="modal-dialog modal-dialog-centered"
             style="max-width: 640px;">

            <div class="modal-content border-0 rounded-3 shadow"
                 style="overflow: hidden;">

                <!-- HEADER -->
                <div class="modal-header text-white border-0"
                     style="background: #1e63b8; padding: 1.25rem 1.5rem;">

                    <div class="d-flex align-items-center gap-2">

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:34px; height:34px; background: rgba(255,255,255,0.2);">

                            <i class="fas fa-file-circle-plus"
                               style="font-size:13px;"></i>

                        </div>

                        <span style="font-size:15px; font-weight:500;">
                    Nuevo Documento
                </span>

                    </div>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- FORMULARIO -->
                <form action="{{ route('documentos-buses.store') }}"
                      method="POST">

                    @csrf

                    <div class="modal-body"
                         style="padding: 1.5rem;">

                        <div class="row g-3">

                            <!-- TIPO -->
                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Tipo Documento
                                </label>

                                <select name="tipo_documento"
                                        class="form-select {{ $errors->has('tipo_documento') ? 'campo-error' : '' }}"
                                        required>

                                    <option value="">Seleccione</option>

                                    <option value="permiso_operacion"
                                        {{ old('tipo_documento') == 'permiso_operacion' ? 'selected' : '' }}>
                                        Permiso
                                    </option>

                                    <option value="revision_tecnica"
                                        {{ old('tipo_documento') == 'revision_tecnica' ? 'selected' : '' }}>
                                        Revisión
                                    </option>

                                    <option value="seguro_vehicular"
                                        {{ old('tipo_documento') == 'seguro_vehicular' ? 'selected' : '' }}>
                                        Seguro
                                    </option>

                                    <option value="matricula"
                                        {{ old('tipo_documento') == 'matricula' ? 'selected' : '' }}>
                                        Matrícula
                                    </option>

                                </select>

                                @error('tipo_documento')
                                <div class="mensaje-error-fecha">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <!-- NÚMERO -->
                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Número Documento
                                </label>

                                <input type="text"
                                       name="numero_documento"
                                       class="form-control {{ $errors->has('numero_documento') ? 'campo-error' : '' }}"
                                       value="{{ old('numero_documento') }}"
                                       required>

                                @error('numero_documento')
                                <div class="mensaje-error-fecha">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <!-- FECHA EMISIÓN -->
                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Fecha Emisión
                                </label>

                                <input type="date"
                                       name="fecha_emision"
                                       class="form-control {{ $errors->has('fecha_emision') ? 'campo-error' : '' }}"
                                       value="{{ old('fecha_emision') }}"
                                       required>

                                @error('fecha_emision')
                                <div class="mensaje-error-fecha">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <!-- FECHA VENCIMIENTO -->
                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Fecha Vencimiento
                                </label>

                                <!--
                                    IMPORTANTE:
                                    NO se coloca min="" aquí.

                                    Esto permite seleccionar una fecha anterior
                                    a la fecha de emisión.

                                    El controlador será quien determine si puede
                                    guardarse o no.
                                -->
                                <input type="date"
                                       name="fecha_vencimiento"
                                       class="form-control {{ $errors->has('fecha_vencimiento') ? 'campo-error' : '' }}"
                                       value="{{ old('fecha_vencimiento') }}"
                                       required>

                                @error('fecha_vencimiento')
                                <div class="mensaje-error-fecha">
                                    <i class="fas fa-circle-exclamation me-1"></i>
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <!-- BUS -->
                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Bus
                                </label>

                                <select name="bus_id"
                                        class="form-select {{ $errors->has('bus_id') ? 'campo-error' : '' }}"
                                        required>

                                    <option value="">Seleccione</option>

                                    @foreach($buses as $bus)

                                        <option value="{{ $bus->id }}"
                                            {{ old('bus_id') == $bus->id ? 'selected' : '' }}>

                                            {{ $bus->numero_bus }} - {{ $bus->placa }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('bus_id')
                                <div class="mensaje-error-fecha">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer border-top d-flex justify-content-end gap-2"
                         style="border-color: #e5e7eb !important; padding: 1rem 1.5rem;">

                        <button type="button"
                                class="btn btn-sm btn-secondary d-flex align-items-center gap-2"
                                data-bs-dismiss="modal"
                                style="min-width: 100px; justify-content: center;">

                            <i class="fas fa-times"
                               style="font-size:12px;"></i>

                            Cancelar

                        </button>

                        <button type="submit"
                                class="btn btn-sm btn-primary d-flex align-items-center gap-2"
                                style="min-width: 100px; justify-content: center;">

                            <i class="fas fa-save"
                               style="font-size:12px;"></i>

                            Guardar

                        </button>

                    </div>

                </form>

            </div>

        </div>
        ```

    </div>

    <!-- ========================================================= -->

    <!-- MODAL VER DOCUMENTO -->

    <!-- ========================================================= -->

    <div class="modal fade"
         id="modalVer"
         tabindex="-1"
         aria-hidden="true">

        ```
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 rounded-3 shadow"
                 style="overflow: hidden;">

                <div class="modal-header text-white border-0"
                     style="background: #1e63b8; padding: 1.25rem 1.5rem;">

                    <div class="d-flex align-items-center gap-2">

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:34px; height:34px; background: rgba(255,255,255,0.2);">

                            <i class="fas fa-eye"
                               style="font-size:13px;"></i>

                        </div>

                        <span style="font-size:15px; font-weight:500;">
                    Detalle del Documento
                </span>

                    </div>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body"
                     id="contenidoVer"
                     style="padding: 1.5rem; min-height: 180px;">

                    <div class="text-center text-muted py-5">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                    </div>

                </div>

            </div>

        </div>
        ```

    </div>

    <!-- ========================================================= -->

    <!-- MODAL EDITAR DOCUMENTO -->

    <!-- ========================================================= -->

    <div class="modal fade"
         id="modalEditar"
         tabindex="-1"
         aria-hidden="true">

        ```
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 rounded-3 shadow"
                 style="overflow: hidden;">

                <div class="modal-header text-white border-0"
                     style="background: #1e63b8; padding: 1.25rem 1.5rem;">

                    <div class="d-flex align-items-center gap-2">

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:34px; height:34px; background: rgba(255,255,255,0.2);">

                            <i class="fas fa-edit"
                               style="font-size:13px;"></i>

                        </div>

                        <span style="font-size:15px; font-weight:500;">
                    Editar Documento
                </span>

                    </div>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body"
                     id="contenidoEditar"
                     style="padding: 1.5rem; min-height: 180px;">

                    <div class="text-center text-muted py-5">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                    </div>

                </div>

                <div class="modal-footer border-top d-flex justify-content-end gap-2"
                     style="border-color: #e5e7eb !important; padding: 1rem 1.5rem;">

                    <button type="button"
                            class="btn btn-sm btn-secondary d-flex align-items-center gap-2"
                            data-bs-dismiss="modal">

                        <i class="fas fa-times"
                           style="font-size:12px;"></i>

                        Cancelar

                    </button>

                    <button type="button"
                            class="btn btn-sm btn-primary d-flex align-items-center gap-2"
                            id="btnGuardarEdicion">

                        <i class="fas fa-save"
                           style="font-size:12px;"></i>

                        Guardar cambios

                    </button>

                </div>

            </div>

        </div>
        ```

    </div>

    <!-- Select2 CSS -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <!-- jQuery y Select2 JS -->

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {

            // Inicializar todos los selects con clase .select2
            $('.select2').each(function() {

                $(this).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: $(this).data('placeholder') || 'Seleccionar...',
                    allowClear: true,
                });

            });

            // VER documento
            $(document).on('click', '.btn-ver', function () {

                const id = $(this).data('id');

                $('#contenidoVer').html(
                    '<div class="text-center text-muted py-5">' +
                    '<i class="fas fa-spinner fa-spin fa-2x"></i>' +
                    '</div>'
                );

                $.get(`/documentos-buses/${id}/detalle-modal`, function (html) {

                    $('#contenidoVer').html(html);

                }).fail(function () {

                    $('#contenidoVer').html(
                        '<div class="alert alert-danger mb-0">' +
                        'No se pudo cargar el documento.' +
                        '</div>'
                    );

                });

            });

            // EDITAR documento
            $(document).on('click', '.btn-editar', function () {

                const id = $(this).data('id');

                $('#contenidoEditar').html(
                    '<div class="text-center text-muted py-5">' +
                    '<i class="fas fa-spinner fa-spin fa-2x"></i>' +
                    '</div>'
                );

                $.get(`/documentos-buses/${id}/editar-modal`, function (html) {

                    $('#contenidoEditar').html(html);

                }).fail(function () {

                    $('#contenidoEditar').html(
                        '<div class="alert alert-danger mb-0">' +
                        'No se pudo cargar el formulario de edición.' +
                        '</div>'
                    );

                });

            });

            // Enviar formulario de edición
            $(document).on('click', '#btnGuardarEdicion', function () {

                $('#formEditar').submit();

            });

            /*
             * IMPORTANTE:
             * Si Laravel devuelve errores de validación, se vuelve al index
             * y $errors contiene los errores.
             *
             * En ese caso volvemos a abrir automáticamente el modalCrear.
             *
             * Los valores no se pierden porque el formulario utiliza old().
             */
            @if($errors->any())

            const modalCrear = document.getElementById('modalCrear');

            if (modalCrear) {

                const modal = bootstrap.Modal.getOrCreateInstance(modalCrear);

                modal.show();

            }

            @endif

        });
    </script>

@endsection
