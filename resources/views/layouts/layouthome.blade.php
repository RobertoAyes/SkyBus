<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transportes Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Scroll top button */
        #btnScrollTop {
            position: fixed; bottom: 25px; right: 25px; width: 52px; height: 52px;
            background: linear-gradient(135deg, #ff6a00, #ff3d00); color: #fff; border: none; border-radius: 50%;
            cursor: pointer; display: none; align-items: center; justify-content: center; font-size: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25); transition: all 0.3s ease; z-index: 999;
        }
        #btnScrollTop:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(0,0,0,0.35); }

        body { font-family: 'Poppins', sans-serif; background: #f5f7fa; min-height: 100vh; }

        .navbar-custom { background-color: #101827; }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .dropdown-toggle { color: #fff; }
        .navbar-custom .nav-link.active { color: #00b7ff; font-weight: 600; }
        .navbar-custom .dropdown-menu { background-color: #101827; border: none; }
        .navbar-custom .dropdown-item { color: #cfd8e3; }
        .navbar-custom .dropdown-item.active,
        .navbar-custom .dropdown-item:hover { background-color: #0d1f3f; color: #00b7ff; }

        .badge-notify { position: absolute; top:5px; right:5px; font-size:0.6rem; }
        main { padding: 20px; }
    </style>
</head>
<body>

{{-- NAVBAR GENERAL SEGÚN ROL --}}
<nav class="navbar navbar-expand-lg navbar-custom shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('interfaces.principal') }}">
            <img src="{{ asset('Imagenes/bustrak-logo.png') }}" alt="Logo" style="width: 90px; height:auto; margin-right:10px;">
        </a>

        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            {{-- USUARIO NO LOGUEADO --}}
            @guest
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-success">Regístrate</a>
                </div>
            @endguest

            {{-- USUARIO LOGUEADO --}}
            @auth
                @if(auth()->user()->rol === 'cliente')
                    {{-- NAVBAR CLIENTE --}}
                    @include('layouts.layoutuser') {{-- O todo tu navbar de cliente aquí --}}
                @elseif(auth()->user()->rol === 'administrador')
                    {{-- NAVBAR ADMIN --}}
                    @include('layouts.layoutadmin')
                @endif
            @endauth

        </div>
    </div>
</nav>

{{-- CONTENIDO PRINCIPAL --}}
<main class="container-fluid mt-4">
    @yield('conte')
</main>

{{-- LOGOUT FORM --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script>
    // Scroll top button
    const btnScrollTop = document.createElement('button');
    btnScrollTop.id = 'btnScrollTop';
    btnScrollTop.innerHTML = '<i class="fas fa-chevron-up"></i>';
    document.body.appendChild(btnScrollTop);
    btnScrollTop.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));
    window.addEventListener('scroll', () => {
        btnScrollTop.style.display = window.scrollY > 300 ? 'flex' : 'none';
    });
</script>

</body>
</html>
