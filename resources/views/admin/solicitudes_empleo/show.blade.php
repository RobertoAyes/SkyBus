@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Detalle de Solicitud</h2>

        <div class="card p-4">
            <p><strong>Nombre:</strong> {{ $solicitud->nombre_completo }}</p>
            <p><strong>Contacto:</strong> {{ $solicitud->contacto }}</p>
            <p><strong>Puesto deseado:</strong> {{ $solicitud->puesto_deseado }}</p>
            <p><strong>Experiencia laboral:</strong></p>
            <p>{{ $solicitud->experiencia_laboral }}</p>

            @if($solicitud->cv)
                <p>
                    <strong>CV:</strong>
                    <a href="{{ asset('storage/' . $solicitud->cv) }}" target="_blank">
                        Ver CV
                    </a>
                </p>
            @endif

            <a href="{{ route('admin.solicitudes.empleo') }}" class="btn btn-secondary mt-3">
                Volver
            </a>
        </div>
    </div>
@endsection
