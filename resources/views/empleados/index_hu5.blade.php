@extends('layouts.layoutadmin')

@section('title', 'Panel Administrativo')

@section('content')

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
            <i class="fas fa-users me-2"></i>Empleados
        </h2>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#crearEmpleadoModal">
            <i class="fas fa-plus me-2"></i>Nuevo Empleado
        </button>

    </div>

    <div class="card-body">

        {{-- MENSAJE DE ÉXITO --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                <strong class="me-2">¡Éxito!</strong> {{ session('success') }}

                <button type="button"
                        class="btn-close ms-auto"
                        data-bs-dismiss="alert"
                        aria-label="Cerrar">
                </button>
            </div>
        @endif


        {{-- =========================================================
             BÚSQUEDA Y FILTROS
             ========================================================= --}}
        <form method="GET"
              action="{{ route('empleados.hu5') }}"
              class="mb-4">

            <div class="mb-3">
                <label class="form-label fw-bold">
                    Búsqueda General
                </label>

                <div class="row g-3 mb-3">

                    <div class="col-md-7">
                        <div class="input-group">
                            <input type="text"
                                   name="buscar"
                                   class="form-control"
                                   placeholder="Buscar por nombre, apellido o cargo"
                                   value="{{ request('buscar') }}">
                        </div>
                    </div>

                    <div class="col-md-5 d-flex align-items-end gap-2">

                        <button class="btn btn-primary flex-fill"
                                type="submit">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>

                        <button class="btn btn-outline-primary flex-fill"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#filtrosAvanzados">
                            <i class="fas fa-sliders-h me-2"></i>Filtros
                        </button>

                        @if(request()->hasAny(['buscar','rol','estado','fecha_registro']))
                            <a href="{{ route('empleados.hu5') }}"
                               class="btn btn-outline-secondary flex-fill">
                                <i class="fas fa-times me-2"></i>Limpiar
                            </a>
                        @endif

                    </div>
                </div>
            </div>


            {{-- FILTROS AVANZADOS --}}
            <div class="collapse" id="filtrosAvanzados">

                <div class="card mb-3 bg-light border-primary">

                    <div class="card-header bg-primary bg-opacity-10">
                        <h6 class="mb-0 text-primary">
                            <i class="fas fa-filter me-2"></i>
                            Filtros Adicionales
                        </h6>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user-tag text-primary me-2"></i>
                                    Rol
                                </label>

                                <select name="rol"
                                        class="form-select">

                                    <option value="">Todos</option>

                                    <option value="Administrador"
                                        {{ request('rol') == 'Administrador' ? 'selected' : '' }}>
                                        Administrador
                                    </option>

                                    <option value="Empleado"
                                        {{ request('rol') == 'Empleado' ? 'selected' : '' }}>
                                        Empleado
                                    </option>

                                    <option value="Chofer"
                                        {{ request('rol') == 'Chofer' ? 'selected' : '' }}>
                                        Chofer
                                    </option>

                                </select>
                            </div>


                            <div class="col-md-4">

                                <label class="form-label fw-bold">
                                    <i class="fas fa-toggle-on text-success me-1"></i>
                                    Estado
                                </label>

                                <select name="estado"
                                        class="form-select">

                                    <option value="">Todos</option>

                                    <option value="Activo"
                                        {{ request('estado') == 'Activo' ? 'selected' : '' }}>
                                        Activo
                                    </option>

                                    <option value="Inactivo"
                                        {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>
                                        Inactivo
                                    </option>

                                </select>

                            </div>


                            <div class="col-md-4">

                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar text-primary me-1"></i>
                                    Fecha de Registro
                                </label>

                                <input type="date"
                                       name="fecha_registro"
                                       class="form-control"
                                       value="{{ request('fecha_registro') }}">

                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- MOSTRAR REGISTROS --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div class="d-flex align-items-center gap-2">

                    <label class="mb-0 fw-semibold">
                        Mostrar:
                    </label>

                    <select name="per_page"
                            class="form-select form-select-sm border-primary"
                            style="width:90px;"
                            onchange="this.form.submit()">

                        <option value="5"
                            {{ request('per_page', 5) == 5 ? 'selected' : '' }}>
                            5
                        </option>

                        <option value="10"
                            {{ request('per_page') == 10 ? 'selected' : '' }}>
                            10
                        </option>

                        <option value="25"
                            {{ request('per_page') == 25 ? 'selected' : '' }}>
                            25
                        </option>

                        <option value="50"
                            {{ request('per_page') == 50 ? 'selected' : '' }}>
                            50
                        </option>

                    </select>

                    <span>registros</span>

                </div>

            </div>

        </form>


        {{-- =========================================================
             TABLA DE EMPLEADOS
             ========================================================= --}}
        <div class="table-responsive">

            <table class="table table-hover table-bordered align-middle">

                <thead class="table-primary">

                <tr>
                    <th style="width:60px;" class="text-center">#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Fecha Ingreso</th>
                    <th class="text-center">Acciones</th>
                </tr>

                </thead>

                <tbody>

                @forelse($empleados as $key => $empleado)

                    <tr>

                        <td class="text-center">
                            {{ ($empleados->currentPage() - 1) * $empleados->perPage() + $key + 1 }}
                        </td>

                        <td>{{ $empleado->nombre }}</td>

                        <td>{{ $empleado->apellido }}</td>

                        <td>{{ $empleado->cargo }}</td>

                        <td>
                    <span class="badge bg-primary">
                        {{ $empleado->rol }}
                    </span>
                        </td>

                        <td>
                    <span class="badge {{ $empleado->estado == 'Activo' ? 'bg-success' : 'bg-danger' }}">
                        {{ $empleado->estado }}
                    </span>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}
                        </td>

                        <td class="text-center">

                            <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editarEmpleadoModal{{ $empleado->id }}">

                                <i class="fas fa-edit me-1"></i>
                                Editar

                            </button>

                        </td>

                    </tr>


                    {{-- =================================================
                         MODAL EDITAR
                         ================================================= --}}
                    <div class="modal fade"
                         id="editarEmpleadoModal{{ $empleado->id }}"
                         tabindex="-1"
                         aria-hidden="true">

                        <div class="modal-dialog modal-lg modal-dialog-centered">

                            <div class="modal-content border-0 rounded-3"
                                 style="overflow:hidden;">

                                <div class="modal-header text-white border-0"
                                     style="background:#1e63b8;padding:1.25rem 1.5rem;">

                                    <div class="d-flex align-items-center gap-2">

                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width:34px;height:34px;background:rgba(255,255,255,0.2);">

                                            <i class="fas fa-user-edit"
                                               style="font-size:13px;">
                                            </i>

                                        </div>

                                        <span style="font-size:15px;font-weight:500;">
                                    Editar Empleado
                                </span>

                                    </div>

                                    <button type="button"
                                            class="btn-close btn-close-white"
                                            data-bs-dismiss="modal">
                                    </button>

                                </div>


                                {{-- FORMULARIO EDITAR --}}
                                <form method="POST"
                                      action="{{ route('empleados.hu5.update', $empleado->id) }}"
                                      enctype="multipart/form-data"
                                      novalidate
                                      class="form-validar-empleado">

                                    @csrf
                                    @method('PUT')

                                    {{-- IMPORTANTE:
                                         Permite saber qué modal se estaba editando --}}
                                    <input type="hidden"
                                           name="_empleado_editando"
                                           value="{{ $empleado->id }}">


                                    <div class="modal-body"
                                         style="padding:1.5rem;">

                                        <div class="row g-3">


                                            {{-- NOMBRE --}}
                                            <div class="col-md-6">

                                                <label class="text-muted small">
                                                    Nombre
                                                </label>

                                                <input type="text"
                                                       name="nombre"
                                                       value="{{ old('_empleado_editando') == $empleado->id ? old('nombre') : $empleado->nombre }}"
                                                       class="form-control @if(old('_empleado_editando') == $empleado->id && $errors->has('nombre')) is-invalid @endif"
                                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                                       data-mensaje="El nombre solo puede contener letras y espacios."
                                                       required>

                                                <div class="invalid-feedback">
                                                    @if(old('_empleado_editando') == $empleado->id)
                                                        @error('nombre')
                                                        {{ $message }}
                                                        @enderror
                                                    @endif
                                                </div>

                                            </div>


                                            {{-- APELLIDO --}}
                                            <div class="col-md-6">

                                                <label class="text-muted small">
                                                    Apellido
                                                </label>

                                                <input type="text"
                                                       name="apellido"
                                                       value="{{ old('_empleado_editando') == $empleado->id ? old('apellido') : $empleado->apellido }}"
                                                       class="form-control @if(old('_empleado_editando') == $empleado->id && $errors->has('apellido')) is-invalid @endif"
                                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                                       data-mensaje="El apellido solo puede contener letras y espacios."
                                                       required>

                                                <div class="invalid-feedback">
                                                    @if(old('_empleado_editando') == $empleado->id)
                                                        @error('apellido')
                                                        {{ $message }}
                                                        @enderror
                                                    @endif
                                                </div>

                                            </div>


                                            {{-- DNI --}}
                                            <div class="col-md-6">

                                                <label class="text-muted small">
                                                    DNI
                                                </label>

                                                <input type="text"
                                                       name="dni"
                                                       value="{{ old('_empleado_editando') == $empleado->id ? old('dni') : $empleado->dni }}"
                                                       class="form-control @if(old('_empleado_editando') == $empleado->id && $errors->has('dni')) is-invalid @endif"
                                                       inputmode="numeric"
                                                       maxlength="13"
                                                       data-pattern="^[0-9]{13}$"
                                                       data-mensaje="El DNI debe contener exactamente 13 números."
                                                       required>

                                                <div class="invalid-feedback">
                                                    @if(old('_empleado_editando') == $empleado->id)
                                                        @error('dni')
                                                        {{ $message }}
                                                        @enderror
                                                    @endif
                                                </div>

                                            </div>


                                            {{-- CARGO --}}
                                            <div class="col-md-6">

                                                <label class="text-muted small">
                                                    Cargo
                                                </label>

                                                <input type="text"
                                                       name="cargo"
                                                       value="{{ old('_empleado_editando') == $empleado->id ? old('cargo') : $empleado->cargo }}"
                                                       class="form-control @if(old('_empleado_editando') == $empleado->id && $errors->has('cargo')) is-invalid @endif"
                                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                                       data-mensaje="El cargo solo puede contener letras y espacios."
                                                       required>

                                                <div class="invalid-feedback">
                                                    @if(old('_empleado_editando') == $empleado->id)
                                                        @error('cargo')
                                                        {{ $message }}
                                                        @enderror
                                                    @endif
                                                </div>

                                            </div>


                                            {{-- FECHA --}}
                                            <div class="col-md-6">

                                                <label class="text-muted small">
                                                    Fecha ingreso
                                                </label>

                                                <input type="date"
                                                       name="fecha_ingreso"
                                                       value="{{ old('_empleado_editando') == $empleado->id ? old('fecha_ingreso') : \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('Y-m-d') }}"
                                                       class="form-control @if(old('_empleado_editando') == $empleado->id && $errors->has('fecha_ingreso')) is-invalid @endif"
                                                       required>

                                                <div class="invalid-feedback">
                                                    @if(old('_empleado_editando') == $empleado->id)
                                                        @error('fecha_ingreso')
                                                        {{ $message }}
                                                        @enderror
                                                    @endif
                                                </div>

                                            </div>


                                            {{-- ROL --}}
                                            <div class="col-md-6">

                                                <label class="text-muted small">
                                                    Rol
                                                </label>

                                                <select name="rol"
                                                        class="form-select @if(old('_empleado_editando') == $empleado->id && $errors->has('rol')) is-invalid @endif"
                                                        required>

                                                    <option value="Empleado"
                                                        {{ (old('_empleado_editando') == $empleado->id ? old('rol') : $empleado->rol) == 'Empleado' ? 'selected' : '' }}>
                                                        Empleado
                                                    </option>

                                                    <option value="Administrador"
                                                        {{ (old('_empleado_editando') == $empleado->id ? old('rol') : $empleado->rol) == 'Administrador' ? 'selected' : '' }}>
                                                        Administrador
                                                    </option>

                                                    <option value="Chofer"
                                                        {{ (old('_empleado_editando') == $empleado->id ? old('rol') : $empleado->rol) == 'Chofer' ? 'selected' : '' }}>
                                                        Chofer
                                                    </option>

                                                </select>

                                                @if(old('_empleado_editando') == $empleado->id)
                                                    @error('rol')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                @endif

                                            </div>


                                            {{-- ESTADO --}}
                                            <div class="col-md-6">

                                                <label class="text-muted small">
                                                    Estado
                                                </label>

                                                <select name="estado"
                                                        class="form-select @if(old('_empleado_editando') == $empleado->id && $errors->has('estado')) is-invalid @endif"
                                                        required>

                                                    <option value="Activo"
                                                        {{ (old('_empleado_editando') == $empleado->id ? old('estado') : $empleado->estado) == 'Activo' ? 'selected' : '' }}>
                                                        Activo
                                                    </option>

                                                    <option value="Inactivo"
                                                        {{ (old('_empleado_editando') == $empleado->id ? old('estado') : $empleado->estado) == 'Inactivo' ? 'selected' : '' }}>
                                                        Inactivo
                                                    </option>

                                                </select>

                                                @if(old('_empleado_editando') == $empleado->id)
                                                    @error('estado')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                @endif

                                            </div>


                                            {{-- FOTO --}}
                                            <div class="col-md-6">

                                                <label class="text-muted small">
                                                    Foto
                                                </label>

                                                <input type="file"
                                                       name="foto"
                                                       class="form-control @if(old('_empleado_editando') == $empleado->id && $errors->has('foto')) is-invalid @endif">

                                                @if(old('_empleado_editando') == $empleado->id)
                                                    @error('foto')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                @endif

                                            </div>

                                        </div>

                                    </div>


                                    <div class="modal-footer border-top d-flex justify-content-end gap-2"
                                         style="border-color:#e5e7eb !important;padding:1rem 1.5rem;">

                                        <button type="button"
                                                class="btn btn-sm btn-secondary d-flex align-items-center gap-2"
                                                data-bs-dismiss="modal">

                                            <i class="fas fa-times"
                                               style="font-size:12px;">
                                            </i>

                                            Cancelar

                                        </button>

                                        <button type="submit"
                                                class="btn btn-sm btn-primary d-flex align-items-center gap-2">

                                            <i class="fas fa-save"
                                               style="font-size:12px;">
                                            </i>

                                            Guardar

                                        </button>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>


                @empty

                    <tr>
                        <td colspan="8"
                            class="text-center text-muted py-5">

                            <i class="fas fa-users fa-2x mb-2 d-block"></i>

                            No hay empleados registrados

                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- =========================================================
             PAGINACIÓN
             ========================================================= --}}
        <div class="d-flex justify-content-between align-items-center mt-4">

            <div class="text-muted small">

                Mostrando

                <span class="fw-semibold text-dark">
            {{ $empleados->firstItem() ?? 0 }}
        </span>

                –

                <span class="fw-semibold text-dark">
            {{ $empleados->lastItem() ?? 0 }}
        </span>

                de

                <span class="fw-semibold text-dark">
            {{ $empleados->total() }}
        </span>

                empleados

            </div>


            @if($empleados->hasPages())

                <nav>

                    <ul class="pagination pagination-sm mb-0">

                        <li class="page-item {{ $empleados->onFirstPage() ? 'disabled' : '' }}">

                            <a class="page-link"
                               href="{{ $empleados->appends(request()->all())->previousPageUrl() }}">

                                Anterior

                            </a>

                        </li>


                        @for($page = 1; $page <= $empleados->lastPage(); $page++)

                            <li class="page-item {{ $page == $empleados->currentPage() ? 'active' : '' }}">

                                <a class="page-link"
                                   href="{{ $empleados->appends(request()->all())->url($page) }}">

                                    {{ $page }}

                                </a>

                            </li>

                        @endfor


                        <li class="page-item {{ $empleados->hasMorePages() ? '' : 'disabled' }}">

                            <a class="page-link"
                               href="{{ $empleados->appends(request()->all())->nextPageUrl() }}">

                                Siguiente

                            </a>

                        </li>

                    </ul>

                </nav>

            @endif

        </div>
        ```

    </div>
    </div>
    </div>

    {{-- =============================================================
    MODAL CREAR EMPLEADO
    ============================================================= --}}

    <div class="modal fade"
         id="crearEmpleadoModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 rounded-3"
                 style="overflow:hidden;">

                <div class="modal-header text-white border-0"
                     style="background:#1e63b8;padding:1.25rem 1.5rem;">

                    <div class="d-flex align-items-center gap-2">

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:34px;height:34px;background:rgba(255,255,255,0.2);">

                            <i class="fas fa-user-plus"
                               style="font-size:13px;">
                            </i>

                        </div>

                        <span style="font-size:15px;font-weight:500;">
                    Registrar Empleado
                </span>

                    </div>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <form method="POST"
                      action="{{ route('empleados.store') }}"
                      enctype="multipart/form-data"
                      novalidate
                      class="form-validar-empleado">

                    @csrf

                    <div class="modal-body"
                         style="padding:1.5rem;">

                        <div class="row g-3">


                            {{-- NOMBRE --}}
                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Nombre
                                </label>

                                <input type="text"
                                       name="nombre"
                                       value="{{ old('nombre') }}"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                       data-mensaje="El nombre solo puede contener letras y espacios."
                                       required>

                                <div class="invalid-feedback">

                                    @error('nombre')
                                    {{ $message }}
                                    @enderror

                                </div>

                            </div>


                            {{-- APELLIDO --}}
                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Apellido
                                </label>

                                <input type="text"
                                       name="apellido"
                                       value="{{ old('apellido') }}"
                                       class="form-control @error('apellido') is-invalid @enderror"
                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                       data-mensaje="El apellido solo puede contener letras y espacios."
                                       required>

                                <div class="invalid-feedback">

                                    @error('apellido')
                                    {{ $message }}
                                    @enderror

                                </div>

                            </div>


                            {{-- DNI --}}
                            <div class="col-md-6">

                                <label class="text-muted small">
                                    DNI
                                </label>

                                <input type="text"
                                       name="dni"
                                       value="{{ old('dni') }}"
                                       class="form-control @error('dni') is-invalid @enderror"
                                       inputmode="numeric"
                                       maxlength="13"
                                       data-pattern="^[0-9]{13}$"
                                       data-mensaje="El DNI debe contener exactamente 13 números."
                                       required>

                                <div class="invalid-feedback">

                                    @error('dni')
                                    {{ $message }}
                                    @enderror

                                </div>

                            </div>


                            {{-- CARGO --}}
                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Cargo
                                </label>

                                <input type="text"
                                       name="cargo"
                                       value="{{ old('cargo') }}"
                                       class="form-control @error('cargo') is-invalid @enderror"
                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                       data-mensaje="El cargo solo puede contener letras y espacios."
                                       required>

                                <div class="invalid-feedback">

                                    @error('cargo')
                                    {{ $message }}
                                    @enderror

                                </div>

                            </div>


                            {{-- FECHA --}}
                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Fecha ingreso
                                </label>

                                <input type="date"
                                       name="fecha_ingreso"
                                       value="{{ old('fecha_ingreso') }}"
                                       class="form-control @error('fecha_ingreso') is-invalid @enderror"
                                       required>

                                <div class="invalid-feedback">

                                    @error('fecha_ingreso')
                                    {{ $message }}
                                    @enderror

                                </div>

                            </div>


                            {{-- ROL --}}
                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Rol
                                </label>

                                <select name="rol"
                                        class="form-select @error('rol') is-invalid @enderror"
                                        required>

                                    <option value="">
                                        Seleccionar
                                    </option>

                                    <option value="Empleado"
                                        {{ old('rol') == 'Empleado' ? 'selected' : '' }}>
                                        Empleado
                                    </option>

                                    <option value="Administrador"
                                        {{ old('rol') == 'Administrador' ? 'selected' : '' }}>
                                        Administrador
                                    </option>

                                    <option value="Chofer"
                                        {{ old('rol') == 'Chofer' ? 'selected' : '' }}>
                                        Chofer
                                    </option>

                                </select>

                                @error('rol')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>


                            {{-- FOTO --}}
                            <div class="col-12">

                                <label class="text-muted small">
                                    Foto
                                </label>

                                <input type="file"
                                       name="foto"
                                       class="form-control @error('foto') is-invalid @enderror">

                                @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer border-top d-flex justify-content-end gap-2"
                         style="border-color:#e5e7eb !important;padding:1rem 1.5rem;">

                        <button type="button"
                                class="btn btn-sm btn-secondary d-flex align-items-center gap-2"
                                data-bs-dismiss="modal">

                            <i class="fas fa-times"
                               style="font-size:12px;">
                            </i>

                            Cancelar

                        </button>

                        <button type="submit"
                                class="btn btn-sm btn-primary d-flex align-items-center gap-2"
                                style="min-width:100px;justify-content:center;">

                            <i class="fas fa-save"
                               style="font-size:12px;">
                            </i>

                            Guardar

                        </button>

                    </div>

                </form>

            </div>
        </div>
        ```

    </div>

    <style>

        .pagination .page-link {
            color:#1e63b8;
            border-radius:0.375rem;
            border:1px solid #dee2e6;
            margin:0 2px;
        }

        .pagination .page-link:hover {
            background-color:#1e63b8;
            color:#fff;
        }

        .pagination .page-item.active .page-link {
            background-color:#1e63b8;
            border-color:#1e63b8;
            color:#fff;
        }

        .pagination .page-item.disabled .page-link {
            color:#9ca3af;
            background:#f3f4f6;
            border-color:#e5e7eb;
        }

        thead th a {
            text-decoration:none;
            color:inherit;
        }

        thead th a:hover {
            color:#1e63b8;
        }

    </style>

    {{-- =============================================================
    ABRIR EL MODAL CORRECTO DESPUÉS DE UNA VALIDACIÓN
    ============================================================= --}}
    @if ($errors->any())

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                /*
                 * El controlador envía nuevamente los datos mediante
                 * $request->validate().
                 *
                 * Si existe _empleado_editando, significa que los errores
                 * pertenecen al formulario de editar.
                 */
                const empleadoEditando = @json(old('_empleado_editando'));

                if (empleadoEditando) {

                    const modalElement = document.getElementById(
                        'editarEmpleadoModal' + empleadoEditando
                    );

                    if (modalElement) {

                        const modal = new bootstrap.Modal(modalElement);

                        modal.show();

                    }

                } else {

                    /*
                     * Si no existe _empleado_editando, los errores
                     * pertenecen al formulario de crear.
                     */
                    const crearModalElement =
                        document.getElementById('crearEmpleadoModal');

                    if (crearModalElement) {

                        const modal = new bootstrap.Modal(
                            crearModalElement
                        );

                        modal.show();

                    }

                }

            });

        </script>

    @endif

    <script>

        $(document).ready(function () {

            /*
             * Select2
             */
            $('.select2').each(function () {

                $(this).select2({
                    theme:'bootstrap-5',
                    width:'100%',
                    placeholder:$(this).data('placeholder') || 'Seleccionar...',
                    allowClear:true
                });

            });


            $('select[name="rol"], select[name="estado"], select[name="per_page"]').select2({
                theme:'bootstrap-5',
                width:'100%',
                placeholder:'Seleccione una opción',
                allowClear:true
            });

        });


        /* =========================================================
           VALIDACIÓN PROPIA
           ========================================================= */

        function validarCampo(input) {

            const patron = input.dataset.pattern;
            const valor = input.value.trim();

            /*
             * Campo requerido vacío
             */
            if (input.hasAttribute('required') && valor === '') {

                marcarInvalido(
                    input,
                    'Este campo es obligatorio.'
                );

                return false;
            }


            /*
             * Validación mediante patrón
             */
            if (patron && valor !== '') {

                const regex = new RegExp(patron);

                if (!regex.test(valor)) {

                    marcarInvalido(
                        input,
                        input.dataset.mensaje || 'Valor inválido.'
                    );

                    return false;
                }

            }


            marcarValido(input);

            return true;
        }


        function marcarInvalido(input, mensaje) {

            input.classList.remove('is-valid');

            input.classList.add('is-invalid');

            const feedback =
                input.parentElement.querySelector('.invalid-feedback');

            /*
             * Solamente reemplazar el mensaje si no viene
             * directamente de Laravel.
             */
            if (feedback && !feedback.textContent.trim()) {
                feedback.textContent = mensaje;
            }

        }


        function marcarValido(input) {

            input.classList.remove('is-invalid');

            input.classList.add('is-valid');

        }


        /*
         * Validación de todos los formularios
         */
        document.querySelectorAll('.form-validar-empleado')
            .forEach(function (form) {

                const campos =
                    form.querySelectorAll(
                        '[data-pattern], input[required]:not([data-pattern])'
                    );


                /*
                 * Validación mientras escribe
                 */
                campos.forEach(function (input) {

                    input.addEventListener('input', function () {

                        /*
                         * Si el campo ya tiene un error de Laravel,
                         * al modificarlo permitimos actualizar la
                         * validación del lado del cliente.
                         */
                        validarCampo(input);

                    });

                });


                /*
                 * Validación antes de enviar
                 */
                form.addEventListener('submit', function (e) {

                    let formValido = true;


                    campos.forEach(function (input) {

                        if (!validarCampo(input)) {
                            formValido = false;
                        }

                    });


                    if (!formValido) {

                        e.preventDefault();

                        e.stopPropagation();


                        const primerInvalido =
                            form.querySelector('.is-invalid');

                        if (primerInvalido) {
                            primerInvalido.focus();
                        }

                    }

                });

            });


        /* =========================================================
           LIMPIEZA DE MODALES
           ========================================================= */

        document.addEventListener(
            'hidden.bs.modal',
            function () {

                const hayModalAbierto =
                    document.querySelector('.modal.show');


                if (!hayModalAbierto) {

                    document.body.classList.remove('modal-open');

                    document.body.style.removeProperty('overflow');

                    document.body.style.removeProperty('padding-right');


                    document
                        .querySelectorAll('.modal-backdrop')
                        .forEach(function (backdrop) {

                            backdrop.remove();

                        });

                }

            }
        );

    </script>

@endsection
