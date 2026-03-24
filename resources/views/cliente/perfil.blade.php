@extends('layouts.layoutuser')
@section('contenido')

    <style>
        html, body {
            height: auto !important;
            overflow: visible !important;
            background: #f3f6fb;
        }

        .container-profile {
            max-width: 1100px;
            margin: auto;
        }

        .layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 30px;
            align-items: start;
        }

        /* SIDEBAR */
        .sidebar {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #dfe6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            font-weight: bold;
            margin: auto;
            margin-bottom: 10px;
        }

        .name {
            font-weight: 700;
            font-size: 16px;
        }

        .menu {
            margin-top: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #eef2ff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #3b5bdb;
        }

        /* CONTENIDO */
        .info-box {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .top-card {
            background: linear-gradient(90deg, #4f6edb, #6ea8fe);
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .info-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .info-group {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .label {
            font-size: 12px;
            color: #888;
            font-weight: 600;
        }

        .value {
            font-size: 15px;
            font-weight: 600;
            color: #222;
            margin-top: 5px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 5px;
        }

        .badge-role {
            background: #e7f0ff;
            color: #3b5bdb;
        }

        .badge-status {
            background: #d4edda;
            color: #155724;
        }

        .actions {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

    </style>

    <div class="container mt-4 container-profile">

        <div class="layout">

            <!-- SIDEBAR -->
            <div class="sidebar">
                <div class="avatar">
                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                </div>

                <div class="name">{{ $usuario->name }}</div>

                <div class="menu">
                    <div class="menu-item">
                        <i class="fas fa-user"></i> Perfil
                    </div>
                    <div class="menu-item">
                        <i class="fas fa-envelope"></i> {{ $usuario->email }}
                    </div>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="info-box">

                <div class="top-card">
                    <h4>Información del Usuario</h4>
                    <small>Detalles generales de tu cuenta</small>
                </div>

                <div class="info-columns">

                    <!-- COLUMNA 1 -->
                    <div class="info-group">

                        <div class="info-item">
                            <span class="label">Nombre Completo</span>
                            <span class="value">{{ $usuario->name }}</span>
                        </div>



                        <div class="info-item">
                            <span class="label">Teléfono</span>
                            <span class="value">{{ $usuario->telefono ?? 'No registrado' }}</span>
                        </div>

                        <div class="info-item">
                            <span class="label">Tipo de Cuenta</span>
                            <span class="badge badge-role">{{ ucfirst($usuario->role) }}</span>
                        </div>

                    </div>

                    <!-- COLUMNA 2 -->
                    <div class="info-group">



                        <div class="info-item">
                            <span class="label">Miembro Desde</span>
                            <span class="value">{{ $usuario->created_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="info-item">
                            <span class="label">DNI</span>
                            <span class="value">{{ $usuario->dni ?? 'No registrado' }}</span>
                        </div>

                        <div class="info-item">
                            <span class="label">Estado</span>
                            <span class="badge badge-status">{{ ucfirst($usuario->estado) }}</span>
                        </div>

                    </div>

                </div>

                <div class="actions">
                    <button class="btn btn-outline-secondary"
                            data-bs-toggle="modal" data-bs-target="#editarPerfil">
                        Editar
                    </button>

                    <a href="{{ route('cliente.historial') }}" class="btn btn-primary">
                        Historial
                    </a>
                </div>

            </div>

        </div>
    </div>

    <!-- MODAL CORREGIDO -->
    <div class="modal fade" id="editarPerfil" tabindex="-1" aria-labelledby="editarPerfilLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="editarPerfilLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('cliente.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name', $usuario->name) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ old('email', $usuario->email) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control"
                                       value="{{ old('telefono', $usuario->telefono) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" name="dni" id="dni" class="form-control"
                                       value="{{ old('dni', $usuario->dni) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Nueva Contraseña (Opcional)</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>

                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
