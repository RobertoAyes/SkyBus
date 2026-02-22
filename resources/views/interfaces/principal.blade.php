<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transportes Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; background: url('https://media.istockphoto.com/id/1457298168/es/foto/hombre-abordando-autob%C3%BAs-enfoque-selectivo-en-el-lado-del-parachoques-del-transporte-p%C3%BAblico.jpg?s=612x612&w=0&k=20&c=zl6SrTq50CuHHJ8V8L13EwQP4TNcsXRvKeyvIEtZd1c=') no-repeat center center fixed; background-size: cover; min-height: 100vh; }
        .booking-card { background: rgba(255,255,255,0.95); border-radius: 12px; padding: 30px; max-width: 1200px; width: 95%; margin: 60px auto; box-shadow: 0 6px 20px rgba(0,0,0,0.3); }
        .btn-orange { background-color: #FF5722; color: #fff; }
        .btn-orange:hover { background-color: #E64A19; color: #fff; }
        .step { display: none; }
        .step.active { display: block; }
        .navbar { background-color: rgba(16,24,39,0.9); }
        .navbar-brand img { height: 60px; }
        .bus-container { position: relative; margin: 20px auto; width: 100%; max-width: 250px; height: 600px; background: #f2f2f2; border-radius: 40px; padding: 20px 10px; box-shadow: inset 0 0 20px rgba(0,0,0,0.2); }
        .bus-cabin { width: 100%; height: 40px; background: #dcdcdc; border-radius: 20px 20px 0 0; display: flex; justify-content: center; align-items: center; margin-bottom: 15px; }
        .bus-cabin i { font-size: 24px; color: #555; }
        .seat-row { display: flex; justify-content: space-between; margin-bottom: 12px; }
        .seat { width: 50px; height: 50px; background: #fff; border: 2px solid #999; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .seat:hover { background: #e0e0e0; }
        .seat.selected { background: #0d6efd; color: #fff; border-color: #0d6efd; }
        .aisle { width: 40px; }
        @media(max-width:768px){ .seat { width: 40px; height: 40px; font-size: 14px; } .aisle { width: 20px; } }

        /* QR grande */
        .barcode svg { width: 350px !important; height: 350px !important; }
        @media (max-width: 576px) {
            .barcode svg { width: 280px !important; height: 280px !important; }
        }
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
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('servicios_adicionales.*') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-star me-1"></i> Servicios Adicionales
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('servicios_adicionales.index') ? 'active' : '' }}" href="{{ route('servicios_adicionales.index') }}">Historial</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('servicios_adicionales.create') ? 'active' : '' }}" href="{{ route('servicios_adicionales.create') }}">Registrar</a></li>
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

    <!-- PASO 1: BUSCADOR -->
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
                <button type="submit" class="btn btn-orange btn-lg"><i class="fas fa-search me-2"></i>Buscar</button>
            </div>
        </form>
    </div>

    <!-- PASO 2: LISTA DE VIAJES -->
    <div id="step2" class="step">
        <h4 class="mb-3">Viajes Disponibles</h4>
        <div class="list-group" id="viajesBox"></div>
        <div class="text-center mt-3">
            <button class="btn btn-secondary" onclick="showStep(1)">Volver</button>
        </div>
    </div>

    <!-- PASO 3: SELECCIÓN DE ASIENTO -->
    <div id="step3" class="step">
        <h4 class="mb-3">Seleccione su Asiento</h4>
        <div class="bus-container">
            <div class="bus-cabin"><i class="fas fa-steering-wheel"></i></div>
            @for($i=1;$i<=7;$i++)
                <div class="seat-row">
                    <div class="seat">{{ $i }}A</div>
                    <div class="seat">{{ $i }}B</div>
                    <div class="aisle"></div>
                    <div class="seat">{{ $i }}C</div>
                    <div class="seat">{{ $i }}D</div>
                </div>
            @endfor
        </div>
        <div class="text-center mt-4">
            <button id="confirmarBtn" class="btn btn-orange" disabled>Confirmar Reserva</button>
            <button class="btn btn-secondary" onclick="showStep(2)">Volver</button>
        </div>
    </div>

    <!-- PASO 4: CONFIRMACIÓN -->
    <div id="step4" class="step">
        <div class="card shadow border-0 mx-auto" style="max-width:600px;">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0"><i class="fas fa-check-circle fa-lg me-2"></i> ¡Reserva Confirmada!</h4>
            </div>
            <div class="card-body p-4 text-center">
                <div class="alert alert-success mb-3 py-2"><strong>¡Listo!</strong> Tu reserva ha sido guardada.</div>
                <div class="alert alert-warning mb-4 py-2"><i class="fas fa-exclamation-triangle me-1"></i><strong>Recuerda:</strong> Llega antes de la hora de salida.</div>

                <div class="row g-3 mb-4 text-center">
                    <div class="col-12"><small class="text-muted d-block">Código de Reserva</small><h5 class="fw-bold text-primary" id="codigoReservaStep4">ABC123</h5></div>
                    <div class="col-6"><small class="text-muted d-block">Origen</small><div class="d-flex align-items-center justify-content-center"><i class="fas fa-map-marker-alt text-primary me-2"></i><span id="origenStep4">-</span></div></div>
                    <div class="col-6"><small class="text-muted d-block">Destino</small><div class="d-flex align-items-center justify-content-center"><i class="fas fa-map-marker-check text-success me-2"></i><span id="destinoStep4">-</span></div></div>
                    <div class="col-6"><small class="text-muted d-block">Salida</small><div class="d-flex align-items-center justify-content-center"><i class="fas fa-clock text-info me-2"></i><span id="fechaStep4">-</span></div></div>
                    <div class="col-6"><small class="text-muted d-block">Asiento</small><div class="d-flex align-items-center justify-content-center"><i class="fas fa-chair text-secondary me-2"></i><span id="asientoStep4">-</span></div></div>
                </div>

                <div class="text-center mb-4">
                    <div class="bg-white p-3 d-inline-block rounded shadow-sm border barcode" id="qrStep4"><svg></svg></div>
                    <p class="text-muted mt-2 mb-0"><small>Escanea en la terminal</small></p>
                </div>

                <div class="d-grid d-md-flex justify-content-center gap-2">
                    <a href="{{ route('cliente.historial') }}" class="btn btn-primary px-4"><i class="fas fa-history me-1"></i> Historial</a>
                    <a href="{{ route('cliente.reserva.create') }}" class="btn btn-outline-success px-4"><i class="fas fa-plus me-1"></i> Nueva</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const rutas = @json($rutas ?? []);

    const origenSelect = document.getElementById('origenSelect');
    const destinoSelect = document.getElementById('destinoSelect');
    const viajesBox = document.getElementById('viajesBox');

    origenSelect.addEventListener('change', function() {
        const origen = this.value;
        destinoSelect.innerHTML = '<option value="">Seleccione</option>';
        rutas.filter(r => r.origen === origen).forEach(r => {
            destinoSelect.innerHTML += `<option value="${r.destino}">${r.destino}</option>`;
        });
    });

    document.getElementById('buscarForm').addEventListener('submit', function(e){
        e.preventDefault();
        const origen = origenSelect.value;
        const destino = destinoSelect.value;
        const fecha = this.fecha.value;

        viajesBox.innerHTML = '';
        rutas.filter(r => r.origen === origen && r.destino === destino)
            .forEach(r => {
                viajesBox.innerHTML += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${r.origen} → ${r.destino}</strong><br>
                            <small>Salida: No Disponible aun</small><br>
                            <small>Asientos Disponibles: 28</small>
                        </div>
                        <button class="btn btn-orange select-asiento">Seleccionar</button>
                    </div>`;
            });

        document.querySelectorAll('.select-asiento').forEach(btn => btn.addEventListener('click', ()=>{
            showStep(3);
        }));

        showStep(2);
    });

    function showStep(step){
        document.querySelectorAll('.step').forEach(el=>el.classList.remove('active'));
        document.getElementById('step'+step).classList.add('active');
    }

    const seats = document.querySelectorAll('.seat');
    const confirmarBtn = document.getElementById('confirmarBtn');
    seats.forEach(seat=>{
        seat.addEventListener('click', function(){
            seat.classList.toggle('selected');
            confirmarBtn.disabled = document.querySelectorAll('.seat.selected').length === 0;
        });
    });

    confirmarBtn.addEventListener('click', function(){
        const seleccionados = Array.from(document.querySelectorAll('.seat.selected'))
            .map(s => s.textContent)
            .join(', ');

        // Llenar Step4 dinámicamente
        document.getElementById('asientoStep4').textContent = seleccionados;
        document.getElementById('origenStep4').textContent = origenSelect.value;
        document.getElementById('destinoStep4').textContent = destinoSelect.value;
        document.getElementById('fechaStep4').textContent = new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString();
        document.getElementById('codigoReservaStep4').textContent = 'ABC123'; // aquí puedes generar un código real

        showStep(4);
    });
</script>
<!-- Sección de Servicios -->
<section class="services-section py-5" style="background-color: #f5f7fa;">
    <div class="container">

        <!-- Servicios Usuario -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="fw-bold text-primary">Servicios para el usuario</h2>
                <p>
Texto y mucho texto luego luego
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://transportesonline.hn/wp-content/uploads/2020/12/GettyImages-1209969988-2048x1365.jpg"
                     alt="Servicios Usuario"
                     class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- Servicios  -->
        <div class="row align-items-center">
            <div class="col-md-6 order-md-2">
                <h2 class="fw-bold text-primary">Servicios dentro del bus</h2>
                <p>
                    Texto y mucho texto luego luego

                </p>
            </div>
            <div class="col-md-6 order-md-1 text-center">
                <img src="https://www.todoturismosrl.com/images/buses/bus_salar_cama7.jpg" alt="Servicios Transportista" class="img-fluid rounded shadow">
            </div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="fw-bold text-primary">Nuestra Flota</h2>
                <p>
                    Texto y mucho texto luego luego
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://bogota.gov.co/sites/default/files/styles/1050px/public/2024-06/busesbogota-1-2.png"
                     alt="Servicios Usuario"
                     class="img-fluid rounded shadow">
            </div>
        </div>

    </div>
</section>
</body>
</html>
