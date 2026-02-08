<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Administrativo')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a2e0c8b2b1.js" crossorigin="anonymous"></script>

    <style>

        html { height: 100%; overflow-y: scroll; }
        body {
            margin: 0; font-family: "Segoe UI", Roboto, sans-serif;
            background-color: #f5f7fa; height: 100%;
        }
        main { display: flex; min-height: 100vh; overflow: hidden; }

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
        .sidebar::-webkit-scrollbar { width: 8px; }
        .sidebar::-webkit-scrollbar-thumb { background-color: #5cb3ff; border-radius: 4px; }

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

        .brand-logo { text-align: center; margin-bottom: 0.5rem; padding: 0.5rem; }
        .brand-logo h2 { font-size: 1.8rem; font-weight: 800; color: #fff; }

        .user-info { text-align: center; margin-bottom: 2rem; }
        .user-info h3 { font-size: 1.1rem; color: #ffffff; }

        /* NAV */
        .btn-toggle {
            display: flex; align-items: center; justify-content: space-between;
            width: 100%; padding: 0.7rem 1rem; font-weight: 600;
            color: #cfd8e3; background-color: transparent;
            border: none; border-left: 4px solid transparent;
            border-radius: 0.4rem; transition: all 0.25s ease;
        }
        .btn-toggle i { margin-right: 0.7rem; color: #5cb3ff; }

        .btn-toggle-nav a {
            display: block; padding: 0.45rem 0 0.45rem 2.8rem;
            font-size: 0.9rem; color: #9ca3af; text-decoration: none;
        }
        .btn-toggle-nav a:hover { color: #fff; }
        .btn-toggle-nav a.active { color: #00b7ff; font-weight: 600; }

        .content-area {
            flex-grow: 1; margin-left: 260px;
            background-color: #f5f7fa; padding: 28px;
            min-height: 100vh; transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
            overflow: visible;
        }
        .content-area.expanded { margin-left: 80px; }

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
        <button class="toggle-sidebar-btn" id="toggleSidebar">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="brand-logo">
            <h2>
                <img src="{{ asset('Imagenes/bustrak-logo.jpg') }}"
                     alt="Logo"
                     style="width: 90px; height: auto; border-radius: 0; display: block; margin: 0 auto;">
            </h2>
        </div>

        <div class="user-info">
            <h3>Admin</h3>
        </div>

        <!-- Estadísticas -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse"
                    data-bs-target="#estadisticas"
                    aria-expanded="{{ request()->routeIs('admin.estadisticas') ? 'true' : 'false' }}">
                <span><i class="fas fa-chart-bar"></i> Estadísticas</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('admin.estadisticas') ? 'show' : '' }}"
                 id="estadisticas">
                <a href="{{ route('admin.estadisticas') }}"
                   class="{{ request()->routeIs('admin.estadisticas') ? 'active' : '' }}">
                    Ver Estadísticas
                </a>
            </div>
        </div>



        <!-- Empleados -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#empleados"
                    aria-expanded="{{ request()->routeIs('empleados.*') ? 'true' : 'false' }}">
                <span><i class="fas fa-user-tie"></i> Empleados</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>

            <div class="collapse btn-toggle-nav {{ request()->routeIs('empleados.*') ? 'show' : '' }}" id="empleados">
                <a href="{{ route('empleados.hu5') }}" class="{{ request()->routeIs('empleados.hu5') ? 'active' : '' }}">
                    Ver empleados
                </a>
                <a href="{{ route('empleados.create') }}" class="{{ request()->routeIs('empleados.create') ? 'active' : '' }}">
                    Registrar empleado
                </a>
                <a href="{{ route('abordajes.historial') }}" class="{{ request()->routeIs('abordajes.historial') ? 'active' : '' }}">
                    Check-in
                </a>
            </div>
        </div>
        <!-- Documentacion de buses -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#documentacionBuses">
                <span><i class="fas fa-file-contract"></i> Documentación de Buses</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>

            <div class="collapse btn-toggle-nav" id="documentacionBuses">
                <a href="{{ route('documentos-buses.index') }}" class="{{ request()->routeIs('documentos-buses.index') ? 'active' : '' }}">
                    Gestionar Documentacion
                </a>
            </div>
        </div>
        <!-- Rentas -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#Renta">
                <span><i class="fas fa-map-marker-alt"></i> Registro Renta</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="Renta">
                <a href="{{ route('rentas.index') }}" class="{{ request()->routeIs('rentas.index') ? 'active' : '' }}">
                    Ver Registro
                </a>
                <a href="{{ route('rentas.create') }}" class="{{ request()->routeIs('rentas.create') ? 'active' : '' }}">
                    Agregar Renta
                </a>
            </div>
        </div>

        <!-- Terminales -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#terminales">
                <span><i class="fas fa-map-marker-alt"></i> Terminales</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="terminales">
                <a href="{{ route('terminales.index') }}" class="{{ request()->routeIs('terminales.index') ? 'active' : '' }}">
                    Ver terminales
                </a>
                <a href="{{ route('terminales.create') }}" class="{{ request()->routeIs('terminales.create') ? 'active' : '' }}">
                    Agregar terminal
                </a>
                <a href="{{ route('servicios.create') }}" class="{{ request()->routeIs('servicios.create') ? 'active' : '' }}">
                    Agregar servicios disponibles
                </a>
            </div>
        </div>



        <!-- Usuarios (PARTE DE MAIN) -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#usuarios">
                <span><i class="fas fa-users"></i> Usuarios</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="usuarios">
                <a href="{{ route('usuarios.consultar') }}"
                   class="{{ request()->routeIs('usuarios.consultar') ? 'active' : '' }}">
                    Consultar usuarios
                </a>
            </div>
        </div>

        <!-- Solicitudes (PARTE DE MAIN) -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#solicitud"
                    aria-expanded="{{ request()->routeIs('solicitudes.*') ? 'true' : 'false' }}">
                <span><i class="fas fa-file-alt"></i> Solicitud</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('solicitudes.*') ? 'show' : '' }}" id="solicitud">
                <a href="{{ route('solicitudes.index') }}"
                   class="{{ request()->routeIs('solicitudes.index') ? 'active' : '' }}">
                    Constancias de Trabajo
                </a>
            </div>
        </div>

        <!-- Cerrar sesión -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#sesion">
                <span><i class="fas fa-sign-out-alt"></i> Cuenta</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="sesion">
                <a href="{{ route('admin.change-password') }}">Cambiar Contraseña</a>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar sesión
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </nav>

    <div class="content-area">
        <div class="d-flex justify-content-end align-items-center gap-2 mb-4 p-3 rounded shadow-sm"
             style="background-color: #0d1f3f; border-left: 5px solid #0dcaf0;">

            <a href="{{ route('interfaces.principal') }}"
               class="btn btn-outline-light btn-sm px-3 rounded-pill shadow-sm">
                <i class="fas fa-home me-1"></i> Inicio
            </a>
            <a href="{{ route('admin.home.editor') }}"
               class="btn btn-warning btn-sm px-3 rounded-pill shadow-sm">
                <i class="fas fa-edit me-1"></i> Editar Página Principal
            </a>


            @php
                $adminNotiCount = \App\Models\Notificacion::where('usuario_id', auth()->id())
                    ->where('leida', false)
                    ->count();
            @endphp

            <a href="{{ route('admin.notificaciones') }}"
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

        @yield('content')
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Mantener grupos abiertos
    document.addEventListener('DOMContentLoaded', function () {
        let openGroups = JSON.parse(localStorage.getItem('sidebarOpenGroups') || '[]');

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
                    localStorage.setItem('sidebarOpenGroups', JSON.stringify(openGroups));
                }
            });

            group.addEventListener('hidden.bs.collapse', () => {
                openGroups = openGroups.filter(id => id !== group.id);
                localStorage.setItem('sidebarOpenGroups', JSON.stringify(openGroups));
            });
        });
    });
</script>

<script>
    // Toggle sidebar
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
