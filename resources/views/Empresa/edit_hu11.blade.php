@extends('layouts.PlantillaCRUD')

@section('styles')
    <style>

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
            color: white !important;
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }


        .form-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            color: white;
        }

        /* Títulos del formulario */
        h2 {
            color: #ffffff;
            font-weight: 700;
        }

        /* Etiquetas de formulario */
        .form-label {
            color: #f0f0f0;
            font-weight: 500;
        }

        /* Mensajes de éxito */
        .alert-success {
            background-color: #f0fdf4;
            border-color: #86efac;
            color: #166534;
        }

        /* Mensajes de error */
        .alert-danger {
            background-color: #fef2f2;
            border-color: #fca5a5;
            color: #991b1b;
        }

        /* Inputs */
        .form-control {
            border-radius: 6px;
        }
    </style>
@endsection

@section('contenido')
    <div class="container mt-4">
        <div class="form-card mx-auto" style="max-width: 600px;">
            <h2 class="mb-4 text-center">Editar Empresa de Buses</h2>

            @if(session('success'))
                <div class="mb-3 text-end">
                    <a href="{{ url('/hu10/empresas-buses') }}" class="btn btn-info">
                        Empresa actualizada
                    </a>
                </div>
            @endif


            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('empresa.update.hu11', $empresa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre de la Empresa *</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $empresa->nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Propietario *</label>
                    <input type="text" name="propietario" class="form-control" value="{{ old('propietario', $empresa->propietario) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono *</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $empresa->telefono) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $empresa->email) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección *</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $empresa->direccion) }}" required>
                </div>

                <div class="d-flex justify-content-between">

                    <a href="{{ url('/hu10/empresas-buses') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection
