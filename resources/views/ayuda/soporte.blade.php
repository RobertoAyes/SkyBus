@extends('layouts.layoutuser')

@section('contenido')
    <div class="container mt-3">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white py-3">
                <h5 class="mb-0" style="color:#1e63b8; font-weight:600;">
                    <i class="fas fa-headset me-2"></i> Ayuda y Soporte
                </h5>
            </div>

            <div class="card-body py-3">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>¡Errores en el formulario!</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- FORMULARIO --}}
                <form id="soporteForm" method="POST" action="{{ route('soporte.enviar') }}" autocomplete="off">
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Nombre</label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   name="nombre"
                                   value="{{ auth()->user()->name ?? '' }}"
                                   placeholder="Ej: Juan Pérez"
                                   maxlength="50"
                                   autocomplete="off"
                                   required>
                            @error('nombre')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Correo</label>
                            <input type="email"
                                   class="form-control @error('correo') is-invalid @enderror"
                                   name="correo"
                                   value="{{ auth()->user()->email ?? '' }}"
                                   placeholder="Ej: juanperez@email.com"
                                   maxlength="50"
                                   autocomplete="off"
                                   required>
                            @error('correo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Asunto</label>
                        <input type="text"
                               class="form-control @error('asunto') is-invalid @enderror"
                               name="asunto"
                               placeholder="Ej: Problema con mi reserva"
                               maxlength="50"
                               autocomplete="off"
                               required>
                        @error('asunto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mensaje</label>
                        <textarea class="form-control @error('mensaje') is-invalid @enderror"
                                  id="mensaje"
                                  name="mensaje"
                                  rows="4"
                                  style="resize:none;"
                                  maxlength="1000"
                                  placeholder="Ej: Tengo un inconveniente con mi reserva #12345, no puedo ver los detalles..."
                                  autocomplete="off"
                                  required></textarea>
                        @error('mensaje')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-muted">Máx 1000 caracteres</small>
                            <small class="text-muted">
                                <span id="char-counter">0</span>/1000
                            </small>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-paper-plane me-1"></i> Enviar
                        </button>
                        <button type="reset" class="btn btn-outline-secondary flex-fill">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-info mt-3" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            Completa todos los campos correctamente. <br>
            <span style="font-size:0.875rem;">Nos pondremos en contacto cuanto antes.</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const soporteForm = document.getElementById('soporteForm');
            const charCounter = document.getElementById('char-counter');

            if (soporteForm) soporteForm.reset();

            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], textarea');
            inputs.forEach(input => input.value = '');

            if (charCounter) charCounter.textContent = '0';

            const mensajeTextarea = document.getElementById('mensaje');
            if (mensajeTextarea && charCounter) {
                mensajeTextarea.addEventListener('input', function() {
                    charCounter.textContent = this.value.length;
                });
            }
        });
    </script>
@endsection
