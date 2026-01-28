@extends('layouts.app')
@section('scripts')
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .registro-container {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e63b8 0%, #1976d2 100%);
            overflow: hidden;
            z-index: 0;
        }

        .bus-background {
            position: absolute;
            right: -200px;
            bottom: -100px;
            width: 800px;
            height: 600px;
            opacity: 0.08;
            pointer-events: none;
            font-size: 600px;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .circle1 {
            width: 300px;
            height: 300px;
            background: white;
            top: -100px;
            left: -100px;
        }

        .circle2 {
            width: 200px;
            height: 200px;
            background: white;
            bottom: -50px;
            right: 100px;
        }

        .register-card {
            position: relative;
            z-index: 10;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 600px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 120px;
            height: 80px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            border-radius: 35%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            box-shadow: 0 10px 30px rgba(25, 118, 210, 0.3);
            overflow: hidden;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-text {
            color: #1976d2;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #888;
            font-size: 13px;
            margin-top: 8px;
            letter-spacing: 0.5px;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            border-left: 4px solid #28a745;
            display: flex;
            align-items: center;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            border-left: 4px solid #dc3545;
        }

        .error-message ul {
            margin: 5px 0 0 0;
            padding-left: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            color: #333;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .required {
            color: #dc3545;
        }

        .input-wrapper {
            position: relative;
        }

        .icon-prefix {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            z-index: 1;
        }

        input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: #1976d2;
            box-shadow: 0 0 0 4px rgba(25, 118, 210, 0.1);
        }

        input.is-invalid {
            border-color: #dc3545;
        }

        input::placeholder {
            color: #aaa;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .invalid-feedback.d-block {
            display: block;
        }

        .hint-text {
            color: #888;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(25, 118, 210, 0.3);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(25, 118, 210, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .login-section {
            text-align: center;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
            margin-top: 20px;
        }

        .login-text {
            color: #666;
            font-size: 13px;
        }

        .login-link {
            color: #1976d2;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .login-link:hover {
            color: #1565c0;
        }

        @media (max-width: 768px) {
            .register-card {
                padding: 30px 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .logo {
                width: 60px;
                height: 50px;
                font-size: 30px;
            }

            .logo-text {
                font-size: 22px;
            }
        }
        .btn-back {
             position: absolute;
             top: 25px;
             left: 25px;
             background: #ffffff;
             color: #1976d2;
             padding: 8px 14px;
             border-radius: 25px;
             font-weight: 600;
             text-decoration: none;
             box-shadow: 0 2px 6px rgba(0,0,0,0.15);
             transition: all 0.3s ease;
             z-index: 50;
         }


        .btn-back:hover {
            background: #1976d2;
            color: #ffffff;
            transform: translateX(-2px);
        }
        .btn-back:hover {
            background: #1976d2;
            color: #ffffff;
            transform: translateX(-2px);
        }

        .top-logo-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
        }

        .logo-container img {
            width: 150px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="registro-container">
    <div class="background">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="bus-background">🚌</div>
    </div>

    <div class="register-card">
        <div class="logo-container">
            <div class="top-logo-wrapper">
                <a href="{{ route('interfaces.principal') }}" class="logo-container">
                    <img src="/Imagenes/bustrak-logo.png" alt="BusTrak">
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="success-message">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7 11l-3-3 1-1 2 2 4-4 1 1-5 5z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px; vertical-align: middle;">
                        <path d="M8.982 1.566a1 1 0 0 1 1.036 0l6.857 3.95A1 1 0 0 1 16 6.382v7.236a1 1 0 0 1-.525.894l-6.857 3.95a1 1 0 0 1-1.036 0L1.525 14.512A1 1 0 0 1 1 13.618V6.382a1 1 0 0 1 .525-.894l6.857-3.95z"/>
                    </svg>
                    <strong>Por favor corrige los siguientes errores:</strong>
                </div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/registro') }}" class="needs-validation" novalidate id="registroForm">
            @csrf

            <!-- Nombre Completo -->
            <div class="form-group full-width">
                <label>Nombre Completo <span class="required">*</span></label>
                <div class="input-wrapper">
                    <div class="icon-prefix">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1976d2" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="nombre_completo"
                        id="nombre_completo"
                        class="@error('nombre_completo') is-invalid @enderror"
                        value="{{ old('nombre_completo') }}"
                        placeholder="Ingresa tu nombre completo"
                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                        minlength="3"
                        maxlength="100"
                        required
                    >
                </div>
                @error('nombre_completo')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <!-- DNI -->
                <div class="form-group">
                    <label>DNI <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <div class="icon-prefix">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1976d2" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="dni"
                            id="dni"
                            class="@error('dni') is-invalid @enderror"
                            value="{{ old('dni') }}"
                            placeholder="1234567890123"
                            pattern="[0-9]{13}"
                            maxlength="13"
                            required
                        >
                    </div>
                    @error('dni')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div class="form-group">
                    <label>Teléfono <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <div class="icon-prefix">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1976d2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547c.52-.13.971-.014 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611L10.74 15c-.838.838-2.32-.288-5.322-3.322C2.083 8.36 1.055 6.88 1.879 6.052l.836-.836z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="telefono"
                            id="telefono"
                            class="@error('telefono') is-invalid @enderror"
                            value="{{ old('telefono') }}"
                            placeholder="12345678"
                            pattern="[0-9]{8}"
                            maxlength="8"
                            required
                        >
                    </div>
                    @error('telefono')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="form-group full-width">
                <label>Correo Electrónico <span class="required">*</span></label>
                <div class="input-wrapper">
                    <div class="icon-prefix">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1976d2" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v.217l-8 4.8-8-4.8V4zm0 1.383V12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5.383l-8 4.8-8-4.8z"/>
                        </svg>
                    </div>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="@error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="tu@email.com"
                        maxlength="100"
                        required
                    >
                </div>
                @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <!-- Contraseña -->
                <div class="form-group">
                    <label>Contraseña <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <div class="icon-prefix">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1976d2" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="@error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            minlength="8"
                            required
                        >
                    </div>
                    <span class="hint-text">Mínimo 8 caracteres</span>
                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group">
                    <label>Confirmar Contraseña <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <div class="icon-prefix">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1976d2" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="••••••••"
                            minlength="8"
                            required
                        >
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
                Registrarse
            </button>
        </form>

        <div class="login-section">
            <span class="login-text">¿Ya tienes cuenta?
                <a href="{{ url('/login') }}" class="login-link">Inicia sesión aquí</a>
            </span>
        </div>
    </div>
</div>

<script>
    // Validación de formulario
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

    // Permitir solo letras en Nombre Completo
    document.getElementById('nombre_completo').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    });

    // Permitir solo números en DNI
    document.getElementById('dni').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if(this.value.length > 13) {
            this.value = this.value.slice(0, 13);
        }
    });

    // Permitir solo números en Teléfono
    document.getElementById('telefono').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if(this.value.length > 8) {
            this.value = this.value.slice(0, 8);
        }
    });

    // Validar que las contraseñas coincidan
    document.getElementById('registroForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;

        if(password !== passwordConfirm) {
            e.preventDefault();
            e.stopPropagation();
            alert('Las contraseñas no coinciden');
        }
    });
</script>
</body>
</html>
@endsection
