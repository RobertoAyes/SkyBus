@extends('layouts.layoutuser')

@section('title', 'Enviar Solicitud de Empleo')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-file-alt me-2"></i> Enviar Solicitud de Empleo
                </h2>
            </div>

            <div class="card-body">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        <strong class="me-2">Error:</strong> {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ERRORES DE VALIDACIÓN --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong class="me-2">¡Errores en el formulario!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('solicitud.empleo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- NOMBRE COMPLETO --}}
                    <div class="mb-3">
                        <label for="nombre_completo" class="form-label fw-bold">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror"
                               id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}"
                               placeholder="Ingrese su nombre completo"
                               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios" required>
                        @error('nombre_completo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CORREO --}}
                    <div class="mb-3">
                        <label for="contacto" class="form-label fw-bold">Correo de Contacto <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('contacto') is-invalid @enderror"
                               id="contacto" name="contacto" value="{{ old('contacto') }}"
                               placeholder="ejemplo@correo.com" required>
                        @error('contacto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PUESTO --}}
                    <div class="mb-3">
                        <label for="puesto_deseado" class="form-label fw-bold">Puesto Deseado <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('puesto_deseado') is-invalid @enderror"
                               id="puesto_deseado" name="puesto_deseado" value="{{ old('puesto_deseado') }}"
                               placeholder="Ej: Conductor, Gerente, etc." required>
                        @error('puesto_deseado')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EXPERIENCIA LABORAL --}}
                    <div class="mb-3">
                        <label for="experiencia_laboral" class="form-label fw-bold">Experiencia Laboral <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('experiencia_laboral') is-invalid @enderror"
                                  id="experiencia_laboral" name="experiencia_laboral" rows="4"
                                  placeholder="Describa su experiencia laboral..." required>{{ old('experiencia_laboral') }}</textarea>
                        @error('experiencia_laboral')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Mínimo 10 caracteres</small>
                    </div>

                    {{-- CV --}}
                    <div class="mb-3">
                        <label for="cv" class="form-label fw-bold">Adjuntar CV <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('cv') is-invalid @enderror"
                               id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                        @error('cv')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Formatos aceptados: PDF, DOC, DOCX (máximo 2MB)</small>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-paper-plane me-1"></i> Enviar Solicitud
                        </button>
                        <a href="{{ route('solicitud.empleo.mis-solicitudes') }}" class="btn btn-secondary flex-grow-1">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <style>
        .card-header h2 { font-weight: 600; font-size: 2rem; color: #1e63b8; }
        .btn-primary { background-color: #1e63b8; border-color: #1e63b8; }
        .btn-primary:hover { background-color: #145a9e; border-color: #145a9e; }
        .alert-success { background-color: #e7f1ff; border-color: #b6d4ff; color: #1e63b8; }
        .alert-danger { background-color: #f8d7da; border-color: #f5c2c7; color: #842029; }
        .form-control:focus { border-color: #1e63b8; box-shadow: 0 0 0 0.2rem rgba(30,99,184,.25); }
        .card { border-radius: 0.5rem; }
    </style>
@endsection
