@extends('layouts.layoutuser')@section('contenido')<div class="container-fluid px-4"><!-- Breadcrumb --><nav aria-label="breadcrumb" class="mb-4"><ol class="breadcrumb" style="background-color: transparent; padding: 0;"><li class="breadcrumb-item"><a href="{{ route('cliente.perfil') }}" style="text-decoration: none; color: #5cb3ff;">Mi Perfil</a></li><li class="breadcrumb-item active" aria-current="page">Editar Perfil</li></ol></nav><div class="row">
        <div class="col-lg-7 mx-auto">

            <!-- Card del Formulario de Edición -->
            <div class="card border-0 shadow-lg" style="border-radius: 16px;">

                <div style="background: linear-gradient(135deg, #1e63b8 0%, #5cb3ff 100%); border-radius: 16px 16px 0 0; padding: 25px; color: white;">
                    <h4 style="margin: 0; font-weight: 700;"><i class="fas fa-user-edit me-2"></i> Actualizar mi información</h4>
                    <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Modifica tu nombre y correo electrónico. Deja los campos de contraseña vacíos para mantener la actual.</p>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('cliente.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="name" class="form-label" style="font-weight: 600; color: #333;">Nombre completo</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $usuario->name) }}"
                                   required
                                   style="border-radius: 8px; padding: 10px 15px;">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-4">
                            <label for="email" class="form-label" style="font-weight: 600; color: #333;">Correo electrónico</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $usuario->email) }}"
                                   required
                                   style="border-radius: 8px; padding: 10px 15px;">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <h5 class="mt-5 mb-3" style="font-weight: 700; color: #1e63b8;">Cambio de contraseña (opcional)</h5>

                        <div class="mb-4">
                            <label for="password" class="form-label" style="font-weight: 600; color: #333;">Nueva contraseña</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Mínimo 8 caracteres"
                                   style="border-radius: 8px; padding: 10px 15px;">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="password_confirmation" class="form-label" style="font-weight: 600; color: #333;">Confirmar nueva contraseña</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   placeholder="Mínimo 8 caracteres"
                                   name="password_confirmation"
                                   style="border-radius: 8px; padding: 10px 15px;">
                        </div>

                        <!-- Campos de Rol y Estado (Solo Informativos) -->
                        <h5 class="mt-5 mb-3" style="font-weight: 700; color: #999;">Información de cuenta</h5>

                        <div class="row mb-5">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label" style="font-weight: 600; color: #999;">Rol</label>
                                <input type="text" class="form-control" value="{{ ucfirst($usuario->role) }}" disabled style="border-radius: 8px; background-color: #f0f0f0;">
                                <small class="text-muted">El rol solo puede ser modificado por un administrador.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label" style="font-weight: 600; color: #999;">Estado</label>
                                <input type="text" class="form-control" value="{{ ucfirst($usuario->estado) }}" disabled style="border-radius: 8px; background-color: #f0f0f0;">
                                <small class="text-muted">El estado solo puede ser modificado por un administrador.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3">
                            <a href="{{ route('cliente.perfil') }}"
                               class="btn"
                               style="padding: 10px 24px; border: 2px solid #ddd; background: white; color: #333; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;"
                               onmouseover="this.style.background='#f5f5f5'; this.style.borderColor='#bbb';"
                               onmouseout="this.style.background='white'; this.style.borderColor='#ddd';">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit"
                                    class="btn"
                                    style="padding: 10px 30px; background: #5cb3ff; color: white; border: none; border-radius: 8px; font-weight: 700; transition: all 0.3s ease;"
                                    onmouseover="this.style.background='#3d97f0'; this.style.transform='translateY(-2px)'; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                    onmouseout="this.style.background='#5cb3ff'; this.style.transform='translateY(0)'; box-shadow: none;">
                                <i class="fas fa-save me-2"></i> Actualizar perfil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
