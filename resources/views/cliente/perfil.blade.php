@extends('layouts.layoutuser')
@section('contenido')

    <div class="container-fluid px-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background-color: transparent; padding: 0;">
                <li class="breadcrumb-item active" aria-current="page">Mi Perfil</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-9 mx-auto">

                <!-- Header Card con Gradiente -->
                <div style="background: linear-gradient(135deg, #5cb3ff 0%, #1e63b8 100%); border-radius: 16px; padding: 40px; color: white; margin-bottom: 30px; display: flex; align-items: center; gap: 30px;">
                    <div style="width: 110px; height: 110px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 50px; font-weight: bold; border: 4px solid rgba(255,255,255,0.4); flex-shrink: 0;">
                        {{ strtoupper(substr($usuario->name, 0, 1)) }}
                    </div>
                    <div style="flex-grow: 1;">
                        <h2 style="margin: 0; font-size: 28px; font-weight: 700; text-transform: capitalize;">{{ $usuario->name }}</h2>
                        <p style="margin: 12px 0 0 0; font-size: 14px; opacity: 0.95;">
                            <i class="fas fa-check-circle me-2"></i> Cliente Verificado
                        </p>
                    </div>
                </div>

                <!-- Card de Información -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-4">

                        <!-- Nombre Completo -->
                        <div style="padding: 20px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">Nombre Completo</p>
                                <p style="margin: 8px 0 0 0; font-size: 16px; color: #333; font-weight: 600;">{{ $usuario->name }}</p>
                            </div>
                            <i class="fas fa-user" style="color: #5cb3ff; font-size: 24px;"></i>
                        </div>

                        <!-- Correo Electrónico -->
                        <div style="padding: 20px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex-grow: 1;">
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">Correo Electrónico</p>
                                <p style="margin: 8px 0 0 0; font-size: 16px; color: #333; font-weight: 600;">{{ $usuario->email }}</p>
                            </div>
                            <i class="fas fa-envelope" style="color: #5cb3ff; font-size: 24px; margin-left: 20px;"></i>
                        </div>

                        <!-- Tipo de Cuenta -->
                        <div style="padding: 20px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">Tipo de Cuenta</p>
                                <span style="display: inline-block; margin-top: 8px; padding: 6px 14px; background: #e3f2fd; color: #1e63b8; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                {{ ucfirst($usuario->role) }}
                            </span>
                            </div>
                            <i class="fas fa-id-card" style="color: #5cb3ff; font-size: 24px;"></i>
                        </div>

                        <!-- Estado de Cuenta -->
                        <div style="padding: 20px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">Estado de Cuenta</p>
                                <span style="display: inline-block; margin-top: 8px; padding: 6px 14px; background: #d4edda; color: #155724; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                <i class="fas fa-circle-dot me-1" style="font-size: 8px;"></i> {{ ucfirst($usuario->estado) }}
                            </span>
                            </div>
                            <i class="fas fa-shield-alt" style="color: #155724; font-size: 24px;"></i>
                        </div>

                        <!-- Miembro Desde -->
                        <div style="padding: 20px 0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">Miembro Desde</p>
                                <p style="margin: 8px 0 0 0; font-size: 16px; color: #333; font-weight: 600;">{{ $usuario->created_at->format('d \d\e F \d\e Y') }}</p>
                            </div>
                            <i class="fas fa-calendar-check" style="color: #5cb3ff; font-size: 24px;"></i>
                        </div>

                    </div>

                    <!-- Footer con Botones -->
                    <div style="background: #f8f9fa; padding: 20px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #f0f0f0; border-radius: 0 0 12px 12px;">
                        <button style="padding: 10px 24px; border: 2px solid #ddd; background: white; color: #333; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; transition: all 0.3s ease;"
                                onmouseover="this.style.background='#f5f5f5'; this.style.borderColor='#bbb';"
                                onmouseout="this.style.background='white'; this.style.borderColor='#ddd';"
                                data-bs-toggle="modal" data-bs-target="#editarPerfil">
                            <i class="fas fa-edit me-2"></i> Editar
                        </button>
                        <a href="{{ route('cliente.historial') }}" style="padding: 10px 24px; background: #5cb3ff; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease;"
                           onmouseover="this.style.background='#3d97f0'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='#5cb3ff'; this.style.transform='translateY(0)';">
                            <i class="fas fa-history"></i> Historial de Viajes
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal para editar perfil -->
    <div class="modal fade" id="editarPerfil" tabindex="-1" aria-labelledby="editarPerfilLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPerfilLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cliente.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" name="name" id="name"
                                   class="form-control" value="{{ old('name', $usuario->name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email"
                                   class="form-control" value="{{ old('email', $usuario->email) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono"
                                   class="form-control" value="{{ old('telefono', $usuario->telefono) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" name="dni" id="dni"
                                   class="form-control" value="{{ old('dni', $usuario->dni) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Nueva Contraseña (Opcional)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                        <!-- Puedes agregar más campos aquí -->
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
