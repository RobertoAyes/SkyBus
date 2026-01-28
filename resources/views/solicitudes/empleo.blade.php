@extends('layouts.layoutuser')

@section('title', 'Enviar Solicitud de Empleo')

@section('contenido')
    <div class="d-flex justify-content-center">
        <div style="width: 100%; max-width: 700px;">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Enviar Solicitud de Empleo
                    </h4>
                </div>
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>¡Errores en el formulario!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('solicitud.empleo.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="nombre_completo" class="form-label fw-bold">
                                Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror"
                                   id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}"
                                   placeholder="Ingrese su nombre completo"
                                   pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                                   title="Solo se permiten letras y espacios"
                                   data-validation="letters"
                                   required>
                            @error('nombre_completo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="contacto" class="form-label fw-bold">
                                Correo de Contacto <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('contacto') is-invalid @enderror"
                                   id="contacto" name="contacto" value="{{ old('contacto') }}"
                                   placeholder="ejemplo@correo.com" required>
                            @error('contacto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="puesto_deseado" class="form-label fw-bold">
                                Puesto Deseado <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('puesto_deseado') is-invalid @enderror"
                                   id="puesto_deseado" name="puesto_deseado" value="{{ old('puesto_deseado') }}"
                                   placeholder="Ej: Conductor, Gerente, etc."
                                   data-validation="alphanumeric"
                                   required>
                            @error('puesto_deseado')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="experiencia_laboral" class="form-label fw-bold">
                                Experiencia Laboral <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('experiencia_laboral') is-invalid @enderror"
                                      id="experiencia_laboral" name="experiencia_laboral" rows="4"
                                      placeholder="Describa su experiencia laboral..." required>{{ old('experiencia_laboral') }}</textarea>
                            @error('experiencia_laboral')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Mínimo 10 caracteres</small>
                        </div>

                        <div class="mb-4">
                            <label for="cv" class="form-label fw-bold">
                                Adjuntar CV <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control @error('cv') is-invalid @enderror"
                                   id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                            @error('cv')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formatos aceptados: PDF, DOC, DOCX (máximo 2MB)</small>
                        </div>

                        <div class="d-flex gap-2">
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

            <div class="alert alert-info mt-4" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Importante:</strong> Completa todos los campos correctamente. Tu solicitud será revisada por nuestro equipo de recursos humanos.
            </div>
        </div>
    </div>

    <script>
        // Validación inteligente para cada campo según su propósito
        document.addEventListener('DOMContentLoaded', function() {

            // Obtener todos los inputs con data-validation
            const inputs = document.querySelectorAll('[data-validation]');

            inputs.forEach(function(input) {
                input.addEventListener('input', function(e) {
                    const validationType = this.getAttribute('data-validation');

                    switch(validationType) {
                        case 'letters':
                            // Solo letras y espacios (para nombres)
                            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                            break;

                        case 'numbers':
                            // Solo números
                            this.value = this.value.replace(/[^0-9]/g, '');
                            break;

                        case 'alphanumeric':
                            // Letras, números y espacios (para puestos como "Gerente 1", "Supervisor A")
                            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]/g, '');
                            break;

                        case 'text':
                            // Texto libre con letras, números, espacios y puntuación básica
                            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:()\-]/g, '');
                            break;
                    }
                });
            });
        });
    </script>
@endsection
