@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-5">
        <h2>Editar Departamento</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.departamentos.update', $departamento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $departamento->nombre }}" required>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
            </div>

            @if($departamento->imagen)
                <div class="mb-3">
                    <p>Imagen actual:</p>
                    <img src="{{ asset('storage/' . $departamento->imagen) }}" alt="Imagen" class="img-fluid" style="max-height:200px;">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Actualizar Departamento</button>
        </form>
    </div>
@endsection
