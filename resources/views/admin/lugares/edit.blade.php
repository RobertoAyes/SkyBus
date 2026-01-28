@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-5">
        <h2>Editar Lugar: {{ $lugar->nombre }}</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.lugares.update', $lugar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del lugar</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $lugar->nombre }}">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del lugar</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
            </div>

            @if(!empty($lugar->imagen))
                <div class="mt-2">
                    <h6>Imagen actual:</h6>
                    <img src="{{ $lugar->imagen }}" alt="{{ $lugar->nombre }}" style="max-height:200px;">
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        </form>
    </div>
@endsection
