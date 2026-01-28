<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Administrativo')</title>
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
            width: 260px;
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
            scrollbar-width: thin;
            scrollbar-color: #5cb3ff #101827;
        }

        .sidebar::-webkit-scrollbar {
            width: 8px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #5cb3ff;
            border-radius: 4px;
        }

        .user-info {
            text-align: center;
            margin-bottom: 2rem;
        }

        .user-info h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
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
        }
        /* ===== Toggle Sidebar ===== */
        .sidebar.collapsed {
            width: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .content-area.expanded {
            margin-left: 0;
            width: 100%;
            transition: all 0.3s ease;
        }

        #toggleSidebar {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

    </style>

</head>

<body>
<main>
    <nav class="sidebar">
        <div class="user-info">
            <h3>Admin</h3>
        </div>

        <!-- Empleados -->
        <div class="nav-section">
            <button class="btn-toggle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse"
                    data-bs-target="#empleados"
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
                <a href="{{ route('abordajes.historial') }}" class="{{ request()->routeIs('empleados.create') ? 'active' : '' }}">
                    Check-in
                </a>
            </div>
        </div>


        <!-- Usuarios -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#usuarios" aria-expanded="false">
                <span><i class="fas fa-users"></i> Usuarios</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="usuarios">
                <a href="{{ route('usuarios.consultar') }}" class="{{ request()->routeIs('usuarios.consultar') ? 'active' : '' }}">Consultar usuarios</a>
            </div>
        </div>

        <!-- Empresa -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#empresa" aria-expanded="false">
                <span><i class="fas fa-building"></i> Empresa</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="empresa">
                <a href="{{ route('empresas.index') }}" class="{{ request()->routeIs('empresas.index') ? 'active' : '' }}">Lista de empresas</a>
                <a href="{{ route('empresas.validar') }}" class="{{ request()->routeIs('empresas.validar') ? 'active' : '' }}">Validar empresas</a>
                <a href="{{ route('empresa.form') }}" class="{{ request()->routeIs('empresa.form') ? 'active' : '' }}">Registrar empresa</a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#estadisticas" aria-expanded="{{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }}">
                <span><i class="fas fa-chart-bar"></i> Estadísticas</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('admin.dashboard') ? 'show' : '' }}" id="estadisticas">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Ver Estadísticas
                </a>
            </div>
        </div>

        <!-- Terminales -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#terminales" aria-expanded="false">
                <span><i class="fas fa-map-marker-alt"></i> Terminales</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="terminales">
                <a href="{{ route('terminales.index') }}" class="{{ request()->routeIs('terminales.index') ? 'active' : '' }}">Ver terminales</a>
                <a href="{{ route('terminales.create') }}" class="{{ request()->routeIs('terminales.create') ? 'active' : '' }}">Agregar terminal</a>
                <a href="{{ route('terminales.ver_terminales') }}" class="{{ request()->routeIs('terminales.ver_terminales') ? 'active' : '' }}">Visualizar terminales</a>
            </div>
        </div>

        <!-- Consultas y Soporte -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#consultas" aria-expanded="{{ request()->routeIs('consulta.listar') ? 'true' : 'false' }}">
                <span><i class="fas fa-headset"></i> Consultas</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('consulta.listar') ? 'show' : '' }}" id="consultas">
                <a href="{{ route('consulta.listar') }}" class="{{ request()->routeIs('consulta.listar') ? 'active' : '' }}">Ver consultas</a>
            </div>
        </div>

        <div class="mt-auto text-center p-3">
            <a href="{{ route('logout') }}" class="btn btn-sm btn-danger">Cerrar sesión</a>
        </div>
    </nav>

    <div class="content-area">
        <!--  Botón para mostrar/ocultar la barra lateral -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button id="toggleSidebar" class="btn btn-outline-primary">
                <i class="fas fa-bars"></i> Menú
            </button>
        </div>

        @yield('content')
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
<!-- 🔹 Script para ocultar/mostrar la barra lateral -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content-area');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');

            // Cambiar ícono dinámicamente
            const icon = toggleBtn.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            } else {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        });
    });
</script>
</body>
</html>
