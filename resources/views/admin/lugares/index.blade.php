@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-5">
        <h2>Lugares del Departamento: {{ $departamento->nombre }}</h2>

        <a href="{{ route('admin.lugares.create', ['departamento_id' => $departamento->id]) }}" class="btn btn-success mb-3">Agregar Lugar</a>

        @if($lugares->count() > 0)
            <div class="row">
                @foreach($lugares as $lugar)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $lugar->imagen ?? '/catalago/img/default.jpg' }}" class="card-img-top" alt="{{ $lugar->nombre }}">
                            <div class="card-body text-center">
                                <h5>{{ $lugar->nombre }}</h5>
                                <a href="{{ route('admin.lugares.edit', $lugar->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                <form action="{{ route('admin.lugares.destroy', $lugar->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No hay lugares registrados en este departamento.</p>
        @endif
    </div>
@endsection
