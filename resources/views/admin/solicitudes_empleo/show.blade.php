@extends('layouts.layoutadmin')

@section('content')
    <div class="container mt-4">
        <h2>Detalle de Solicitud</h2>

        <div class="card shadow-sm border-0 p-4">
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

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.solicitudes.empleo') }}"
                   class="btn btn-outline-primary px-4">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
    </div>
@endsection
