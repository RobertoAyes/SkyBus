@extends('layouts.layoutadmin')

@section('title', 'Panel Administrativo')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <!-- HEADER -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-users me-2"></i>Empleados
                </h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearEmpleadoModal">
                    <i class="fas fa-plus me-2"></i>Nuevo Empleado
                </button>
            </div>

            <div class="card-body">

                {{-- Mensaje de éxito --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                {{-- Formulario de búsqueda y filtros --}}
                <form method="GET" action="{{ route('empleados.hu5') }}" class="mb-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Búsqueda General
                        </label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <input type="text" name="buscar" class="form-control"
                                           placeholder="Buscar por nombre, apellido o cargo"
                                           value="{{ request('buscar') }}">
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-items-end gap-2">
                                <button class="btn btn-primary flex-fill" type="submit">
                                    <i class="fas fa-search me-2"></i>Buscar
                                </button>
                                <button class="btn btn-outline-primary flex-fill" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                                    <i class="fas fa-sliders-h me-2"></i>Filtros
                                </button>
                                @if(request()->hasAny(['buscar','rol','estado','fecha_registro']))
                                    <a href="{{ route('empleados.hu5') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="fas fa-times me-2"></i>Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Filtros avanzados --}}
                    <div class="collapse" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-filter me-2"></i>Filtros Adicionales
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-user-tag text-primary me-2"></i>Rol
                                        </label>
                                        <select name="rol" class="form-select">
                                            <option value="">Todos</option>
                                            <option value="Administrador" {{ request('rol') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                            <option value="Empleado"      {{ request('rol') == 'Empleado'      ? 'selected' : '' }}>Empleado</option>
                                            <option value="Chofer"        {{ request('rol') == 'Chofer'        ? 'selected' : '' }}>Chofer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-1"></i> Estado
                                        </label>
                                        <select name="estado" class="form-select">
                                            <option value="">Todos</option>
                                            <option value="Activo"   {{ request('estado') == 'Activo'   ? 'selected' : '' }}>Activo</option>
                                            <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-primary me-1"></i>Fecha de Registro
                                        </label>
                                        <input type="date" name="fecha_registro" class="form-control"
                                               value="{{ request('fecha_registro') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- MOSTRAR REGISTROS --}}
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

                {{-- Tabla de empleados --}}
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

                                {{-- NUMERACIÓN --}}
                                <td class="text-center">
                                    {{ ($empleados->currentPage() - 1) * $empleados->perPage() + $key + 1 }}
                                </td>

                                <td>{{ $empleado->nombre }}</td>
                                <td>{{ $empleado->apellido }}</td>
                                <td>{{ $empleado->cargo }}</td>
                                <td><span class="badge bg-primary">{{ $empleado->rol }}</span></td>
                                <td>
                                    <span class="badge {{ $empleado->estado == 'Activo' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $empleado->estado }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}</td>

                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editarEmpleadoModal{{ $empleado->id }}">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>
                                </td>
                            </tr>

                            <!-- MODAL EDITAR -->
                            <div class="modal fade" id="editarEmpleadoModal{{ $empleado->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3" style="overflow:hidden;">

                                        <div class="modal-header text-white border-0"
                                             style="background:#1e63b8; padding:1.25rem 1.5rem;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width:34px;height:34px;background:rgba(255,255,255,0.2);">
                                                    <i class="fas fa-user-edit" style="font-size:13px;"></i>
                                                </div>
                                                <span style="font-size:15px;font-weight:500;">Editar Empleado</span>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form method="POST" action="{{ route('empleados.hu5.update', $empleado->id) }}"
                                              enctype="multipart/form-data" novalidate class="form-validar-empleado">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body" style="padding:1.5rem;">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="text-muted small">Nombre</label>
                                                        <input type="text" name="nombre" value="{{ $empleado->nombre }}"
                                                               class="form-control"
                                                               data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                                               data-mensaje="El nombre solo puede contener letras y espacios."
                                                               required>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="text-muted small">Apellido</label>
                                                        <input type="text" name="apellido" value="{{ $empleado->apellido }}"
                                                               class="form-control"
                                                               data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                                               data-mensaje="El apellido solo puede contener letras y espacios."
                                                               required>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="text-muted small">DNI</label>
                                                        <input type="text" name="dni" value="{{ $empleado->dni }}"
                                                               class="form-control"
                                                               inputmode="numeric"
                                                               data-pattern="^[0-9]{13}$"
                                                               maxlength="13"
                                                               data-mensaje="El DNI debe contener exactamente 13 números."
                                                               required>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="text-muted small">Cargo</label>
                                                        <input type="text" name="cargo" value="{{ $empleado->cargo }}"
                                                               class="form-control"
                                                               data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                                               data-mensaje="El cargo solo puede contener letras y espacios."
                                                               required>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="text-muted small">Fecha ingreso</label>
                                                        <input type="date" name="fecha_ingreso"
                                                               value="{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('Y-m-d') }}"
                                                               class="form-control" required>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="text-muted small">Rol</label>
                                                        <select name="rol" class="form-select" required>
                                                            <option value="Empleado"      {{ $empleado->rol == 'Empleado'      ? 'selected' : '' }}>Empleado</option>
                                                            <option value="Administrador" {{ $empleado->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                                            <option value="Chofer"        {{ $empleado->rol == 'Chofer'        ? 'selected' : '' }}>Chofer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="text-muted small">Estado</label>
                                                        <select name="estado" class="form-select" required>
                                                            <option value="Activo"   {{ $empleado->estado == 'Activo'   ? 'selected' : '' }}>Activo</option>
                                                            <option value="Inactivo" {{ $empleado->estado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="text-muted small">Foto</label>
                                                        <input type="file" name="foto" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer border-top d-flex justify-content-end gap-2"
                                                 style="border-color:#e5e7eb !important;padding:1rem 1.5rem;">
                                                <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-2"
                                                        data-bs-dismiss="modal">
                                                    <i class="fas fa-times" style="font-size:12px;"></i> Cancelar
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-2">
                                                    <i class="fas fa-save" style="font-size:12px;"></i> Guardar
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>No hay empleados registrados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACION --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $empleados->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $empleados->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $empleados->total() }}</span>
                        empleados
                    </div>

                    @if($empleados->hasPages())
                        <nav>
                            <ul class="pagination pagination-sm mb-0">

                                {{-- ANTERIOR --}}
                                <li class="page-item {{ $empleados->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link"
                                       href="{{ $empleados->appends(request()->all())->previousPageUrl() }}">
                                        Anterior
                                    </a>
                                </li>

                                {{-- NUMEROS --}}
                                @for($page = 1; $page <= $empleados->lastPage(); $page++)
                                    <li class="page-item {{ $page == $empleados->currentPage() ? 'active' : '' }}">
                                        <a class="page-link"
                                           href="{{ $empleados->appends(request()->all())->url($page) }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endfor

                                {{-- SIGUIENTE --}}
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

            </div>
        </div>
    </div>

    <!-- Modal Crear Empleado -->
    <div class="modal fade" id="crearEmpleadoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-3" style="overflow:hidden;">

                <div class="modal-header text-white border-0"
                     style="background:#1e63b8;padding:1.25rem 1.5rem;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:34px;height:34px;background:rgba(255,255,255,0.2);">
                            <i class="fas fa-user-plus" style="font-size:13px;"></i>
                        </div>
                        <span style="font-size:15px;font-weight:500;">Registrar Empleado</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('empleados.store') }}" enctype="multipart/form-data"
                      novalidate class="form-validar-empleado">
                    @csrf
                    <div class="modal-body" style="padding:1.5rem;">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Nombre</label>
                                <input type="text"
                                       name="nombre"
                                       value="{{ old('nombre') }}"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                       data-mensaje="El nombre solo puede contener letras y espacios."
                                       required>
                                <div class="invalid-feedback">
                                    @error('nombre') {{ $message }} @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Apellido</label>
                                <input type="text"
                                       name="apellido"
                                       value="{{ old('apellido') }}"
                                       class="form-control @error('apellido') is-invalid @enderror"
                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                       data-mensaje="El apellido solo puede contener letras y espacios."
                                       required>
                                <div class="invalid-feedback">
                                    @error('apellido') {{ $message }} @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">DNI</label>
                                <input type="text"
                                       name="dni"
                                       value="{{ old('dni') }}"
                                       class="form-control @error('dni') is-invalid @enderror"
                                       inputmode="numeric"
                                       data-pattern="^[0-9]{13}$"
                                       maxlength="13"
                                       data-mensaje="El DNI debe contener exactamente 13 números."
                                       required>
                                <div class="invalid-feedback">
                                    @error('dni') {{ $message }} @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Cargo</label>
                                <input type="text"
                                       name="cargo"
                                       value="{{ old('cargo') }}"
                                       class="form-control @error('cargo') is-invalid @enderror"
                                       data-pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$"
                                       data-mensaje="El cargo solo puede contener letras y espacios."
                                       required>
                                <div class="invalid-feedback">
                                    @error('cargo') {{ $message }} @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Fecha ingreso</label>
                                <input type="date" name="fecha_ingreso" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Rol</label>
                                <select name="rol" class="form-select" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Empleado">Empleado</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Chofer">Chofer</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small">Foto</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top d-flex justify-content-end gap-2"
                         style="border-color:#e5e7eb !important;padding:1rem 1.5rem;">
                        <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-2"
                                data-bs-dismiss="modal">
                            <i class="fas fa-times" style="font-size:12px;"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-2" style="min-width: 100px; justify-content: center;">
                            <i class="fas fa-save" style="font-size:12px;"></i> Guardar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <style>
        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            margin: 0 2px;
        }
        .pagination .page-link:hover        { background-color: #1e63b8; color: #fff; }
        .pagination .page-item.active .page-link  { background-color: #1e63b8; border-color: #1e63b8; color: #fff; }
        .pagination .page-item.disabled .page-link { color: #9ca3af; background: #f3f4f6; border-color: #e5e7eb; }

        thead th a { text-decoration: none; color: inherit; }
        thead th a:hover { color: #1e63b8; }
    </style>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let modal = new bootstrap.Modal(document.getElementById('crearEmpleadoModal'));
                modal.show();
            });
        </script>
    @endif

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

            // Inicializa Select2 en filtros y per_page
            $('select[name="rol"], select[name="estado"], select[name="per_page"]').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });

        /* =========================================================
           VALIDACIÓN PROPIA (sin tooltips nativos del navegador)
           -------------------------------------------------------
           Se usa novalidate en los <form> para evitar que el
           navegador muestre su popup de validación dentro del
           modal. Ese popup, combinado con el foco atrapado del
           modal (tabindex="-1"), es lo que dejaba la página
           bloqueada al cerrar con la X. Aquí se valida a mano y
           se muestra el error con las clases de Bootstrap
           (is-invalid / invalid-feedback), que sí funcionan bien
           dentro de un modal.
           ========================================================= */
        function validarCampo(input) {
            const patron = input.dataset.pattern;
            const valor = input.value.trim();

            // Campo requerido vacío
            if (input.hasAttribute('required') && valor === '') {
                marcarInvalido(input, 'Este campo es obligatorio.');
                return false;
            }

            // Patrón de caracteres (nombre, apellido, cargo, dni)
            if (patron && valor !== '') {
                const regex = new RegExp(patron);
                if (!regex.test(valor)) {
                    marcarInvalido(input, input.dataset.mensaje || 'Valor inválido.');
                    return false;
                }
            }

            marcarValido(input);
            return true;
        }

        function marcarInvalido(input, mensaje) {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            const feedback = input.parentElement.querySelector('.invalid-feedback');
            if (feedback) feedback.textContent = mensaje;
        }

        function marcarValido(input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        }

        document.querySelectorAll('.form-validar-empleado').forEach(function (form) {
            const campos = form.querySelectorAll('[data-pattern], input[required]:not([data-pattern])');

            // Validar mientras el usuario escribe, sin bloquear nada
            campos.forEach(function (input) {
                input.addEventListener('input', function () {
                    validarCampo(input);
                });
            });

            // Validar al enviar
            form.addEventListener('submit', function (e) {
                let formValido = true;
                campos.forEach(function (input) {
                    if (!validarCampo(input)) formValido = false;
                });

                if (!formValido) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Enfocar el primer campo inválido sin usar el
                    // tooltip nativo del navegador
                    const primerInvalido = form.querySelector('.is-invalid');
                    if (primerInvalido) primerInvalido.focus();
                }
            });
        });

        /* =========================================================
           RED DE SEGURIDAD PARA MODALES
           -------------------------------------------------------
           Si por cualquier motivo (validación, error de red, etc.)
           un modal se cierra y deja un backdrop o clases residuales
           en el <body>, esto las limpia automáticamente para que la
           página nunca quede bloqueada y no haga falta refrescar.
           ========================================================= */
        document.addEventListener('hidden.bs.modal', function () {
            // Si ya no queda ningún modal abierto, limpiar todo rastro
            const hayModalAbierto = document.querySelector('.modal.show');
            if (!hayModalAbierto) {
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
                document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
                    backdrop.remove();
                });
            }
        });
    </script>

@endsection
