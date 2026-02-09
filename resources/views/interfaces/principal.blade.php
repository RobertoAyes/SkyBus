<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transportes Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://media.istockphoto.com/id/1457298168/es/foto/hombre-abordando-autob%C3%BAs-enfoque-selectivo-en-el-lado-del-parachoques-del-transporte-p%C3%BAblico.jpg?s=612x612&w=0&k=20&c=zl6SrTq50CuHHJ8V8L13EwQP4TNcsXRvKeyvIEtZd1c=') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .booking-card {
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 30px;
            max-width: 1200px;
            width: 95%;
            margin: 60px auto;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .btn-orange { background-color: #FF5722; color: #fff; }
        .btn-orange:hover { background-color: #E64A19; color: #fff; }

        .step { display: none; }
        .step.active { display: block; }

        .navbar { background-color: rgba(16,24,39,0.9); }
        .navbar-brand img { height: 60px; }

        /* Silueta del bus */
        .bus-container {
            position: relative;
            margin: 20px auto;
            width: 100%;
            max-width: 250px;
            height: 600px;
            background: #f2f2f2;
            border-radius: 40px;
            padding: 20px 10px;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.2);
        }
        .driver-seat {
            width: 60px;
            height: 60px;
            background: #ffeb3b;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }
        /* Cabina */
        .bus-cabin {
            width: 100%;
            height: 40px;
            background: #dcdcdc;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }
        .bus-cabin i { font-size: 24px; color: #555; }

        /* Asientos */
        .seat-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .seat {
            width: 50px;
            height: 50px;
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
        .seat:hover { background: #e0e0e0; }
        .seat.selected { background: #0d6efd; color: #fff; border-color: #0d6efd; }

        .aisle {
            width: 40px;
        }

        @media(max-width:768px){
            .seat { width: 40px; height: 40px; font-size: 14px; }
            .aisle { width: 20px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('Imagenes/bustrak-logo.png') }}" alt="Bustrak Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            @guest
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-login">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-success btn-registro">Regístrate</a>
                </div>
            @endguest
            @auth
                <div class="d-flex gap-2 align-items-center">
                    <span class="text-white me-2">¡Hola, {{ auth()->user()->name }}!</span>
                    <a href="{{ route('cliente.perfil') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill shadow-sm">
                        <i class="fas fa-user me-1"></i> Perfil
                    </a>
                    <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill shadow-sm"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
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
                    <select name="ciudad_origen_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="1">Tegucigalpa</option>
                        <option value="2">San Pedro Sula</option>
                        <option value="3">La Ceiba</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">A</label>
                    <select name="ciudad_destino_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="4">Copán</option>
                        <option value="5">Choluteca</option>
                        <option value="6">Gracias</option>
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
        <div class="list-group" id="viajesBox">
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>Tegucigalpa → Copán</strong><br>
                    <small>Salida: 08:30 AM</small><br>
                    <small>Asientos Disponibles: 14</small>
                </div>
                <button class="btn btn-orange select-asiento">Seleccionar</button>
            </div>
        </div>
        <div class="text-center mt-3">
            <button class="btn btn-secondary" onclick="showStep(1)">Volver</button>
        </div>
    </div>

    <!-- PASO 3: SELECCIÓN DE ASIENTO -->
    <div id="step3" class="step">
        <h4 class="mb-3">Seleccione su Asiento</h4>

        <div class="bus-container">
            <div class="bus-cabin"><i class="fas fa-steering-wheel"></i></div>

            <!-- Filas de asientos -->
            <div class="seat-row">
                <div class="seat">1A</div>
                <div class="seat">1B</div>
                <div class="aisle"></div>
                <div class="seat">1C</div>
                <div class="seat">1D</div>
            </div>
            <div class="seat-row">
                <div class="seat">2A</div>
                <div class="seat">2B</div>
                <div class="aisle"></div>
                <div class="seat">2C</div>
                <div class="seat">2D</div>
            </div>
            <div class="seat-row">
                <div class="seat">3A</div>
                <div class="seat">3B</div>
                <div class="aisle"></div>
                <div class="seat">3C</div>
                <div class="seat">3D</div>
            </div>
            <div class="seat-row">
                <div class="seat">4A</div>
                <div class="seat">4B</div>
                <div class="aisle"></div>
                <div class="seat">4C</div>
                <div class="seat">4D</div>
            </div>
            <div class="seat-row">
                <div class="seat">5A</div>
                <div class="seat">5B</div>
                <div class="aisle"></div>
                <div class="seat">5C</div>
                <div class="seat">5D</div>
            </div>
            <div class="seat-row">
                <div class="seat">6A</div>
                <div class="seat">6B</div>
                <div class="aisle"></div>
                <div class="seat">6C</div>
                <div class="seat">6D</div>
            </div>
            <div class="seat-row">
                <div class="seat">7A</div>
                <div class="seat">7B</div>
                <div class="aisle"></div>
                <div class="seat">7C</div>
                <div class="seat">7D</div>
            </div>

        </div>

        <div class="text-center mt-4">
            <button id="confirmarBtn" class="btn btn-orange" disabled>Confirmar Reserva</button>
            <button class="btn btn-secondary" onclick="showStep(2)">Volver</button>
        </div>


    </div>

    <!-- PASO 4: CONFIRMACIÓN -->
    <div id="step4" class="step text-center">
        <h4 class="mb-3 text-success"><i class="fas fa-check-circle"></i> ¡Reserva Confirmada!</h4>
        <p><strong>Código:</strong> <span id="codigoReserva">ABC123</span></p>
        <p><strong>Asiento(s):</strong> <span id="reservaAsiento"></span></p>
        <a href="#" class="btn btn-orange" onclick="showStep(1)">Nueva Reserva</a>
    </div>
</div>

<script>
    function showStep(step){
        document.querySelectorAll('.step').forEach(el=>el.classList.remove('active'));
        document.getElementById('step'+step).classList.add('active');
    }

    document.getElementById('buscarForm').addEventListener('submit', function(e){
        e.preventDefault();
        showStep(2);
    });

    document.querySelectorAll('.select-asiento').forEach(btn=>{
        btn.addEventListener('click', function(){
            showStep(3);
        });
    });

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
        document.getElementById('reservaAsiento').textContent = seleccionados;
        showStep(4);
    });
</script>

</body>
</html>
