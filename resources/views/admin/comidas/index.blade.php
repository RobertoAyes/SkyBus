@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-5">
        <h2>Comidas de {{ $departamento->nombre }}</h2>
        <a href="{{ route('admin.comidas.create', ['departamento_id'=>$departamento->id]) }}" class="btn btn-success mb-3">Agregar Comida</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @foreach($comidas as $comida)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ $comida->imagen ?? '/catalago/img/default.jpg' }}" class="card-img-top" alt="{{ $comida->nombre }}">
                        <div class="card-body text-center">
                            <h5>{{ $comida->nombre }}</h5>
                            <a href="{{ route('admin.comidas.edit', $comida->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('admin.comidas.destroy', $comida->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta comida?')">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
