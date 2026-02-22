@php
    use Illuminate\Support\Facades\Auth;
@endphp

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bustrak - Panel de Usuario')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a2e0c8b2b1.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: "Segoe UI", Roboto, sans-serif;
            background-color: #f5f7fa;
        }

        .navbar-custom {
            background-color: #101827;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .dropdown-toggle {
            color: #fff;
        }

        .navbar-custom .nav-link.active {
            color: #00b7ff;
            font-weight: 600;
        }

        .navbar-custom .dropdown-menu {
            background-color: #101827;
            border: none;
        }

        .navbar-custom .dropdown-item {
            color: #cfd8e3;
        }

        .navbar-custom .dropdown-item.active,
        .navbar-custom .dropdown-item:hover {
            background-color: #0d1f3f;
            color: #00b7ff;
        }

        .badge-notify {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 0.6rem;
        }

        main {
            padding: 20px;
        }

        .navbar-nav > li {
            margin-left: 20px;
            margin-right: 20px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-custom shadow-sm sticky-top">
    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center" href="{{ route('interfaces.principal') }}">
            <img src="{{ asset('Imagenes/bustrak-logo.jpg') }}"
                 alt="Logo"
                 style="width: 90px; height:auto; margin-right:10px;">
        </a>

        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Usuario -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i> Cuenta
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('cliente.perfil') }}">Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reservas -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        {{ request()->routeIs('cliente.reserva.create') || request()->routeIs('cliente.historial') ? 'active' : '' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ticket-alt me-1"></i> Mis Reservas
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('cliente.reserva.create') ? 'active' : '' }}"
                               href="{{ route('cliente.reserva.create') }}">Nueva Reserva</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('cliente.historial') ? 'active' : '' }}"
                               href="{{ route('cliente.historial') }}">Historial de Viajes</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('itinerario.index') ? 'active' : '' }}"
                               href="{{ route('itinerario.index') }}">Itinerario</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('cliente.facturas*') ? 'active' : '' }}"
                               href="{{ route('cliente.facturas') }}">Facturas</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('puntos.index') ? 'active' : '' }}"
                               href="{{ route('puntos.index') }}">Ver Puntos</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('calificaciones.form') ? 'active' : '' }}"
                               href="{{ route('calificaciones.form') }}">Calificar Conductor</a>
                        </li>
                    </ul>
                </li>

                <!-- Servicios Adicionales -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('servicios_adicionales.*') ? 'active' : '' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-star me-1"></i> Servicios Adicionales
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('servicios_adicionales.index') ? 'active' : '' }}"
                               href="{{ route('servicios_adicionales.index') }}">Historial</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('servicios_adicionales.create') ? 'active' : '' }}"
                               href="{{ route('servicios_adicionales.create') }}">Registrar</a>
                        </li>
                    </ul>
                </li>

                <!-- Soporte -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('usuario.soporte*') ? 'active' : '' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-headset me-1"></i> Soporte
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/ayuda-soporte">Enviar consulta</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('consulta.mis') ? 'active' : '' }}"
                               href="{{ route('consulta.mis') }}">Mis consultas</a></li>

                        <li><a class="dropdown-item" href="{{ route('solicitud.empleo.mis-solicitudes') }}">Solicitud de trabajo</a></li>


                        <li><a class="dropdown-item" href="{{ route('usuario.change-password') }}">Cambiar contraseña</a></li>

                    </ul>

                </li>


            </ul>

            <!-- Hola Usuario -->
            <span class="text-white me-3 d-flex align-items-center">
                 <i class="fas fa-user me-1"></i> Hola {{ auth()->user()->name }}
                    </span>

            <!-- Inicio y Notificaciones -->
            <ul class="navbar-nav ms-auto align-items-center">



                <!-- Notificaciones -->
                @php
                    $adminNotiCount = \App\Models\Notificacion::where('usuario_id', auth()->id())
                        ->where('leida', false)
                        ->count();
                @endphp
                <li class="nav-item position-relative me-2">
                    <a class="btn btn-outline-light btn-sm rounded-circle position-relative"
                       href="{{ route('usuario.notificaciones') }}"
                       style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-bell"></i>
                        @if($adminNotiCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $adminNotiCount }}
                            </span>
                        @endif
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<main class="container-fluid mt-4">
    @yield('contenido')
</main>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
