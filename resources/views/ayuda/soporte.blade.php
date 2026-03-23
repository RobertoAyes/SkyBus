@extends('layouts.layoutuser')

@section('title', 'Ayuda y Soporte')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-headset me-2"></i> Ayuda y Soporte
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

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong class="me-2">¡Errores en el formulario!</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- FORMULARIO --}}
                <form id="soporteForm" method="POST" action="{{ route('soporte.enviar') }}" autocomplete="off">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre</label>
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

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Correo</label>
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

                    <div class="mb-3 mt-3">
                        <label class="form-label fw-bold">Asunto</label>
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
                        <label class="form-label fw-bold">Mensaje</label>
                        <textarea class="form-control @error('mensaje') is-invalid @enderror"
                                  id="mensaje"
                                  name="mensaje"
                                  rows="5"
                                  style="resize:none;"
                                  maxlength="1000"
                                  placeholder="Ej: Tengo un inconveniente con mi reserva #12345..."
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

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Enviar
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

    {{-- SCRIPT PARA CONTADOR DE CARACTERES --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const charCounter = document.getElementById('char-counter');
            const mensajeTextarea = document.getElementById('mensaje');
            if(mensajeTextarea && charCounter){
                mensajeTextarea.addEventListener('input', function(){
                    charCounter.textContent = this.value.length;
                });
            }
        });
    </script>

    {{-- ESTILOS SIMILARES A SERVICIOS ADICIONALES --}}
    <style>
        .card-header h2, .card-header h5 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e63b8;
        }

        .form-label.fw-bold { font-weight: 600; }
        .btn-primary { background-color: #1e63b8; border-color: #1e63b8; }
        .btn-primary:hover { background-color: #164b8f; border-color: #164b8f; }
        .btn-outline-secondary { border-color: #1e63b8; color: #1e63b8; }
        .btn-outline-secondary:hover { background-color: #1e63b8; color: #fff; }

        .table {
            table-layout: fixed;
            width: 100%;
        }
    </style>
@endsection
