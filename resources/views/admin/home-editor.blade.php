@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Editar Página Principal</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Título --}}
            <div class="mb-3">
                <label for="titulo" class="form-label">Título principal</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $homeConfig->titulo ?? '' }}">
            </div>

            {{-- Subtítulo --}}
            <div class="mb-3">
                <label for="subtitulo" class="form-label">Subtítulo</label>
                <textarea class="form-control" id="subtitulo" name="subtitulo" rows="3">{{ $homeConfig->subtitulo ?? '' }}</textarea>
            </div>



            {{-- Departamentos --}}
            <h4 class="mt-4">Departamentos</h4>
            @if($departamentos->count() > 0)
                <div class="row">
                    @foreach($departamentos as $dep)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ $dep->imagen ?? '/catalago/img/default.jpg' }}" class="card-img-top" alt="{{ $dep->nombre }}">
                                <div class="card-body text-center">
                                    <h5>{{ $dep->nombre }}</h5>
                                    <a href="{{ route('admin.departamentos.edit', $dep->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="{{ route('admin.lugares.index', ['departamento_id'=>$dep->id]) }}" class="btn btn-info btn-sm mt-2">Lugares</a>
                                    <a href="{{ route('admin.comidas.index', ['departamento_id'=>$dep->id]) }}" class="btn btn-warning btn-sm mt-2">Comidas</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No hay departamentos registrados.</p>
            @endif

            <button type="submit" class="btn btn-primary mt-4">Guardar cambios</button>
        </form>


    </div>
@endsection
