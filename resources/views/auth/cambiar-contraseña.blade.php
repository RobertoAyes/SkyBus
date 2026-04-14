@extends('layouts.layoutadmin')

@section('title', 'Cambiar Contraseña Admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-key"></i> Cambiar Contraseña
                </h2>
            </div>

            <div class="card-body">

                {{-- ALERTA SUCCESS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ERRORES --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORMULARIO --}}
                <form method="POST" action="{{ route('admin.update-password') }}">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-12">
                            <label for="current_password" class="form-label fw-bold">
                                <i class="fas fa-lock me-1 text-secondary"></i> Contraseña Actual
                            </label>
                            <input type="password" name="current_password" id="current_password"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold">
                                <i class="fas fa-key me-1 text-primary"></i> Nueva Contraseña
                            </label>
                            <input type="password" name="password" id="password"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold">
                                <i class="fas fa-check me-1 text-success"></i> Confirmar Nueva Contraseña
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" required>
                        </div>

                    </div>

                    {{-- BOTÓN --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit"
                                class="btn btn-primary d-flex align-items-center gap-2"
                                style="min-width:180px; justify-content:center;">
                            <i class="fas fa-save"></i> Actualizar Contraseña
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
