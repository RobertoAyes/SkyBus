@extends('layouts.layoutuser') {{-- Asegúrate de tener un layout para usuarios --}}

@section('title', 'Cambiar Contraseña Usuario')

@section('contenido')
    <div class="container mt-5">
        <h2>Cambiar Contraseña</h2>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Errores de validación --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('usuario.update-password') }}">
            @csrf

            <div class="mb-3">
                <label for="password_actual" class="form-label">Contraseña Actual</label>
                <input type="password" name="password_actual" id="password_actual" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_nuevo" class="form-label">Nueva Contraseña</label>
                <input type="password" name="password_nuevo" id="password_nuevo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_nuevo_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_nuevo_confirmation" id="password_nuevo_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
        </form>
    </div>
@endsection
