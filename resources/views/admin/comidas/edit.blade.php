@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-5">
        <h2>Editar Comida</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('admin.comidas.update', $comida->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $comida->nombre) }}">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
            </div>

            @if($comida->imagen)
                <div class="mb-3">
                    <img src="{{ $comida->imagen }}" alt="{{ $comida->nombre }}" class="img-fluid" style="max-height:200px;">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
