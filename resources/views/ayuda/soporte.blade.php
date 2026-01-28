@php use Illuminate\Support\Facades\Auth; @endphp

@extends('layouts.layoutuser')

@section('contenido')
    <div class="d-flex justify-content-center">
        <div style="width: 100%; max-width: 700px;">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-headset me-2"></i>
                        Ayuda y Soporte
                    </h4>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

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

                    <form id="soporteForm" method="POST" action="{{ route('soporte.enviar') }}" autocomplete="off">
                        @csrf

                        <div class="mb-4">
                            <label for="nombre" class="form-label fw-bold">
                                Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ auth()->user()->name ?? '' }}"
                                   placeholder="Tu nombre completo"
                                   required>
                            @error('nombre')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="correo" class="form-label fw-bold">
                                Correo Electrónico <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   class="form-control @error('correo') is-invalid @enderror"
                                   id="correo"
                                   name="correo"
                                   value="{{ auth()->user()->email ?? '' }}"
                                   placeholder="tu@email.com"
                                   required>
                            @error('correo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="asunto" class="form-label fw-bold">
                                Asunto <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('asunto') is-invalid @enderror"
                                   id="asunto"
                                   name="asunto"
                                   placeholder="Asunto de tu consulta"
                                   required
                                   autocomplete="off">
                            @error('asunto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="mensaje" class="form-label fw-bold">
                                Mensaje <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('mensaje') is-invalid @enderror"
                                      id="mensaje"
                                      name="mensaje"
                                      rows="4"
                                      placeholder="Cuéntanos tu problema o duda en detalle..."
                                      maxlength="1000"
                                      required
                                      autocomplete="off"></textarea>
                            @error('mensaje')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">Máximo 1000 caracteres</small>
                                <small class="text-muted">
                                    <span id="char-counter">0</span>/1000 caracteres
                                </small>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-paper-plane me-1"></i> Enviar Consulta
                            </button>
                            <button type="reset" class="btn btn-secondary flex-grow-1">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info mt-4" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Importante:</strong> Completa todos los campos correctamente. Nos pondremos en contacto contigo lo antes posible.
            </div>
        </div>
    </div>

    <script>
        // Limpiar todos los campos del formulario al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const soporteForm = document.getElementById('soporteForm');
            const charCounter = document.getElementById('char-counter');

            // Resetear el formulario completamente
            if (soporteForm) {
                soporteForm.reset();
            }

            // Limpiar todos los inputs y textareas
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], textarea');
            inputs.forEach(input => {
                input.value = '';
            });

            // Reinicializar contador de caracteres
            if (charCounter) {
                charCounter.textContent = '0';
            }

            // Contador de caracteres
            const mensajeTextarea = document.getElementById('mensaje');
            if (mensajeTextarea && charCounter) {
                mensajeTextarea.addEventListener('input', function() {
                    const length = this.value.length;
                    charCounter.textContent = length;
                });
            }
        });
    </script>
@endsection
