@extends('layouts.layoutchofer')

@section('title', 'Dashboard de Usuario')

@section('contenido')
    <div class="container">
        <h1>Bienvenido, {{ Auth::user()->nombre_completo ?? 'Chofer' }}</h1>
        <p>Este es tu panel de control.</p>
    </div>
@endsection
