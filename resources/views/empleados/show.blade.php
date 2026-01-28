<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Empleado - BusTrak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; min-height: 100vh; padding: 40px 0; display: flex; justify-content: center; align-items: flex-start; }
        .card { background: #fff; border-radius: 20px; padding: 30px 40px; max-width: 600px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .header { display: flex; align-items: center; gap: 20px; border-bottom: 3px solid #667eea; padding-bottom: 15px; margin-bottom: 25px; }
        .profile-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #667eea; }
        h2 { color: #4a4a4a; margin: 0; }
        .info p { font-size: 15px; color: #333; margin-bottom: 6px; }
        .info strong { color: #555; }
        .estado-activo { color: #2ecc71; font-weight: 600; }
        .estado-inactivo { color: #e74c3c; font-weight: 600; }
        .btn { border-radius: 8px; font-size: 14px; font-weight: 600; padding: 8px 14px; margin: 5px; }
        .btn-warning { background: #f1c40f; border: none; color: #333; }
        .btn-danger { background: #e74c3c; border: none; }
        .btn-secondary { background: #95a5a6; border: none; }
        .btn-success { background: #2ecc71; border: none; color: #fff; }
        .btn-info { background: #3498db; border: none; color: #fff; }
        .text-center { margin-top: 15px; }
        .modal-content { border-radius: 15px; border: none; box-shadow: 0 8px 30px rgba(0,0,0,0.3); }
        .modal-header { background: #e74c3c; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; }
        .modal-body textarea { border-radius: 10px; border: 1px solid #ccc; resize: none; }
        .modal-footer .btn-danger { background: #e74c3c; }
        .modal-footer .btn-secondary { background: #6c757d; }
    </style>
</head>
<body>
<div class="card">
    <div class="header">
        @if($empleado->foto && file_exists(storage_path('app/public/'.$empleado->foto)))
            <img src="{{ asset('storage/'.$empleado->foto) }}" class="profile-img" alt="Foto del empleado">
        @else
            <img src="https://via.placeholder.com/100?text=Sin+Foto" class="profile-img" alt="Sin foto">
        @endif
        <div>
            <h2>{{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
            <p class="text-muted mb-0">{{ $empleado->cargo }}</p>
        </div>
    </div>

    <div class="info">
        <p><strong>Correo:</strong> {{ $empleado->email }}</p>
        <p><strong>Contraseña inicial:</strong> {{ $password_display }}</p>
        <p><strong>Rol:</strong> {{ $empleado->rol }}</p>
        <p><strong>DNI:</strong> {{ $empleado->dni }}</p>
        <p><strong>Fecha ingreso:</strong> {{ $empleado->fecha_ingreso }}</p>
        <p><strong>Estado:</strong>
            <span class="{{ $empleado->estado === 'Activo' ? 'estado-activo' : 'estado-inactivo' }}">
                {{ $empleado->estado }}
            </span>
        </p>
    </div>

    <div class="text-center">
        <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning">Editar</a>

        @if($empleado->estado === 'Activo')
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#desactivarModal">
                Desactivar
            </button>
        @else
            <form action="{{ route('empleados.activar', $empleado->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success">Activar</button>
            </form>

            @if($empleado->motivo_baja)
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#motivoModal">
                    Ver motivo de baja
                </button>
            @endif
        @endif

        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>

<!-- Modal de desactivación -->
<div class="modal fade" id="desactivarModal" tabindex="-1" aria-labelledby="desactivarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="desactivarModalLabel">Desactivar empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('empleados.desactivar', $empleado->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="text-danger fw-semibold mb-2">⚠️ Esta acción marcará al empleado como inactivo.</p>
                    <div class="mb-3">
                        <label for="motivo_baja" class="form-label">Motivo de baja:</label>
                        <textarea name="motivo_baja" id="motivo_baja" rows="3" class="form-control" placeholder="Describe brevemente el motivo de la desactivación..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar desactivación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal motivo de baja -->
@if($empleado->estado === 'Inactivo' && $empleado->motivo_baja)
    <div class="modal fade" id="motivoModal" tabindex="-1" aria-labelledby="motivoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="motivoModalLabel">Motivo de baja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Fecha y hora de desactivación:</strong>
                        {{ $empleado->fecha_desactivacion instanceof \Carbon\Carbon ? $empleado->fecha_desactivacion->format('d/m/Y H:i:s') : $empleado->fecha_desactivacion ?? 'No registrada' }}
                    </p>
                    <p><strong>Motivo de baja:</strong> {{ $empleado->motivo_baja }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
