<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTrak - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e63b8 0%, #1976d2 100%);
            overflow: hidden;
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

        .login-card {
            position: relative;
            z-index: 10;
            background: white;
            padding: 50px 45px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
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
            margin-bottom: 35px;
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
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #888;
            font-size: 13px;
            margin-top: 8px;
            letter-spacing: 0.5px;
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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #333;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
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

        input::placeholder {
            color: #aaa;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin: 20px 0 25px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: #1976d2;
        }

        .checkbox-text {
            color: #666;
            font-size: 13px;
        }

        .forgot-link {
            color: #1e63b8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
            margin-left: auto;
        }

        .forgot-link:hover {
            color: #1a4f90;
        }

        .btn-login {
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
            margin-bottom: 16px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(25, 118, 210, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-section {
            text-align: center;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }

        .register-text {
            color: #666;
            font-size: 13px;
        }

        .register-link {
            color: #1976d2;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .register-link:hover {
            color: #1565c0;
        }

        @media (max-width: 600px) {
            .login-card {
                margin: 20px;
                padding: 40px 25px;
            }

            .logo {
                width: 60px;
                height: 60px;
                font-size: 30px;
            }

            .logo-text {
                font-size: 24px;
            }
        }.btn-back {
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

<div class="container">
    <div class="background">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="bus-background"></div>
    </div>

    <div class="login-card">
        <div class="top-logo-wrapper">
            <a href="{{ route('interfaces.principal') }}" class="logo-container">
                <img src="/Imagenes/bustrak-logo.jpg" alt="BusTrak">
            </a>
        </div>


    @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="tu@email.com"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                >
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" class="checkbox-text">Recuérdame</label>
                <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>

        <div class="register-section">
            <span class="register-text">¿No tienes cuenta?
                <a href="{{ route('registro') }}" class="register-link">Regístrate aquí</a>
            </span>
        </div>
    </div>
</div>
</body>
</html>
