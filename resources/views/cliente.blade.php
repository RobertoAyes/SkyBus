<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transportes Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .seat {
            width: 45px;
            height: 45px;
            background: #fff;
            border: 2px solid #999;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        /* seleccionado */
        .seat.selected {
            background: #FF5722;
            color: #fff;
            border-color: #FF5722;
            transform: scale(1.05);
        }

        /* ocupado */
        .seat.disabled {
            background: #bdbdbd;
            color: #fff;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* hover */
        .seat:not(.disabled):hover {
            border-color: #FF5722;
        }
        /* =========================
           BASE / BODY
        ========================= */
        body {
            font-family: "Segoe UI", Roboto, sans-serif;
            background: url('https://media.istockphoto.com/id/1457298168/es/foto/hombre-abordando-autob%C3%BAs-enfoque-selectivo-en-el-lado-del-parachoques-del-transporte-p%C3%BAblico.jpg?s=612x612&w=0&k=20&c=zl6SrTq50CuHHJ8V8L13EwQP4TNcsXRvKeyvIEtZd1c=') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        /* =========================
           BOOKING CARD
        ========================= */
        .booking-card {
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 30px;
            max-width: 1200px;
            width: 95%;
            margin: 60px auto;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        /* =========================
           BUTTONS
        ========================= */
        .btn-orange {
            background-color: #FF5722;
            color: #fff;
        }

        .btn-orange:hover {
            background-color: #E64A19;
            color: #fff;
        }

        /* =========================
           STEPS (MULTIPASO)
        ========================= */
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        /* =========================
           NAVBAR
        ========================= */
        .navbar {
            background-color: rgba(16,24,39,0.9);
        }

        .navbar-brand img {
            height: 60px;
        }

        /* NAVBAR CUSTOM (DASHBOARD STYLE) */
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

        /* =========================
           BUS LAYOUT
        ========================= */
        .bus-container {
            margin: 20px auto;
            width: fit-content;
            background: #f2f2f2;
            border-radius: 60px 60px 30px 30px;
            padding: 30px 20px 20px 20px;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.2);
            position: relative;
        }

        .bus-cabin {
            width: 100%;
            height: 50px;
            background: #dcdcdc;
            border-radius: 40px 40px 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        .bus-cabin i {
            font-size: 22px;
            color: #555;
        }

        /* =========================
           ASIENTOS
        ========================= */
        .seat-row {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .seat {
            width: 45px;
            height: 45px;
            background: #fff;
            border: 2px solid #999;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        /* seleccionado */
        .seat.selected {
            background: #28a745;
            color: #fff;
            border-color: #1e7e34;
        }

        /* ocupado */
        .seat.disabled {
            background: #c0c0c0;
            color: #666;
            border-color: #999;
            cursor: not-allowed;
        }

        /* hover */
        .seat:not(.disabled):hover {
            transform: scale(1.05);
        }

        .aisle {
            width: 20px;
        }

        @media(max-width:768px){
            .seat {
                width: 40px;
                height: 40px;
                font-size: 14px;
            }

            .aisle {
                width: 20px;
            }
        }

        /* =========================
           TRAVEL SECTION
        ========================= */
        .travel-section {
            background: linear-gradient(135deg, #e3f2fd, #f8fbff);
        }

        .travel-card {
            background: #ffffff;
            border-radius: 150px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .travel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: #e3f2fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        /* =========================
           BENEFITS
        ========================= */
        .benefits-section {
            background: #f8f9fa;
        }

        .info-card {
            background: white;
            border-radius: 150px;
            padding: 25px 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .info-card i {
            color: #1976d2;
        }

        /* =========================
           SCROLL TOP BUTTON
        ========================= */
        #btnScrollTop {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ff6a00, #ff3d00);
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            z-index: 999;
            transition: all 0.3s ease;
        }

        #btnScrollTop:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.35);
        }

        /* =========================
           SERVICE CARD
        ========================= */
        .service-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* =========================
           BADGE NOTIFY
        ========================= */
        .badge-notify {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 0.6rem;
        }

        /* =========================
           LAYOUT SPACING
        ========================= */
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
            <img src="{{ asset('Imagenes/bustrak-logo.png') }}" alt="Logo" style="width: 90px; height:auto; margin-right:10px;">
        </a>

        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            @guest
                <!-- Si NO está logueado -->
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-login">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-success btn-registro">Regístrate</a>
                </div>
            @endguest

            @auth
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

                    <!-- Mis Reservas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('cliente.reserva.create') || request()->routeIs('cliente.historial') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ticket-alt me-1"></i> Mis Reservas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('cliente.reserva.create') ? 'active' : '' }}" href="{{ route('cliente.reserva.create') }}">Nueva Reserva</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('cliente.historial') ? 'active' : '' }}" href="{{ route('cliente.historial') }}">Historial de Viajes</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('itinerario.index') ? 'active' : '' }}" href="{{ route('itinerario.index') }}">Itinerario</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('cliente.facturas*') ? 'active' : '' }}" href="{{ route('cliente.facturas') }}">Facturas</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('puntos.index') ? 'active' : '' }}" href="{{ route('puntos.index') }}">Ver Puntos</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('calificaciones.form') ? 'active' : '' }}" href="{{ route('calificaciones.form') }}">Calificar Conductor</a></li>
                        </ul>
                    </li>

                    <!-- Servicios Adicionales -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('servicios_reserva.*') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-star me-1"></i> Servicios Adicionales
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('servicios_reserva.index') ? 'active' : '' }}"
                                   href="{{ route('servicios_reserva.index') }}">Historial</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('servicios_reserva.create') ? 'active' : '' }}"
                                   href="{{ route('servicios_reserva.create') }}">Agregar servicio</a>
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
                            <li><a class="dropdown-item {{ request()->routeIs('consulta.mis') ? 'active' : '' }}" href="{{ route('consulta.mis') }}">Mis consultas</a></li>
                            <li><a class="dropdown-item" href="{{ route('usuario.change-password') }}">Cambiar contraseña</a></li>
                            <li><a class="dropdown-item" href="{{ route('solicitud.empleo.mis-solicitudes') }}">Solicitud de trabajo</a></li>
                        </ul>
                    </li>

                </ul>

                <!-- Hola Usuario, Inicio y Notificaciones -->
                <ul class="navbar-nav ms-auto align-items-center">
                <span class="text-white me-3 d-flex align-items-center">
                 <i class="fas fa-user me-1"></i> Hola {{ auth()->user()->name }}
                    </span>

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

            @endauth

        </div>
    </div>
</nav>



<div class="booking-card">
    <h2 class="text-center mb-4 fw-bold">¡Tu destino catracho online!</h2>

    <div id="errorBox" class="alert alert-danger d-none"></div>

    <!-- PASO 1 -->
    <div id="step1" class="step active">
        <form id="buscarForm">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">De</label>
                    <select id="origenSelect" class="form-select" required>
                        <option value="">Seleccione</option>
                        @isset($rutas)
                            @foreach($rutas->pluck('origen')->unique() as $origen)
                                <option value="{{ $origen }}">{{ $origen }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">A</label>
                    <select id="destinoSelect" class="form-select" required>
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Fecha del Viaje</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-orange btn-lg">Buscar</button>
            </div>
        </form>
    </div>

    <!-- PASO 2 -->
    <div id="step2" class="step">
        <h4 class="mb-3">Viajes Disponibles</h4>
        <div class="list-group" id="viajesBox"></div>
        <div class="text-center mt-3">
            <button class="btn btn-secondary" onclick="showStep(1)">Volver</button>
        </div>
    </div>

    <!-- PASO 3 -->
    <div id="step3" class="step">
        <h4 class="mb-3">
            Seleccione sus Asientos (máx. 5)
            <small id="counter" class="text-muted ms-2">(0/5)</small>
        </h4>

        <div class="bus-container">
            <div class="bus-cabin">
                <i class="fas fa-steering-wheel"></i>
            </div>

            @for($i=1;$i<=8;$i++)
                <div class="seat-row">
                    <div class="seat" data-seat="{{ $i }}A">{{ $i }}A</div>
                    <div class="seat" data-seat="{{ $i }}B">{{ $i }}B</div>
                    <div class="aisle"></div>
                    <div class="seat" data-seat="{{ $i }}C">{{ $i }}C</div>
                    <div class="seat" data-seat="{{ $i }}D">{{ $i }}D</div>
                </div>
            @endfor
        </div>

        <div class="text-center mt-4">
            <button id="confirmarBtn" class="btn btn-orange" disabled>
                Confirmar Reserva
            </button>
            <button class="btn btn-secondary" onclick="showStep(2)">
                Volver
            </button>
        </div>
    </div>

    <!-- PASO 4 -->
    <div id="step4" class="step">
        <div class="card shadow border-0 mx-auto" style="max-width:600px;">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0">¡Reserva Confirmada!</h4>
            </div>

            <div class="card-body p-4 text-center">
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <small>Código</small>
                        <h5 id="codigoReservaStep4">---</h5>
                    </div>

                    <div class="col-12">
                        <small>Asientos</small>
                        <div id="asientoStep4">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const IS_AUTH = @json(auth()->check());

    document.addEventListener('DOMContentLoaded', () => {

        const rutas = @json($rutas ?? []);

        let viajeSeleccionado = null;
        let asientosSeleccionados = [];
        const MAX = 5;

        const origen = document.getElementById('origenSelect');
        const destino = document.getElementById('destinoSelect');
        const form = document.getElementById('buscarForm');
        const viajesBox = document.getElementById('viajesBox');
        const btn = document.getElementById('confirmarBtn');
        const counter = document.getElementById('counter');
        const errorBox = document.getElementById('errorBox');

        const showError = (msg) => {
            errorBox.textContent = msg;
            errorBox.classList.remove('d-none');
        };

        const clearError = () => {
            errorBox.textContent = '';
            errorBox.classList.add('d-none');
        };

        const updateCounter = () => {
            if (counter) {
                counter.textContent = `(${asientosSeleccionados.length}/${MAX})`;
            }
        };

        window.showStep = (n) => {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
            const step = document.getElementById('step' + n);
            if (step) step.classList.add('active');
        };

        // ORIGEN → DESTINO
        origen.addEventListener('change', () => {
            destino.innerHTML = '<option value="">Seleccione</option>';

            rutas
                .filter(r => r.origen === origen.value)
                .forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.destino;
                    opt.textContent = r.destino;
                    opt.dataset.id = r.id;
                    destino.appendChild(opt);
                });
        });

        // BUSCAR VIAJES
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearError();

            const opt = destino.options[destino.selectedIndex];
            const ruta_id = opt?.dataset?.id || null;
            const fecha = form.querySelector('input[name="fecha"]').value;

            if (!ruta_id) return showError('Selecciona una ruta válida');
            if (!fecha) return showError('Selecciona una fecha');

            try {
                const res = await fetch("{{ route('cliente.reserva.buscar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ruta_id: Number(ruta_id), fecha })
                });

                const data = await res.json();

                viajesBox.innerHTML = '';

                if (!res.ok) {
                    return showError(data.message || data.error || 'Error en búsqueda');
                }

                if (!data.length) {
                    viajesBox.innerHTML = `<div class="text-center text-muted">No hay viajes disponibles</div>`;
                    return showStep(2);
                }

                data.forEach(v => {
                    viajesBox.innerHTML += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <b>${v.ruta.origen} → ${v.ruta.destino}</b><br>
                            <small>${v.fecha_hora_salida}</small>
                        </div>
                        <button class="btn btn-primary" onclick="cargarAsientos(${v.id})">
                            Seleccionar
                        </button>
                    </div>
                `;
                });

                showStep(2);

            } catch (e) {
                console.error(e);
                showError('Error de conexión al buscar viajes');
            }
        });

        // CARGAR ASIENTOS
        window.cargarAsientos = async (id) => {

            viajeSeleccionado = id;
            asientosSeleccionados = [];
            updateCounter();

            if (btn) btn.disabled = true;

            try {
                const res = await fetch(`{{ url('cliente/reserva') }}/${id}/asientos`);
                const data = await res.json();

                document.querySelectorAll('.seat').forEach(s => {
                    s.classList.remove('selected', 'disabled');
                    s.onclick = null;
                });

                data.asientos.forEach(a => {
                    const seat = document.querySelector(`[data-seat="${a.numero}"]`);
                    if (!seat) return;

                    if (a.ocupado) {
                        seat.classList.add('disabled');
                        return;
                    }

                    seat.onclick = () => {

                        const num = seat.dataset.seat;

                        if (asientosSeleccionados.includes(num)) {
                            asientosSeleccionados = asientosSeleccionados.filter(x => x !== num);
                            seat.classList.remove('selected');
                        } else {

                            if (asientosSeleccionados.length >= MAX) {
                                return showError('Máximo 5 asientos');
                            }

                            asientosSeleccionados.push(num);
                            seat.classList.add('selected');
                            clearError();
                        }

                        updateCounter();
                        if (btn) btn.disabled = asientosSeleccionados.length === 0;
                    };
                });

                showStep(3);

            } catch (e) {
                console.error(e);
                showError('Error al cargar asientos');
            }
        };

        // CONFIRMAR RESERVA
        if (btn) {
            btn.addEventListener('click', async () => {

                clearError();

                if (!IS_AUTH) {
                    showError("Debes iniciar sesión para continuar");
                    setTimeout(() => window.location.href = "{{ route('login') }}", 1000);
                    return;
                }

                if (!viajeSeleccionado || asientosSeleccionados.length === 0) {
                    return showError("Selecciona viaje y asientos");
                }

                try {
                    const res = await fetch("{{ route('cliente.reserva.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            viaje_id: viajeSeleccionado,
                            asientos: asientosSeleccionados
                        })
                    });

                    const data = await res.json();

                    if (!res.ok || data.error) {
                        return showError(data.error || 'Error en reserva');
                    }

                    document.getElementById('codigoReservaStep4').textContent = data.codigo_reserva;
                    document.getElementById('asientoStep4').textContent = asientosSeleccionados.join(', ');

                    showStep(4);

                } catch (e) {
                    console.error(e);
                    showError('Error al confirmar reserva');
                }
            });
        }

    });
</script>


<!-- Sección de Servicios -->
<section class="services-section py-5">
    <div class="container">

        <!-- Servicios Usuario -->
        <div class="service-card row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="fw-bold text-primary">Servicios para el usuario</h2>
                <p>
                    Ofrecemos atención personalizada, compras en línea y asistencia 24/7 para que tu experiencia sea segura y confiable.                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://transportesonline.hn/wp-content/uploads/2020/12/GettyImages-1209969988-2048x1365.jpg"
                     alt="Servicios Usuario"
                     class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- Servicios dentro del bus -->
        <div class="service-card row align-items-center mb-5">
            <div class="col-md-6 order-md-2">
                <h2 class="fw-bold text-primary">Servicios dentro del bus</h2>
                <p>
                    Disfruta de asientos cómodos, Wi-Fi gratuito, aire acondicionado y entretenimiento durante todo tu viaje.                </p>
            </div>
            <div class="col-md-6 order-md-1 text-center">
                <img src="https://www.todoturismosrl.com/images/buses/bus_salar_cama7.jpg"
                     alt="Servicios dentro del bus"
                     class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- Nuestra Flota -->
        <div class="service-card row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="fw-bold text-primary">Nuestra Flota</h2>
                <p>
                    Nuestra flota cuenta con buses modernos y seguros, con mantenimiento regular y personal altamente capacitado.                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://bogota.gov.co/sites/default/files/styles/1050px/public/2024-06/busesbogota-1-2.png"
                     alt="Nuestra Flota"
                     class="img-fluid rounded shadow">
            </div>
        </div>

    </div>

</section>

<section class="benefits-section mt-5 p-5 rounded-4 text-center">
    <h2 class="fw-bold mb-4">Beneficios en algunos de nuestros buses</h2>

    <p class="text-muted mb-5 fs-6">
        En <strong>SkyBus</strong> su seguridad y comodidad es nuestra prioridad.
        Disfrute de un viaje confortable y seguro con nuestros servicios exclusivos.
    </p>

    <div class="row g-4 justify-content-center">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="info-card">
                <i class="fas fa-wifi fa-2x mb-3"></i>
                <h6>WIFI a bordo</h6>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <div class="info-card">
                <i class="fas fa-snowflake fa-2x mb-3"></i>
                <h6>Aire acondicionado</h6>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <div class="info-card">
                <i class="fas fa-suitcase fa-2x mb-3"></i>
                <h6>Kit de viaje</h6>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <div class="info-card">
                <i class="fas fa-bolt fa-2x mb-3"></i>
                <h6>Conexión USB</h6>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <div class="info-card">
                <i class="fas fa-map-marker-alt fa-2x mb-3"></i>
                <h6>GPS</h6>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <div class="info-card">
                <i class="fas fa-video fa-2x mb-3"></i>
                <h6>Videovigilancia</h6>
            </div>
        </div>
    </div>
</section>
<section class="travel-section mt-5 p-5 rounded-4 text-center">
    <h2 class="fw-bold mb-3">Prepare su viaje</h2>
    <p class="text-muted mb-5">
        Recomendaciones para hacer de su viaje una experiencia inolvidable.
    </p>

    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="travel-card">
                <div class="icon-circle">
                    <img src="https://www.ticabus.com/documents/7092829/7093204/ico_planea.svg/227152e1-824b-3052-c301-3ee496d1ef9f?t=1732002538128"
                         alt="Planee su viaje" style="max-height:35px;">
                </div>
                <h6 class="fw-bold">Planee su viaje</h6>
                <p class="text-muted">
                    Elija su destino, fecha de viaje, horario y punto de abordaje.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="travel-card">
                <div class="icon-circle">
                    <img src="https://www.ticabus.com/documents/7092829/7093204/ico_compra.svg/537e738f-b33c-4091-7cfa-1053d9b4fa2c?t=1732002538017"
                         alt="Compre su boleto" style="max-height:35px;">
                </div>
                <h6 class="fw-bold">Compre su boleto</h6>
                <p class="text-muted">
                    Adquiera sus boletos en línea de forma rápida y segura.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="travel-card">
                <div class="icon-circle">
                    <img src="https://www.ticabus.com/documents/7092829/7093204/ico_aborda.svg/101af751-58dc-674b-ee0e-00bd950ce590?t=1732002537917"
                         alt="Aborde a tiempo" style="max-height:35px;">
                </div>
                <h6 class="fw-bold">Aborde a tiempo</h6>
                <p class="text-muted">
                    Preséntese una hora antes para el chequeo de equipaje.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="travel-card">
                <div class="icon-circle">
                    <img src="https://www.ticabus.com/documents/7092829/7093204/ico_equipaje.svg/7096cfbe-1126-f415-2858-a8dfab33ce35?t=1732002537690"
                         alt="Equipaje" style="max-height:35px;">
                </div>
                <h6 class="fw-bold">Equipaje</h6>
                <p class="text-muted">
                    Dos maletas de 15 kg y un bolso de mano por pasajero.
                </p>
            </div>
        </div>
    </div>

    <div class="mt-5 p-4 bg-white rounded-4 shadow-sm">
        <small class="text-muted">
            *La empresa no se hace responsable por pérdida o daños de objetos de valor,
            equipos electrónicos o frágiles. La responsabilidad recae en el pasajero.
        </small>
    </div>
</section>
<button id="btnScrollTop" aria-label="Volver arriba">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
    const btnScrollTop = document.getElementById('btnScrollTop');

    // Mostrar u ocultar el botón al hacer scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            btnScrollTop.style.display = 'flex';
        } else {
            btnScrollTop.style.display = 'none';
        }
    });

    // Ir arriba suavemente al hacer click
    btnScrollTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
</body>
</html>
