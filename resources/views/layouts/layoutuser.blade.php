@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bustrak - Panel de Usuario')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a2e0c8b2b1.js" crossorigin="anonymous"></script>
    <style>
        /* ======== CONFIGURACIÓN GLOBAL ======== */
        html {
            height: 100%;
            overflow-y: scroll;
        }
        body {
            margin: 0;
            font-family: "Segoe UI", Roboto, sans-serif;
            background-color: #f5f7fa;
            height: 100%;
        }
        main {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }
        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 230px;
            background-color: #101827;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding-top: 1rem;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 3px 0 8px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #5cb3ff #101827;
            transition: all 0.3s ease;
        }
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #5cb3ff;
            border-radius: 4px;
        }

        /* ===== BOTÓN TOGGLE INTERNO ===== */
        .toggle-sidebar-btn {
            position: absolute;
            top: 20px;
            right: -20px;
            width: 40px;
            height: 40px;
            background: #1976d2;
            border: none;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
            font-size: 18px;
        }

        .toggle-sidebar-btn:hover {
            background: #1565c0;
            transform: scale(1.15);
        }

        .toggle-sidebar-btn i {
            transition: transform 0.3s ease;
        }

        /* ===== LOGO Y USUARIO ===== */
        .brand-logo {
            text-align: center;
            margin-bottom: 0.5rem;
            padding: 0.5rem;
        }

        .brand-logo h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .brand-logo small {
            display: block;
            color: #5cb3ff;
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .user-info {
            text-align: center;
            margin-bottom: 2rem;
        }

        .user-info h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
        }
        .user-info small {
            color: #9ca3af;
            font-size: 0.85rem;
        }

        /* ===== NAVEGACIÓN ===== */
        .nav-section {
            margin-bottom: 1rem;
        }

        .btn-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.7rem 1rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: #cfd8e3;
            background-color: transparent;
            border: none;
            border-left: 4px solid transparent;
            border-radius: 0.4rem;
            transition: all 0.25s ease;
        }

        .btn-toggle i {
            margin-right: 0.7rem;
            color: #5cb3ff;
        }

        .btn-toggle:hover,
        .btn-toggle:focus {
            color: #fff;
            border-left: 4px solid #00b7ff;
        }

        .btn-toggle[aria-expanded="true"] {
            border-left: 4px solid #00b7ff;
        }

        .btn-toggle .chevron {
            transition: transform 0.3s ease;
        }

        .btn-toggle[aria-expanded="true"] .chevron {
            transform: rotate(90deg);
        }

        .btn-toggle-nav a {
            display: block;
            padding: 0.45rem 0 0.45rem 2.8rem;
            font-size: 0.9rem;
            color: #9ca3af;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-toggle-nav a:hover {
            color: #fff;
        }

        .btn-toggle-nav a.active {
            color: #00b7ff;
            font-weight: 600;
        }

        /* ===== CONTENIDO ===== */
        .content-area {
            flex-grow: 1;
            margin-left: 260px;
            background-color: #f5f7fa;
            padding: 28px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width:768px){
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .content-area {
                margin-left: 0;
            }
            .toggle-sidebar-btn {
                display: none;
            }
        }

        /* ===== Toggle Sidebar ===== */
        .sidebar.collapsed {
            width: 80px;
            overflow: visible;
        }

        .sidebar.collapsed .brand-logo h2,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .btn-toggle span,
        .sidebar.collapsed .btn-toggle .chevron,
        .sidebar.collapsed .btn-toggle-nav {
            display: none;
        }

        .sidebar.collapsed .btn-toggle {
            justify-content: center;
            padding: 0.7rem;
        }

        .sidebar.collapsed .btn-toggle i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .sidebar.collapsed .toggle-sidebar-btn i {
            transform: rotate(180deg);
        }

        .content-area.expanded {
            margin-left: 80px;
        }
    </style>
</head>
<body>
<main>
    <nav class="sidebar">
        <!-- Botón Toggle Interno -->
        <button class="toggle-sidebar-btn" id="toggleSidebar">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- Logo de la Aplicación -->
        <div class="brand-logo">
            <h2>
                <img src="{{ asset('Imagenes/bustrak-logo.jpg') }}"
                     alt="Logo"
                     style="width: 90px; height: auto; border-radius: 0; display: block; margin: 0 auto;">
            </h2>
        </div>

        <!-- Información del Usuario -->
        <div class="user-info" style="text-align: center; margin-top: 10px;">
            <small style="color: #fff;">
                <i class="fas fa-envelope me-1"></i>{{ Auth::user()->email ?? 'usuario@bustrak.com' }}
            </small>
        </div>

        <!-- Mi Cuenta -->
        <div class="nav-section">
            <button class="btn-toggle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse"
                    data-bs-target="#miCuenta"
                    aria-expanded="{{ request()->routeIs('usuario.perfil*') ? 'true' : 'false' }}">
                <span><i class="fas fa-user-circle"></i> Cuenta</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('usuario.perfil*') ? 'show' : '' }}" id="miCuenta">
                <a href="{{ route('cliente.perfil') }}" class="{{ request()->routeIs('cliente.perfil') ? 'active' : '' }}">
                    Ver Perfil
                </a>

                <a href="{{ route('puntos.index') }}" class="{{ request()->routeIs('puntos.index') ? 'active' : '' }}">
                    Ver Puntos
                </a>

            </div>
        </div>

        <!-- Mis Reservas -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#reservas"
                    aria-expanded="{{ request()->routeIs('usuario.reservas*') ? 'true' : 'false' }}">
                <span><i class="fas fa-ticket-alt"></i> Mis Reservas</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>

            <div class="collapse btn-toggle-nav {{ request()->routeIs('cliente.reserva.create') || request()->routeIs('cliente.historial') ? 'show' : '' }}"
                 id="reservas">

                <a href="{{ route('cliente.reserva.create') }}"
                   class="{{ request()->routeIs('cliente.reserva.create') ? 'active' : '' }}">
                    Registrar nueva reserva
                </a>

                <a href="{{ route('cliente.historial') }}"
                   class="{{ request()->routeIs('cliente.historial') ? 'active' : '' }}">
                    Historial de viajes
                </a>
                <a href="{{ route('itinerario.index') }}"
                   class="{{ request()->routeIs('itinerario.index') ? 'active' : '' }}">
                    Itinerario de reservas
                </a>
                <a href="{{ route('cliente.facturas') }}"
                   class="{{ request()->routeIs('cliente.facturas*') ? 'active' : '' }}">
                    Ver Facturas
                </a>
                <a href="{{ route('calificaciones.form') }}" class="{{ request()->routeIs('calificaciones.form') ? 'active' : '' }}">
                    Calificar al Conductor
                </a>
            </div>
        </div>

        <!-- Servicios Adicionales -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#extras"
                    aria-expanded="{{ request()->routeIs('usuario.servicios_adicionales*') ? 'true' : 'false' }}">
                <span><i class="fas fa-star"></i> S. Adicionales</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>

            <div class="collapse btn-toggle-nav {{ request()->routeIs('usuario.servicios_adicionales.index') || request()->routeIs('servicios_adicionales.create') ? 'show' : '' }}"
                 id="extras">

                <a href="{{ route('servicios_adicionales.index') }}"
                   class="{{ request()->routeIs('servicios_adicionales.index') ? 'active' : '' }}">
                    Historial de servicios adicionales
                </a>

                <a href="{{ route('servicios_adicionales.create') }}"
                   class="{{ request()->routeIs('servicios_adicionales.create') ? 'active' : '' }}">
                    Registrar nuevos servicios adicionales
                </a>
            </div>
        </div>


        <!-- Rutas y Horarios -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#rutas" aria-expanded="{{ request()->routeIs('usuario.rutas*') ? 'true' : 'false' }}">
                <span><i class="fas fa-route"></i> Rutas y Horarios</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('usuario.rutas*') ? 'show' : '' }}" id="rutas">
                <a href="{{ route('consulta-paradas.index') }}" class="{{ request()->routeIs('consulta-paradas.index') ? 'active' : '' }}">
                    Consultar Rutas
                </a>
            </div>
        </div>


        <!-- Soporte -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#soporte" aria-expanded="{{ request()->routeIs('usuario.soporte*') ? 'true' : 'false' }}">
                <span><i class="fas fa-headset"></i> Ayuda y Soporte</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('usuario.soporte*') ? 'show' : '' }}" id="soporte">
                <a href="/ayuda-soporte" class="active">Enviar consulta</a>

                <a href="{{ route('consulta.mis') }}" class="active">Mis consultas</a>

                <a href="{{ route('usuario.change-password') }}">
                    Cambiar Contraseña
                </a>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Solicitud -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#solicitud"
                    aria-expanded="{{ request()->routeIs('solicitud.empleo.mis-solicitudes') ? 'true' : 'false' }}">
                <span><i class="fas fa-file-alt"></i> Solicitud de trabajo</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('solicitud.empleo.mis-solicitudes') ? 'show' : '' }}" id="solicitud">
                <a href="{{ route('solicitud.empleo.mis-solicitudes') }}"
                   class="{{ request()->routeIs('solicitud.empleo.mis-solicitudes') ? 'active' : '' }}">
                    Mis Solicitudes
                </a>
            </div>
        </div>

        <!-- Sesión -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#sesion"
                    aria-expanded="false">
                <span><i class="fas fa-sign-out-alt"></i> Sesión</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="sesion">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar sesión
                </a>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>


    </nav>

    <div class="content-area">
        <!-- Barra superior -->
        <div class="d-flex justify-content-end align-items-center gap-2 mb-4 p-3 rounded shadow-sm"
             style="background-color: #0d1f3f; border-left: 5px solid #0dcaf0;">

            <a href="{{ route('interfaces.principal') }}"
               class="btn btn-outline-light btn-sm px-3 rounded-pill shadow-sm">
                <i class="fas fa-home me-1"></i> Inicio
            </a>

            @php
                $adminNotiCount = \App\Models\Notificacion::where('usuario_id', auth()->id())
                    ->where('leida', false)
                    ->count();
            @endphp

            <a href="{{ route('usuario.notificaciones') }}"
               class="btn btn-outline-light btn-sm position-relative rounded-circle shadow-sm"
               style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-bell"></i>

                @if($adminNotiCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $adminNotiCount }}
                        <span class="visually-hidden">notificaciones no leídas</span>
                    </span>
                @endif
            </a>
        </div>
        @yield('contenido')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para mantener grupos abiertos -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let openGroups = JSON.parse(localStorage.getItem('sidebarUserOpenGroups') || '[]');

        openGroups.forEach(id => {
            const el = document.querySelector(`#${id}`);
            if (el) {
                el.classList.add('show');
                const btn = el.previousElementSibling;
                if (btn) btn.setAttribute('aria-expanded', 'true');
            }
        });

        document.querySelectorAll('.collapse').forEach(group => {
            group.addEventListener('shown.bs.collapse', () => {
                if (!openGroups.includes(group.id)) {
                    openGroups.push(group.id);
                    localStorage.setItem('sidebarUserOpenGroups', JSON.stringify(openGroups));
                }
            });
            group.addEventListener('hidden.bs.collapse', () => {
                openGroups = openGroups.filter(id => id !== group.id);
                localStorage.setItem('sidebarUserOpenGroups', JSON.stringify(openGroups));
            });
        });
    });
</script>

<!-- Script para ocultar/mostrar sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content-area');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
        });
    });
</script>
</body>
</html>
