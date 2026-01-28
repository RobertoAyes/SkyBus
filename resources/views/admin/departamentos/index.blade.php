@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-5">
        <h2>Departamentos</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.departamentos.create') }}" class="btn btn-success mb-3">Agregar Departamento</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($departamentos as $dep)
                <tr>
                    <td>{{ $dep->id }}</td>
                    <td>{{ $dep->nombre }}</td>
                    <td>
                        @if($dep->imagen)
                            <img src="{{ asset('storage/' . $dep->imagen) }}" alt="{{ $dep->nombre }}" style="height:50px;">
                        @else
                            No hay imagen
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.departamentos.edit', $dep->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('admin.departamentos.destroy', $dep->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
