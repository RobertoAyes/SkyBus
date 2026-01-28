@extends('layouts.layoutuser')

@section('title', 'Registrar Empresa')

@section('contenido')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#00b7ff;">Registrar Empresa</h2>
                <p class="mt-2 mb-0">Completa los datos para registrar una nueva empresa de transporte</p>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('usuario.empresa.form') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label>Nombre de la empresa *</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        <div class="invalid-feedback">Por favor ingresa el nombre de la empresa.</div>
                    </div>

                    <div class="mb-3">
                        <label>Propietario *</label>
                        <input type="text" name="propietario" class="form-control" value="{{ old('propietario') }}" required>
                        <div class="invalid-feedback">Por favor ingresa el nombre del propietario.</div>
                    </div>

                    <div class="mb-3">
                        <label>Teléfono *</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" pattern="[839][0-9]{7}" required>
                        <div class="invalid-feedback">Por favor ingresa un número válido (8, 3 o 9 seguido de 7 dígitos).</div>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        <div class="invalid-feedback">Por favor ingresa un correo válido.</div>
                    </div>

                    <div class="mb-3">
                        <label>Dirección *</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
                        <div class="invalid-feedback">Por favor ingresa la dirección.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Empresa</button>
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
