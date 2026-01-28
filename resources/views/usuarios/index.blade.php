@extends('layouts.layoutadmin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 style="margin:0; color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-user-edit me-2"></i>Gestion de Usuarios
                </h2>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url('/usuarios') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-10">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Buscar por Nombre Completo, DNI o Email"
                                value="{{ request('search') }}"
                            >
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">
                                <i class="fas fa-search me-1"></i>Buscar
                            </button>
                        </div>
                        @if(request('search'))
                            <div class="col-12">
                                <a href="{{ url('/usuarios') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times me-1"></i>Limpiar Busqueda
                                </a>
                            </div>
                        @endif
                    </div>
                </form>

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="{{ route('usuarios.consultar') }}" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Consultar Usuarios
                    </a>
                    <a href="{{ route('admin.usuarios') }}" class="btn btn-primary">
                        <i class="fas fa-user-check me-1"></i>Validar Usuarios
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Panel Administrativo
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>DNI</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($usuarios->isEmpty() && request('search'))
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No se encontraron resultados para "{{ request('search') }}"
                                </td>
                            </tr>
                        @elseif($usuarios->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Aun no hay usuarios registrados
                                </td>
                            </tr>
                        @else
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->nombre_completo }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->dni }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('usuarios.show', $usuario->id) }}"
                                               class="btn btn-primary">
                                                <i class="fas fa-eyes"></i> Ver
                                            </a>
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                               class="btn btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $usuarios->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
