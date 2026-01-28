z@extends('layouts.apps')

@section('content')
    <div class="container-fluid py-4" style="min-height:100vh; background: #f3f7fb;">
        <div class="row">
            <div class="col-12 px-5">
                {{-- Header --}}
                <div style="background: white; border-radius: 16px; padding: 30px; margin-top: 20px; box-shadow: 0 4px 12px rgba(30, 99, 184, 0.1);">
                    <h2 style="margin:0; color:#1e63b8; font-weight:600; font-size:2rem;">
                        <i class="fas fa-user-circle"></i>Informacion completa de usuario
                    </h2>
                </div>

                {{-- Contenido --}}
                <div style="margin-top:20px; background:white; border-radius:16px; padding:40px; box-shadow: 0 4px 12px rgba(30, 99, 184, 0.1);">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color:#000000; font-size:0.95rem; margin-bottom:8px; display:block;">
                                <i class="fas fa-user me-2"></i>Nombre Completo
                            </label>
                            <p style="font-size:1.1rem; color:#2c3e50; padding-bottom:12px; border-bottom:2px solid #f3f7fb; margin:0;">
                                {{ $usuario->nombre_completo }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color:#000000; font-size:0.95rem; margin-bottom:8px; display:block;">
                                <i class="fas fa-id-card me-2"></i>DNI
                            </label>
                            <p style="font-size:1.1rem; color:#2c3e50; padding-bottom:12px; border-bottom:2px solid #f3f7fb; margin:0;">
                                {{ $usuario->dni }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color:#000000; font-size:0.95rem; margin-bottom:8px; display:block;">
                                <i class="fas fa-envelope me-2"></i>Correo Electronico
                            </label>
                            <p style="font-size:1.1rem; color:#2c3e50; padding-bottom:12px; border-bottom:2px solid #f3f7fb; margin:0;">
                                {{ $usuario->email }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color:#000000; font-size:0.95rem; margin-bottom:8px; display:block;">
                                <i class="fas fa-phone me-2"></i>Telefono
                            </label>
                            <p style="font-size:1.1rem; color:#2c3e50; padding-bottom:12px; border-bottom:2px solid #f3f7fb; margin:0;">
                                {{ $usuario->telefono ?? 'No registrado' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color:#000000; font-size:0.95rem; margin-bottom:8px; display:block;">
                                <i class="fas fa-calendar-plus me-2"></i>Fecha de Registro
                            </label>
                            <p style="font-size:1.1rem; color:#000000; padding-bottom:12px; border-bottom:2px solid #f3f7fb; margin:0;">
                                @if($usuario->created_at)
                                    {{ $usuario->created_at->format('d/m/Y H:i:s') }}
                                @else
                                    No disponible
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color:#000000; font-size:0.95rem; margin-bottom:8px; display:block;">
                                <i class="fas fa-calendar-check me-2"></i>Ultima Actualizacion
                            </label>
                            <p style="font-size:1.1rem; color:#2c3e50; padding-bottom:12px; border-bottom:2px solid #f3f7fb; margin:0;">
                                @if($usuario->updated_at)
                                    {{ $usuario->updated_at->format('d/m/Y H:i:s') }}
                                @else
                                    No disponible
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5 pt-4" style="border-top:2px solid #f3f7fb;">
                        <a href="{{ route('usuarios.index') }}" class="btn" style="background:#6c757d; color:white; font-weight:600; border-radius:8px; padding:0 24px; height: 45px; border: none; display: inline-flex; align-items: center;">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Listado
                        </a>
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn" style="background:#1e63b8; color:white; font-weight:600; border-radius:8px; padding:0 24px; height: 45px; border: none; display: inline-flex; align-items: center;">
                            <i class="fas fa-edit me-2"></i>Editar Usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
