@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-5">
        <h2>Crear Nuevo Lugar</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.lugares.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="departamento_id" value="{{ $departamento_id }}">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del lugar</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del lugar</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
            </div>

            <button type="submit" class="btn btn-success mt-3">Guardar Lugar</button>
        </form>
    </div>
@endsection
