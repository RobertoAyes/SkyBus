@extends('layouts.layoutadmin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 style="margin:0; color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-building me-2"></i>Empresas de Transporte
                </h2>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                <!-- Tabla de Empresas -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Número Registro</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($empresas as $empresa)
                            <tr>
                                <td>{{ $empresa->id }}</td>
                                <td>{{ $empresa->nombre }}</td>
                                <td>{{ $empresa->numero_registro }}</td>
                                <td>{{ $empresa->email }}</td>
                                <td>{{ $empresa->telefono }}</td>
                                <td>
                                    @if($empresa->estado_validacion)
                                        <span class="badge bg-success">Activa</span>
                                    @else
                                        <span class="badge bg-danger">Inactiva</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal{{ $empresa->id }}">
                                        <i class="fas fa-edit me-1"></i> Editar
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de edición -->
                            <div class="modal fade" id="editarModal{{ $empresa->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $empresa->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:#1e63b8; color:white;">
                                            <h5 class="modal-title" id="editarModalLabel{{ $empresa->id }}">
                                                <i class="fas fa-building me-2"></i>Editar Empresa: {{ $empresa->nombre }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" id="formEditar{{ $empresa->id }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="nombre{{ $empresa->id }}" class="form-label">Nombre <span class="text-danger">*</span></label>
                                                    <input type="text" name="nombre" id="nombre{{ $empresa->id }}" value="{{ $empresa->nombre }}" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email{{ $empresa->id }}" class="form-label">Correo</label>
                                                    <input type="email" name="email" id="email{{ $empresa->id }}" value="{{ $empresa->email }}" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="telefono{{ $empresa->id }}" class="form-label">Teléfono</label>
                                                    <input type="text" name="telefono" id="telefono{{ $empresa->id }}" value="{{ $empresa->telefono }}" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="estado{{ $empresa->id }}" class="form-label">Estado</label>
                                                    <select name="estado" id="estado{{ $empresa->id }}" class="form-select">
                                                        <option value="1" {{ $empresa->estado_validacion ? 'selected' : '' }}>Activa</option>
                                                        <option value="0" {{ !$empresa->estado_validacion ? 'selected' : '' }}>Inactiva</option>
                                                    </select>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Guardar Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-building fa-2x mb-2 d-block"></i>
                                    No se encontraron empresas registradas.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-4">
                    @if($empresas->count())
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Mostrando {{ $empresas->firstItem() }} - {{ $empresas->lastItem() }} de {{ $empresas->total() }} empresas
                            </div>
                            <div>
                                {{ $empresas->appends(request()->all())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
