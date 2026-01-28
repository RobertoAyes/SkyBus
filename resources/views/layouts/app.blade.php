<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bustrack')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #667eea 100%);
            min-height: 100vh;
            background-color: #001f3f;
            color: white;
        }

        /* Navbar con degradado morado */
        .navbar {
            background: linear-gradient(90deg, #667eea 0%, #667eea 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white !important;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            background-color: #00264d;
            border: none;
            color: #333;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(90deg, #667eea 0%, #8b7fd8 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            background-color: #004080;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #667eea 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 111, 208, 0.4);
            background-color: #0059b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .form-control {
            background-color: #f8f9fa;
            background-color: #e9ecef;
            color: #000;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        .form-control:focus {
            border-color: #7c6fd0;
            box-shadow: 0 0 0 0.2rem rgba(124, 111, 208, 0.25);
        }

        .form-label {
            color: #333;
            font-weight: 500;
            border-color: #004080;
            box-shadow: 0 0 0 0.2rem rgba(0,64,128,0.25);
        }
    </style>
</head>
</div>
<div class="container mt-4">
    @yield('content')
</div>

@yield('scripts')
</body>
</html>
