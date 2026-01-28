@extends('layouts.layoutadmin')

@section('title', 'Registrar Empleado')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:1.8rem;">
                    <i class="fas fa-user-plus me-2"></i>Registrar Empleado
                </h2>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('empleados.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" name="dni" id="dni" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cargo" class="form-label">Cargo</label>
                            <input type="text" name="cargo" id="cargo" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
                            <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol</label>
                            <select name="rol" class="form-select" required>
                                <option value="">-- Seleccione Rol --</option>
                                <option value="Empleado">Empleado</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="foto" class="form-label">Foto del Empleado</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                            <!-- Previsualización -->
                            <div class="mt-3">
                                <img id="preview" src="#" alt="Previsualización" style="display:none; max-width:150px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <a href="{{ route('empleados.hu5') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-1"></i>Registrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const fotoInput = document.getElementById('foto');
        const previewImg = document.getElementById('preview');

        fotoInput.addEventListener('change', function(event) {
            const [file] = fotoInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
                previewImg.style.display = 'block';
            } else {
                previewImg.style.display = 'none';
            }
        });
    </script>
@endsection
