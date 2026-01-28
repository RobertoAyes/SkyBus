@extends('layouts.layoutadmin')

@section('title', 'Registrar Empresa')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#00b7ff; font-weight:600; font-size:1.8rem;">
                    Registrar Empresa
                </h2>
                <p class="mt-2 mb-0">Completa los datos para registrar una nueva empresa de transporte</p>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <!-- Icono Éxito -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00b7ff" class="bi bi-check-circle me-2" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7 11l-3-3 1-1 2 2 4-4 1 1-5 5z"/>
                        </svg>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <!-- Icono Error -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff4d4f" class="bi bi-exclamation-triangle me-2" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1 1 0 0 1 1.036 0l6.857 3.95A1 1 0 0 1 16 6.382v7.236a1 1 0 0 1-.525.894l-6.857 3.95a1 1 0 0 1-1.036 0L1.525 14.512A1 1 0 0 1 1 13.618V6.382a1 1 0 0 1 .525-.894l6.857-3.95zM8 5c-.535 0-.954.462-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 5zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                        </svg>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('empresa.form') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Nombre Empresa -->
                    <div class="mb-3">
                        <label class="form-label">Nombre de la empresa *</label>
                        <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00b7ff" class="bi bi-building-fill" viewBox="0 0 16 16">
                                <path d="M14 0H2a1 1 0 0 0-1 1v15h2V11h10v5h2V1a1 1 0 0 0-1-1zM4 2h2v2H4V2zm0 3h2v2H4V5zm0 3h2v2H4V8zm3-6h2v2H7V2zm0 3h2v2H7V5zm0 3h2v2H7V8zm3-6h2v2h-2V2zm0 3h2v2h-2V5zm0 3h2v2h-2V8z"/>
                            </svg>
                        </span>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                            <div class="invalid-feedback">Por favor ingresa el nombre de la empresa.</div>
                        </div>
                    </div>

                    <!-- Propietario -->
                    <div class="mb-3">
                        <label class="form-label">Propietario *</label>
                        <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00b7ff" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </span>
                            <input type="text" name="propietario" class="form-control" value="{{ old('propietario') }}" required>
                            <div class="invalid-feedback">Por favor ingresa el nombre del propietario.</div>
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label class="form-label">Teléfono *</label>
                        <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00b7ff" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547c.52-.13.971-.014 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611L10.74 15c-.838.838-2.32-.288-5.322-3.322C2.083 8.36 1.055 6.88 1.879 6.052l.836-.836c.731-.73 1.956-.653 2.61.163l1.944 2.158z"/>
                            </svg>
                         </span>
                            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" pattern="[839][0-9]{7}" title="El número debe comenzar con 8, 3 o 9 y tener 8 dígitos" required>
                            <div class="invalid-feedback">Por favor ingresa un número válido (8, 3 o 9 seguido de 7 dígitos).</div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00b7ff" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v.217l-8 4.8-8-4.8V4zm0 1.383V12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5.383l-8 4.8-8-4.8z"/>
                            </svg>
                        </span>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            <div class="invalid-feedback">Por favor ingresa un correo válido.</div>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="mb-3">
                        <label class="form-label">Dirección *</label>
                        <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00b7ff" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                <path d="M12 6a4 4 0 1 0-8 0c0 1.5 2 5 4 7 2-2 4-5.5 4-7zM8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                            </svg>
                        </span>
                            <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
                            <div class="invalid-feedback">Por favor ingresa la dirección.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-save-fill me-2" viewBox="0 0 16 16">
                                <path d="M8 0a2 2 0 0 0-2 2v1H2v11h12V3h-4V2a2 2 0 0 0-2-2z"/>
                            </svg>
                            Guardar Empresa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection
