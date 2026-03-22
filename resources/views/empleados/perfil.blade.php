@extends('layouts.layoutempleado')

@section('contenido')
    <div class="container mt-4">
        <h2>Mi Perfil</h2>

        <div class="card p-3">
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
    </div>
@endsection
