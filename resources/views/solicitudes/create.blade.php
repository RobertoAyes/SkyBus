@extends('layouts.layoutadmin')

@section('title', 'Solicitar Constancia de Trabajo')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Solicitud de Constancia de Trabajo
                    </h4>
                </div>
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('solicitudes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre') }}"
                                   placeholder="Ingrese el nombre completo"
                                   data-validation="letters"
                                   minlength="3"
                                   required>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Debe contener al menos dos palabras (nombre y apellido)</small>
                        </div>

                        <div class="mb-3">
                            <label for="dni" class="form-label">
                                Número de Identidad (DNI) <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('dni') is-invalid @enderror"
                                   id="dni"
                                   name="dni"
                                   value="{{ old('dni') }}"
                                   placeholder="Ej: 0801-1990-12345"
                                   maxlength="20"
                                   data-validation="dni"
                                   required>
                            @error('dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">
                                Motivo de la Solicitud <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('motivo') is-invalid @enderror"
                                      id="motivo"
                                      name="motivo"
                                      rows="3"
                                      placeholder="Describa el motivo de la solicitud (mínimo 10 caracteres)"
                                      data-validation="text"
                                      required>{{ old('motivo') }}</textarea>
                            @error('motivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <span id="motivoCount">0</span>/500 caracteres
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_entrega" class="form-label">
                                Fecha de Entrega Deseada <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   class="form-control @error('fecha_entrega') is-invalid @enderror"
                                   id="fecha_entrega"
                                   name="fecha_entrega"
                                   value="{{ old('fecha_entrega') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   required>
                            @error('fecha_entrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">La fecha debe ser posterior a hoy</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Enviar Solicitud
                            </button>
                            <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validación inteligente para cada campo según su propósito
        document.addEventListener('DOMContentLoaded', function() {

            // Contador de caracteres para el motivo
            const motivoField = document.getElementById('motivo');
            if (motivoField) {
                motivoField.addEventListener('input', function() {
                    document.getElementById('motivoCount').textContent = this.value.length;
                });
            }

            // Validación especial para nombres reales
            const nombreField = document.getElementById('nombre');
            if (nombreField) {
                nombreField.addEventListener('blur', function() {
                    const valor = this.value.trim();
                    const palabras = valor.split(/\s+/).filter(p => p.length > 0);

                    // Validar que tenga al menos 2 palabras (nombre y apellido)
                    if (palabras.length < 2) {
                        this.setCustomValidity('Debe ingresar al menos nombre y apellido');
                        this.classList.add('is-invalid');
                    }
                    // Validar que cada palabra tenga al menos 2 caracteres
                    else if (palabras.some(p => p.length < 2)) {
                        this.setCustomValidity('Cada nombre debe tener al menos 2 letras');
                        this.classList.add('is-invalid');
                    }
                    // Validar que no tenga caracteres repetidos más de 3 veces seguidas (ej: "aaaa")
                    else if (/(.)\1{3,}/.test(valor)) {
                        this.setCustomValidity('El nombre no puede tener letras repetidas más de 3 veces');
                        this.classList.add('is-invalid');
                    }
                    else {
                        this.setCustomValidity('');
                        this.classList.remove('is-invalid');
                    }
                });

                nombreField.addEventListener('input', function() {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                });
            }

            // Obtener todos los inputs con data-validation
            const inputs = document.querySelectorAll('[data-validation]');

            inputs.forEach(function(input) {
                input.addEventListener('input', function(e) {
                    const validationType = this.getAttribute('data-validation');

                    switch(validationType) {
                        case 'letters':
                            // Solo letras y espacios (para nombres)
                            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                            // Evitar múltiples espacios seguidos
                            this.value = this.value.replace(/\s{2,}/g, ' ');
                            break;

                        case 'numbers':
                            // Solo números
                            this.value = this.value.replace(/[^0-9]/g, '');
                            break;

                        case 'dni':
                            // Solo números y guiones (para DNI formato: 0801-1990-12345)
                            this.value = this.value.replace(/[^0-9-]/g, '');
                            break;

                        case 'alphanumeric':
                            // Letras, números y espacios
                            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]/g, '');
                            break;

                        case 'text':
                            // Texto libre con letras, números, espacios y puntuación básica
                            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:()\-¿?¡!]/g, '');
                            break;
                    }
                });
            });
        });
    </script>
@endsection
