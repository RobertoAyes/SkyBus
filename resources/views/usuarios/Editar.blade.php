@extends('layouts.apps')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 style="margin:0; color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-user-edit me-2"></i>Editar Usuario:  {{ $usuario->nombre_completo }}
                </h2>
            </div>
            <div class="card-body">
                <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre_completo" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre Completo
                            </label>
                            <input
                                type="text"
                                name="nombre_completo"
                                id="nombre_completo"
                                value="{{ old('nombre_completo', $usuario->nombre_completo) }}"
                                class="form-control @error('nombre_completo') is-invalid @enderror"
                                required
                            >
                            @error('nombre_completo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="dni" class="form-label">
                                <i class="fas fa-id-card me-1"></i>DNI
                            </label>
                            <input
                                type="text"
                                name="dni"
                                id="dni"
                                value="{{ old('dni', $usuario->dni) }}"
                                class="form-control @error('dni') is-invalid @enderror"
                                required
                            >
                            @error('dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $usuario->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                            >
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">
                                <i class="fas fa-phone me-1"></i>Telefono
                            </label>
                            <input
                                type="text"
                                name="telefono"
                                id="telefono"
                                value="{{ old('telefono', $usuario->telefono) }}"
                                class="form-control @error('telefono') is-invalid @enderror"
                                required
                            >
                            @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-light rounded">
                        <h5 class="mb-3">
                            <i class="fas fa-key me-2"></i>Cambiar Contraseña (Opcional)
                        </h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Solo completa estos campos si deseas cambiar la contraseña
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Nueva Contraseña
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                >
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Confirmar Nueva Contraseña
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
