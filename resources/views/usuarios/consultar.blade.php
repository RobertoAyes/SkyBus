@extends('layouts.layoutadmin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 style="margin:0; color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-users me-2"></i>Usuarios
                </h2>
            </div>
            <div class="card-body">
                <!-- Mensajes de éxito -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                <!-- Formulario Unificado de Búsqueda y Filtros -->
                <form method="GET" action="{{ route('usuarios.consultar') }}" class="mb-4">
                    <!-- Búsqueda Rápida y Botones -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">
                                <i class="fas fa-search text-primary me-2"></i>Búsqueda General
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="Buscar por Nombre Completo o Email"
                                    value="{{ request('search') }}"
                                >
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-end gap-2">
                            <button class="btn btn-primary flex-fill" type="submit">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                            <button class="btn btn-outline-primary flex-fill" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados" aria-expanded="false">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>
                            @if(request()->hasAny(['search', 'rol', 'estado', 'fecha_registro']))
                                <a href="{{ route('usuarios.consultar') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Filtros Avanzados (Colapsable) -->
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
                                            <i class="fas fa-id-card text-primary me-2"></i>DNI
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI" value="{{ request('dni') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-2"></i>Estado
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-toggle-on"></i>
                                            </span>
                                            <select name="estado" class="form-select">
                                                <option value="">Todos los estados</option>
                                                <option value="activo" {{ request('estado')=='activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="inactivo" {{ request('estado')=='inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt text-info me-2"></i>Fecha de Registro
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <input type="date" name="fecha_registro" class="form-control" value="{{ request('fecha_registro') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Tabla de Usuarios -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-primary">
                        <tr>
                            <th><i class="fas fa-user me-2"></i>Nombre Completo</th>
                            <th><i class="fas fa-envelope me-2"></i>Email</th>
                            <th><i class="fas fa-id-card me-2"></i>DNI</th>
                            <th><i class="fas fa-user-tag me-2"></i>Rol</th>
                            <th><i class="fas fa-toggle-on me-2"></i>Estado</th>
                            <th><i class="fas fa-calendar me-2"></i>Fecha Registro</th>
                            <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($usuarios->isEmpty() && request('search'))
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                    No se encontraron resultados para "{{ request('search') }}"
                                </td>
                            </tr>
                        @elseif($usuarios->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    No se encontraron usuarios con los filtros aplicados
                                </td>
                            </tr>
                        @else
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->nombre_completo }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->dni }}</td>
                                    <td>
                                        @if($usuario->rol)
                                            <span class="badge bg-primary">{{ ucfirst($usuario->rol) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($usuario->estado == 'activo' || !$usuario->estado)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal{{ $usuario->id }}">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal de Edición -->
                                <div class="modal fade" id="editarModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $usuario->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#1e63b8; color:white;">
                                                <h5 class="modal-title" id="editarModalLabel{{ $usuario->id }}">
                                                    <i class="fas fa-user-edit me-2"></i>Editar Usuario: {{ $usuario->nombre_completo }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" id="formEditar{{ $usuario->id }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Campo oculto para saber qué usuario editar -->
                                                    <input type="hidden" name="id_usuario" value="{{ $usuario->id }}">

                                                    <!-- Información Personal -->
                                                    <div class="mb-4">
                                                        <h6 class="mb-3 text-primary">
                                                            <i class="fas fa-user-circle me-2"></i>Información Personal
                                                        </h6>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="nombre_completo{{ $usuario->id }}" class="form-label">
                                                                    <i class="fas fa-user me-1"></i>Nombre Completo <span class="text-danger">*</span>
                                                                </label>
                                                                <input
                                                                    type="text"
                                                                    name="nombre_completo"
                                                                    id="nombre_completo{{ $usuario->id }}"
                                                                    value="{{ old('nombre_completo', $usuario->nombre_completo) }}"
                                                                    class="form-control @error('nombre_completo') is-invalid @enderror"
                                                                    required
                                                                >
                                                                @error('nombre_completo')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="dni{{ $usuario->id }}" class="form-label">
                                                                    <i class="fas fa-id-card me-1"></i>DNI <span class="text-danger">*</span>
                                                                </label>
                                                                <input
                                                                    type="text"
                                                                    name="dni"
                                                                    id="dni{{ $usuario->id }}"
                                                                    value="{{ old('dni', $usuario->dni) }}"
                                                                    class="form-control @error('dni') is-invalid @enderror"
                                                                    required
                                                                >
                                                                @error('dni')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="email{{ $usuario->id }}" class="form-label">
                                                                    <i class="fas fa-envelope me-1"></i>Email <span class="text-danger">*</span>
                                                                </label>
                                                                <input
                                                                    type="email"
                                                                    name="email"
                                                                    id="email{{ $usuario->id }}"
                                                                    value="{{ old('email', $usuario->email) }}"
                                                                    class="form-control @error('email') is-invalid @enderror"
                                                                    required
                                                                >
                                                                @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="telefono{{ $usuario->id }}" class="form-label">
                                                                    <i class="fas fa-phone me-1"></i>Teléfono <span class="text-danger">*</span>
                                                                </label>
                                                                <input
                                                                    type="text"
                                                                    name="telefono"
                                                                    id="telefono{{ $usuario->id }}"
                                                                    value="{{ old('telefono', $usuario->telefono) }}"
                                                                    class="form-control @error('telefono') is-invalid @enderror"
                                                                    required
                                                                >
                                                                @error('telefono')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Estado del Usuario -->
                                                    <div class="mb-4">
                                                        <h6 class="mb-3 text-primary">
                                                            <i class="fas fa-cog me-2"></i>Estado del Usuario
                                                        </h6>
                                                        <div class="row g-3">
                                                            <div class="col-md-12">
                                                                <label for="estado{{ $usuario->id }}" class="form-label">
                                                                    <i class="fas fa-toggle-on me-1"></i>Cambiar estado
                                                                </label>
                                                                <select
                                                                    name="estado"
                                                                    id="estado{{ $usuario->id }}"
                                                                    class="form-select @error('estado') is-invalid @enderror"
                                                                >
                                                                    <option value="activo" {{ old('estado', $usuario->estado ?? 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                                                                    <option value="inactivo" {{ old('estado', $usuario->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                                </select>
                                                                @error('estado')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Cambiar Contraseña -->
                                                    <div class="p-3 bg-light rounded">
                                                        <h6 class="mb-3 text-primary">
                                                            <i class="fas fa-key me-2"></i>Cambiar Contraseña (Opcional)
                                                        </h6>
                                                        <div class="alert alert-info alert-sm mb-3">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            Solo completa estos campos si deseas cambiar la contraseña
                                                        </div>

                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="password{{ $usuario->id }}" class="form-label">
                                                                    <i class="fas fa-lock me-1"></i>Nueva Contraseña
                                                                </label>
                                                                <input
                                                                    type="password"
                                                                    name="password"
                                                                    id="password{{ $usuario->id }}"
                                                                    class="form-control @error('password') is-invalid @enderror"
                                                                    placeholder="Mínimo 8 caracteres"
                                                                >
                                                                @error('password')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="password_confirmation{{ $usuario->id }}" class="form-label">
                                                                    <i class="fas fa-lock me-1"></i>Confirmar Nueva Contraseña
                                                                </label>
                                                                <input
                                                                    type="password"
                                                                    name="password_confirmation"
                                                                    id="password_confirmation{{ $usuario->id }}"
                                                                    class="form-control"
                                                                    placeholder="Repite la contraseña"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i>Cancelar
                                                </button>
                                                <button type="submit" form="formEditar{{ $usuario->id }}" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i>Guardar Cambios
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-4">
                    {{ $usuarios->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
