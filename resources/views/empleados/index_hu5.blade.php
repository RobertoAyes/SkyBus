@extends('layouts.layoutadmin')

@section('title', 'Panel Administrativo')

@section('content')
    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-users me-2"></i>Empleados
                </h2>
            </div>



            <div class="card-body">

                {{-- Mensaje de éxito --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                {{-- Formulario de búsqueda y filtros --}}
                <form method="GET" action="{{ route('empleados.hu5') }}" class="mb-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">
                                <i class="fas fa-search text-primary me-2"></i>Búsqueda General
                            </label>
                            <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
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
                                    data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados"
                                    aria-expanded="false">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>
                            @if(request()->hasAny(['buscar','rol','estado','fecha_registro']))
                                <a href="{{ route('empleados.hu5') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </a>
                            @endif
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
                                            <option value="Administrador" {{ request('rol')=='Administrador' ? 'selected' : '' }}>Administrador</option>
                                            <option value="Empleado" {{ request('rol')=='Empleado' ? 'selected' : '' }}>Empleado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-2"></i>Estado
                                        </label>
                                        <select name="estado" class="form-select">
                                            <option value="">Todos</option>
                                            <option value="Activo" {{ request('estado')=='Activo' ? 'selected' : '' }}>Activo</option>
                                            <option value="Inactivo" {{ request('estado')=='Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt text-info me-2"></i>Fecha de Registro
                                        </label>
                                        <input type="date" name="fecha_registro" class="form-control" value="{{ request('fecha_registro') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Tabla de empleados --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
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
                        @forelse($empleados as $empleado)
                            <tr>
                                <td>{{ $empleado->nombre }}</td>
                                <td>{{ $empleado->apellido }}</td>
                                <td>{{ $empleado->cargo }}</td>
                                <td><span class="badge bg-primary">{{ $empleado->rol }}</span></td>
                                <td>
                                    <span class="badge {{ $empleado->estado == 'Activo' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $empleado->estado }}
                                    </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editarEmpleadoModal{{ $empleado->id }}">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal de edición --}}
                            <div class="modal fade" id="editarEmpleadoModal{{ $empleado->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-user-edit me-2"></i>Editar Empleado
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('empleados.hu5.update', $empleado->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nombre</label>
                                                        <input type="text" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Apellido</label>
                                                        <input type="text" name="apellido" value="{{ old('apellido', $empleado->apellido) }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">DNI</label>
                                                        <input type="text" name="dni" value="{{ old('dni', $empleado->dni) }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Cargo</label>
                                                        <input type="text" name="cargo" value="{{ old('cargo', $empleado->cargo) }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Fecha Ingreso</label>
                                                        <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('Y-m-d')) }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Rol</label>
                                                        <select name="rol" class="form-select" required>
                                                            <option value="Administrador" {{ old('rol', $empleado->rol)=='Administrador' ? 'selected' : '' }}>Administrador</option>
                                                            <option value="Empleado" {{ old('rol', $empleado->rol)=='Empleado' ? 'selected' : '' }}>Empleado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Estado</label>
                                                        <select name="estado" class="form-select" required>
                                                            <option value="Activo" {{ old('estado', $empleado->estado)=='Activo' ? 'selected' : '' }}>Activo</option>
                                                            <option value="Inactivo" {{ old('estado', $empleado->estado)=='Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">Foto (opcional)</label>
                                                        <input type="file" name="foto" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="mt-4 text-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>No hay empleados registrados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-4">
                    {{ $empleados->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>


@endsection
