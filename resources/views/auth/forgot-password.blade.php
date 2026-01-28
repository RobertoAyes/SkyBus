<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - BusTrak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e63b8 0%, #1976d2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .forgot-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo h1 {
            color: #1e63b8;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .logo p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
        .form-group {
            margin: 25px 0;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #1e63b8;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1e63b8 0%, #1976d2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #1e63b8;
            text-decoration: none;
            font-size: 14px;
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: modalAppear 0.3s ease;
        }
        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .modal-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .modal-header .icon {
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 15px;
        }
        .modal-header h2 {
            color: #1e63b8;
            font-size: 26px;
            margin-bottom: 10px;
        }
        .modal-header p {
            color: #666;
            font-size: 14px;
        }
        .info-box {
            background: #f5f5f5;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .info-row {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-weight: 700;
            color: #1e63b8;
            min-width: 110px;
            font-size: 15px;
            flex-shrink: 0;
        }
        .info-value {
            color: #333;
            font-size: 14px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.4;
            flex: 1;
        }
        .modal-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1e63b8 0%, #1976d2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        .modal-btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<div class="forgot-container">
    <div class="logo">
        <h1>Recuperar Contraseña</h1>
        <p>Ingresa tu correo electrónico para recuperar tu contraseña.</p>
    </div>

    @if (session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="tu@email.com"
            >
            @error('email')
            <small style="color: #dc3545;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn">
            <i class="fas fa-paper-plane"></i> Enviar Instrucciones
        </button>
    </form>

    <div class="back-link">
        <a href="{{ route('login') }}">← Volver al inicio de sesión</a>
    </div>
</div>

<!-- MODAL -->
@if (session('user_data'))
    <div class="modal-overlay active" id="modalOverlay">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Contraseña Recuperada</h2>
                <p>Aquí están tus datos de acceso</p>
            </div>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Usuario:</span>
                    <span class="info-value">{{ session('user_data')['name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Correo:</span>
                    <span class="info-value">{{ session('user_data')['email'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contraseña:</span>
                    <span class="info-value">
                        @if(session('user_data')['password'] && session('user_data')['password'] !== 'No disponible')
                            {{ session('user_data')['password'] }}
                        @else
                            <span style="color: #d32f2f;">No disponible</span>
                        @endif
                    </span>
                </div>
            </div>

            <a href="{{ route('login') }}" class="modal-btn">
                <i class="fas fa-sign-in-alt"></i> Regresar al Login
            </a>
        </div>
    </div>
@endif

</body>
</html>
