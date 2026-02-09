@extends('layouts.layoutadmin')

@section('title', 'Registrar Empleado')

@section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header">
                <h3>Registrar Empleado</h3>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('empleados.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Apellido</label>
                            <input type="text" name="apellido" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>DNI</label>
                            <input type="text" name="dni" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Cargo</label>
                            <input type="text" name="cargo" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Fecha ingreso</label>
                            <input type="date" name="fecha_ingreso" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Rol</label>
                            <select name="rol" class="form-select" required>
                                <option value="">-- Seleccione --</option>
                                <option value="Empleado">Empleado</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Chofer">Chofer</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>

                        <div class="col-12 text-end mt-3">
                            <button class="btn btn-primary">
                                Registrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
