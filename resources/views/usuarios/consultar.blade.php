@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <!-- HEADER -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-users me-2"></i>Usuarios
                </h2>
            </div>

            <div class="card-body">

                <!-- Mensajes de éxito -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- FORMULARIO -->
                <form method="GET" action="{{ route('usuarios.consultar') }}" class="mb-4">
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

                            <button class="btn btn-outline-primary flex-fill" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>

                            @if(request()->hasAny(['search', 'rol', 'estado', 'fecha_registro']))
                                <a href="{{ route('usuarios.consultar') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- FILTROS -->
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
                                        <input type="text" name="dni" class="form-control" value="{{ request('dni') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-2"></i>Estado
                                        </label>
                                        <select name="estado" class="form-select">
                                            <option value="">Todos los estados</option>
                                            <option value="activo" {{ request('estado')=='activo' ? 'selected' : '' }}>Activo</option>
                                            <option value="inactivo" {{ request('estado')=='inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar text-primary me-2"></i>Fecha de Registro
                                        </label>
                                        <input type="date" name="fecha_registro" class="form-control"
                                               value="{{ request('fecha_registro') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MOSTRAR REGISTROS -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold">Mostrar:</label>

                            <select name="per_page"
                                    class="form-select form-select-sm border-primary"
                                    style="width:90px;"
                                    onchange="this.form.submit()">

                                <option value="5"  {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
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
                            <th class="text-center" style="width:60px;">#</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>DNI</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if($usuarios->isEmpty() && request('search'))
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No se encontraron resultados para "{{ request('search') }}"
                                </td>
                            </tr>

                        @elseif($usuarios->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No se encontraron usuarios con los filtros aplicados
                                </td>
                            </tr>

                        @else
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td class="text-center">
                                        {{ ($usuarios->currentPage() - 1) * $usuarios->perPage() + $loop->index + 1 }}
                                    </td>

                                    <td>{{ $usuario->nombre_completo }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->dni }}</td>

                                    <td>
                                        @if($usuario->rol)
                                            <span class="badge bg-primary">{{ ucfirst($usuario->rol) }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge {{ ($usuario->estado == 'activo' || !$usuario->estado) ? 'bg-success' : 'bg-danger' }}">
                                            {{ ($usuario->estado == 'activo' || !$usuario->estado) ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>

                                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>

                                    <td class="text-center">
                                        <button type="button"
                                                class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editarModal{{ $usuario->id }}">
                                            <i class="fas fa-edit"></i>Editar
                                        </button>
                                    </td>
                                </tr>

                                <!-- MODAL ORIGINAL (SIN CAMBIOS) -->
                                <div class="modal fade" id="editarModal{{ $usuario->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#1e63b8; color:white;">
                                                <h5 class="modal-title">
                                                    Editar Usuario: {{ $usuario->nombre_completo }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" id="formEditar{{ $usuario->id }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="id_usuario" value="{{ $usuario->id }}">

                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label>Nombre</label>
                                                            <input type="text" name="nombre_completo" value="{{ $usuario->nombre_completo }}" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>DNI</label>
                                                            <input type="text" name="dni" value="{{ $usuario->dni }}" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Email</label>
                                                            <input type="email" name="email" value="{{ $usuario->email }}" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Teléfono</label>
                                                            <input type="text" name="telefono" value="{{ $usuario->telefono }}" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Estado</label>
                                                            <select name="estado" class="form-select">
                                                                <option value="activo" {{ $usuario->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                                                                <option value="inactivo" {{ $usuario->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" form="formEditar{{ $usuario->id }}" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

                <!-- PAGINACIÓN -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold">{{ $usuarios->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold">{{ $usuarios->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold">{{ $usuarios->total() }}</span>
                        usuarios
                    </div>

                    @if($usuarios->hasPages())
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item {{ $usuarios->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $usuarios->previousPageUrl() }}">Anterior</a>
                            </li>

                            @for($i = 1; $i <= $usuarios->lastPage(); $i++)
                                <li class="page-item {{ $i == $usuarios->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $usuarios->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <li class="page-item {{ $usuarios->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $usuarios->nextPageUrl() }}">Siguiente</a>
                            </li>
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
