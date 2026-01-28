<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bustrak - Panel de Usuario')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a2e0c8b2b1.js" crossorigin="anonymous"></script>

    <style>
        html { height: 100%; overflow-y: scroll; }
        body { margin:0; font-family:"Segoe UI", Roboto, sans-serif; background-color:#f5f7fa; height:100%; }
        main { display:flex; min-height:100vh; overflow:hidden; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 230px;
            background-color: #101827;
            color: #fff;
            display:flex; flex-direction:column;
            padding-top:1rem;
            position:fixed; top:0; left:0;
            height:100vh;
            box-shadow:3px 0 8px rgba(0,0,0,0.3);
            overflow-y:auto; overflow-x:hidden;
            scrollbar-width:thin; scrollbar-color:#5cb3ff #101827;
            transition:all 0.3s ease;
        }
        .sidebar::-webkit-scrollbar { width:8px; }
        .sidebar::-webkit-scrollbar-thumb { background-color:#5cb3ff; border-radius:4px; }

        /* Toggle Button */
        .toggle-sidebar-btn {
            position:absolute; top:20px; right:-20px;
            width:40px; height:40px;
            background:#1976d2; border:none; border-radius:50%;
            color:white; display:flex; align-items:center; justify-content:center;
            cursor:pointer; box-shadow:0 4px 12px rgba(0,0,0,0.4); transition:all 0.3s ease; z-index:1000;
            font-size:18px;
        }
        .toggle-sidebar-btn:hover { background:#1565c0; transform:scale(1.15); }
        .toggle-sidebar-btn i { transition:transform 0.3s ease; }

        .brand-logo { text-align:center; margin-bottom:0.5rem; padding:0.5rem; }
        .brand-logo h2 img { border-radius:35px; width:120px; height:60px; }

        .user-info { text-align:center; margin-bottom:2rem; }
        .user-info h3 { font-size:1.1rem; color:#fff; }

        /* NAV */
        .btn-toggle {
            display:flex; align-items:center; justify-content:space-between;
            width:100%; padding:0.7rem 1rem; font-weight:600;
            color:#cfd8e3; background:transparent;
            border:none; border-left:4px solid transparent;
            border-radius:0.4rem; transition:all 0.25s ease;
        }
        .btn-toggle i { margin-right:0.7rem; color:#5cb3ff; }
        .btn-toggle-nav a {
            display:block; padding:0.45rem 0 0.45rem 2.8rem;
            font-size:0.9rem; color:#9ca3af; text-decoration:none;
        }
        .btn-toggle-nav a:hover { color:#fff; }
        .btn-toggle-nav a.active { color:#00b7ff; font-weight:600; }

        .content-area { flex-grow:1; margin-left:260px; padding:28px; min-height:100vh; background-color:#f5f7fa; transition:all 0.3s ease; }

        .sidebar.collapsed { width:80px; overflow:visible; }
        .content-area.expanded { margin-left:80px; }

        .sidebar.collapsed .brand-logo,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .btn-toggle span,
        .sidebar.collapsed .btn-toggle .chevron,
        .sidebar.collapsed .btn-toggle-nav { display:none; }

        .sidebar.collapsed .btn-toggle { justify-content:center; padding:0.7rem; }
        .sidebar.collapsed .btn-toggle i { margin-right:0; font-size:1.2rem; }
        .sidebar.collapsed .toggle-sidebar-btn i { transform:rotate(180deg); }

        html { height: 100%; overflow-y: scroll; }
        body { margin: 0; font-family: "Segoe UI", Roboto, sans-serif; background-color: #f5f7fa; height: 100%; }
        main { display: flex; min-height: 100vh; overflow: hidden; }


        .user-info { text-align: center; margin-bottom: 2rem; }
        .user-avatar {
            width: 70px; height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5cb3ff, #1e63b8);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.8rem;
            font-size: 2rem; color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .user-info h3 { font-size: 1.1rem; font-weight: 600; color: #fff; margin: 0; }
        .user-info small { color: #9ca3af; font-size: 0.85rem; }

        /* ===== NAVEGACIÓN ===== */
        .nav-section { margin-bottom: 1rem; }
        .btn-toggle {
            display: flex; align-items: center; justify-content: space-between;
            width: 100%; padding: 0.7rem 1rem;
            font-weight: 600; font-size: 0.95rem; color: #cfd8e3;
            background-color: transparent; border: none; border-left: 4px solid transparent;
            border-radius: 0.4rem; transition: all 0.25s ease;
        }
        .btn-toggle i { margin-right: 0.7rem; color: #5cb3ff; }
        .btn-toggle:hover, .btn-toggle:focus { color: #fff; border-left: 4px solid #00b7ff; }
        .btn-toggle[aria-expanded="true"] { border-left: 4px solid #00b7ff; }
        .btn-toggle .chevron { transition: transform 0.3s ease; }
        .btn-toggle[aria-expanded="true"] .chevron { transform: rotate(90deg); }
        .btn-toggle-nav a {
            display: block; padding: 0.45rem 0 0.45rem 2.8rem;
            font-size: 0.9rem; color: #9ca3af; text-decoration: none; transition: all 0.25s ease;
        }
        .btn-toggle-nav a:hover { color: #fff; }
        .btn-toggle-nav a.active { color: #00b7ff; font-weight: 600; }

        /* ===== CONTENIDO ===== */
        .content-area { flex-grow: 1; margin-left: 260px; background-color: #f5f7fa; padding: 28px; min-height: 100vh; }

        @media (max-width:768px){
            .sidebar { position: relative; width: 100%; height: auto; }
            .content-area { margin-left: 0; }
        }

    </style>
</head>

<body>
<main>
    <nav class="sidebar">
        <button class="toggle-sidebar-btn" id="toggleSidebar"><i class="fas fa-chevron-left"></i></button>

        <div class="brand-logo">
            <h2>
                <img src="{{ asset('Imagenes/bustrak-logo.png') }}"
                     alt="Logo"
                     style="width: 90px; height: auto; border-radius: 0; display: block; margin: 0 auto;">
            </h2>
        </div>

        <!-- Información del usuario -->
        <div class="user-info">
            <h3>{{ optional(auth()->user())->nombre_completo ?? 'Chofer' }}</h3>
            <small>{{ optional(auth()->user())->email ?? 'usuario@bustrak.com' }}</small>

        </div>

        <!-- Secciones del panel de usuario -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#miCuenta" aria-expanded="{{ request()->routeIs('usuario.perfil*') ? 'true':'false' }}">
                <span><i class="fas fa-user-circle"></i> Cuenta</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav {{ request()->routeIs('usuario.perfil*') ? 'show':'' }}" id="miCuenta">
                <a href="{{ route('empleado.perfil') }}" class="{{ request()->routeIs('empleado.perfil') ? 'active':'' }}">Ver perfil</a>

            </div>
        </div>

        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#viajes" aria-expanded="{{ request()->routeIs('usuario.viajes*') ? 'true':'false' }}">
                <span><i class="fas fa-list"></i> Acciones</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>

            <div class="collapse btn-toggle-nav {{ request()->routeIs('usuario.viajes*') ? 'show':'' }}" id="viajes">
                <a href="{{ route('usuario.viajes') }}" class="{{ request()->routeIs('usuario.viajes') ? 'active':'' }}">Ver lista de viajes</a>
                <a href="{{ route('usuario.pasajeros') }}" class="{{ request()->routeIs('usuario.pasajeros') ? 'active':'' }}">Pasajeros y reservas</a>
                <a href="{{ route('usuario.confirmar') }}" class="{{ request()->routeIs('usuario.confirmar') ? 'active':'' }}">Confirmar salida/llegada</a>
            </div>
        </div>

        <!-- Cerrar sesión -->
        <div class="nav-section">
            <button class="btn-toggle" data-bs-toggle="collapse" data-bs-target="#soporte" aria-expanded="false">
                <span><i class="fas fa-headset"></i> Cerrar sesion</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
            <div class="collapse btn-toggle-nav" id="soporte">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>

    </nav>

    <div class="content-area">

        @yield('contenido')
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle sidebar
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content-area');
    const toggleBtn = document.getElementById('toggleSidebar');
    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('expanded');
    });

    // Mantener colapsos abiertos
    document.addEventListener('DOMContentLoaded', function () {
        let openGroups = JSON.parse(localStorage.getItem('sidebarOpenGroups') || '[]');
        openGroups.forEach(id => {
            const el = document.querySelector(`#${id}`);
            if(el){ el.classList.add('show'); const btn = el.previousElementSibling; if(btn) btn.setAttribute('aria-expanded','true'); }
        });
        document.querySelectorAll('.collapse').forEach(group => {
            group.addEventListener('shown.bs.collapse', ()=>{ if(!openGroups.includes(group.id)){ openGroups.push(group.id); localStorage.setItem('sidebarOpenGroups', JSON.stringify(openGroups)); } });
            group.addEventListener('hidden.bs.collapse', ()=>{ openGroups = openGroups.filter(id=>id!==group.id); localStorage.setItem('sidebarOpenGroups', JSON.stringify(openGroups)); });
        });
    });
</script>
</body>
</html>
