<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTrak - Catálogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { height: 100%; overflow-y: scroll; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            margin: 0;
        }
        main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .topbar {
            background: linear-gradient(180deg, #1e63b8, #1976d2);
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }
        .topbar-logo-icon {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 22px;
        }
        .topbar-logo-text {
            display: flex;
            flex-direction: column;
        }
        .topbar-logo-text h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }
        .topbar-logo-text p {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }
        .topbar-title h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }
        .container-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px;
            width: 100%;
        }
        .filtros-wrapper {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }
        .filtros-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .filtros-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        .btn-limpiar {
            background-color: #fee2e2;
            color: #dc2626;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
        }
        .btn-limpiar:hover { background-color: #fecaca; }
        .filtros-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
        }
        .filtro-group { display: flex; flex-direction: column; }
        .filtro-group label {
            font-size: 13px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .filtro-group input, .filtro-group select {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 13px;
            background-color: #f9fafb;
        }
        .departamentos-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }
        .departamentos-section h2 {
            font-size: 24px;
            font-weight: 800;
            color: #1f2937;
            text-align: center;
            margin-bottom: 30px;
        }
        .departamentos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }
        .departamento-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            height: 220px;
        }
        .departamento-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .departamento-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .departamento-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 20px;
            color: white;
        }
        .departamento-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        .viajes-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .viajes-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .viaje-card {
            border-left: 4px solid #1976d2;
            padding: 20px;
            background: #fafbfc;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: all 0.2s;
            border: 1px solid #e5e7eb;
        }
        .viaje-card:hover {
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
        .viaje-content {
            display: grid;
            grid-template-columns: 1.4fr 1.2fr 1fr 1fr 1fr 1fr auto;
            gap: 16px;
            align-items: center;
        }
        .viaje-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .viaje-label {
            font-size: 11px;
            color: #9ca3af;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .viaje-value {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }
        .viaje-precio {
            font-size: 20px;
            color: #1976d2;
            font-weight: 700;
        }
        .viaje-precio-compra {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: flex-end;
        }
        .btn-comprar {
            background-color: #1976d2;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-comprar:hover { background-color: #1565c0; }
        .btn-eliminar {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-eliminar:hover { background-color: #dc2626; }
        .btn-eliminar:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .modal-waitlist {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
        .modal-waitlist.show { display: flex; }
        .modal-content-waitlist {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        .modal-waitlist h2 {
            color: #1976d2;
            margin-bottom: 15px;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-waitlist p {
            color: #6b7280;
            margin-bottom: 20px;
        }
        .waitlist-info {
            background: #e0f2fe;
            border-left: 4px solid #1976d2;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #1f2937;
            line-height: 1.8;
        }
        .waitlist-info strong {
            color: #1976d2;
            display: block;
            margin-bottom: 5px;
        }
        .modal-buttons {
            display: flex;
            gap: 10px;
        }
        .modal-buttons button {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-confirmar {
            background-color: #1976d2;
            color: white;
        }
        .btn-confirmar:hover {
            background-color: #1565c0;
        }
        .btn-cancelar {
            background-color: #ef4444;
            color: white;
        }
        .btn-cancelar:hover {
            background-color: #dc2626;
        }
        @media (max-width: 768px) {
            .filtros-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .viaje-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="modal-waitlist" id="waitlistModal">
    <div class="modal-content-waitlist">
        <h2 id="modalTitle"><i class="fas fa-check-circle"></i> Confirmar Compra</h2>
        <p id="modalMessage">¿Deseas confirmar la compra de este boleto?</p>
        <div class="waitlist-info" id="waitlistDetails"></div>
        <div class="modal-buttons">
            <button class="btn-confirmar" onclick="confirmarAccion()"><i class="fas fa-check"></i> Confirmar</button>
            <button class="btn-cancelar" onclick="cerrarModal()"><i class="fas fa-times"></i> Cancelar</button>
        </div>
    </div>
</div>

<main>
    <div class="topbar">
        <a href="/principal" class="topbar-logo">
            <div class="topbar-logo-icon">B</div>
            <div class="topbar-logo-text">
                <h3>BusTrak</h3>
                <p>Sistema de Gestión</p>
            </div>
        </a>
        <div style="position: absolute; left: 50%; transform: translateX(-50%);">
            <h1 style="font-size: 1.4rem; font-weight: 700; color: #ffffff; margin: 0;">Catálogo de Viajes</h1>
        </div>
    </div>

    <div class="container-main">
        <div class="filtros-wrapper">
            <div class="filtros-header">
                <h2><i class="fas fa-search"></i> Filtros de Búsqueda</h2>
                <button class="btn-limpiar" onclick="location.reload()"><i class="fas fa-times"></i> Limpiar Filtros</button>
            </div>
            <div class="filtros-grid">
                <div class="filtro-group">
                    <label><i class="fas fa-map-marker-alt"></i> Origen</label>
                    <input type="text" value="Danlí" disabled style="font-weight: 700;">
                </div>
                <div class="filtro-group">
                    <label><i class="fas fa-map-marker-alt"></i> Destino</label>
                    <select id="destino" onchange="filtrar()">
                        <option value="">Seleccionar</option>
                        <option value="Atlántida">Atlántida</option>
                        <option value="Choluteca">Choluteca</option>
                        <option value="Colón">Colón</option>
                        <option value="Comayagua">Comayagua</option>
                        <option value="Copán">Copán</option>
                        <option value="Cortés">Cortés</option>
                        <option value="El Paraíso">El Paraíso</option>
                        <option value="Francisco Morazán">Francisco Morazán</option>
                        <option value="Gracias a Dios">Gracias a Dios</option>
                        <option value="Intibucá">Intibucá</option>
                        <option value="Islas de la Bahía">Islas de la Bahía</option>
                        <option value="La Paz">La Paz</option>
                        <option value="Lempira">Lempira</option>
                        <option value="Ocotepeque">Ocotepeque</option>
                        <option value="Olancho">Olancho</option>
                        <option value="Santa Bárbara">Santa Bárbara</option>
                        <option value="Valle">Valle</option>
                        <option value="Yoro">Yoro</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label><i class="fas fa-building"></i> Empresa de Buses</label>
                    <select id="empresa" onchange="filtrar()">
                        <option value="">Todas las empresas</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label><i class="fas fa-calendar"></i> Fecha</label>
                    <select id="fecha" onchange="mostrarDias()">
                        <option value="">Seleccionar Mes</option>
                        <option value="1">Enero 2025</option>
                        <option value="2">Febrero 2025</option>
                        <option value="3">Marzo 2025</option>
                        <option value="4">Abril 2025</option>
                        <option value="5">Mayo 2025</option>
                        <option value="6">Junio 2025</option>
                        <option value="7">Julio 2025</option>
                        <option value="8">Agosto 2025</option>
                        <option value="9">Septiembre 2025</option>
                        <option value="10">Octubre 2025</option>
                        <option value="11">Noviembre 2025</option>
                        <option value="12">Diciembre 2025</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label><i class="fas fa-calendar-day"></i> Día</label>
                    <select id="dia" onchange="filtrar()">
                        <option value="">Seleccionar Día</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label><i class="fas fa-clock"></i> Horario</label>
                    <select id="horario" onchange="filtrar()">
                        <option value="">Seleccionar</option>
                        <option value="6:00 AM">6:00 AM</option>
                        <option value="7:30 AM">7:30 AM</option>
                        <option value="9:00 AM">9:00 AM</option>
                        <option value="10:30 AM">10:30 AM</option>
                        <option value="12:00 PM">12:00 PM</option>
                        <option value="1:30 PM">1:30 PM</option>
                        <option value="3:00 PM">3:00 PM</option>
                        <option value="4:30 PM">4:30 PM</option>
                        <option value="6:00 PM">6:00 PM</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="departamentos-section">
            <h2><i class="fas fa-map"></i> Destinos desde Danlí</h2>
            <div class="departamentos-grid" id="departamentosGrid"></div>
        </div>

        <div class="viajes-section">
            <h2><i class="fas fa-bus"></i> Viajes Disponibles <span id="contador">(0)</span></h2>
            <div id="viajesContainer"></div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let boletosComprados = 0;
    let viajeSeleccionado = null;
    let esEliminacion = false;
    let comprasUsuario = {};
    let asientosVendidos = {};

    const viajesDatos = [
        { ruta: 'Danlí → Cortés', fecha: '2025-01-15', horario: '6:00 AM', duracion: '3h 30m', precio: 250, destino: 'Cortés', empresa: 'Transporte Express' },
        { ruta: 'Danlí → Cortés', fecha: '2025-02-20', horario: '9:00 AM', duracion: '3h 30m', precio: 250, destino: 'Cortés', empresa: 'Buses del Norte' },
        { ruta: 'Danlí → Atlántida', fecha: '2025-02-10', horario: '9:00 AM', duracion: '4h 15m', precio: 320, destino: 'Atlántida', empresa: 'Viajes Rápidos' },
        { ruta: 'Danlí → Atlántida', fecha: '2025-03-15', horario: '7:30 AM', duracion: '4h 15m', precio: 320, destino: 'Atlántida', empresa: 'Línea Dorada' },
        { ruta: 'Danlí → Francisco Morazán', fecha: '2025-03-20', horario: '12:00 PM', duracion: '2h 45m', precio: 180, destino: 'Francisco Morazán', empresa: 'Autobuses Unidos' },
        { ruta: 'Danlí → Francisco Morazán', fecha: '2025-04-18', horario: '3:00 PM', duracion: '2h 45m', precio: 180, destino: 'Francisco Morazán', empresa: 'Transporte Express' },
        { ruta: 'Danlí → Choluteca', fecha: '2025-04-12', horario: '7:30 AM', duracion: '5h 20m', precio: 380, destino: 'Choluteca', empresa: 'Buses del Norte' },
        { ruta: 'Danlí → Choluteca', fecha: '2025-05-22', horario: '10:30 AM', duracion: '5h 20m', precio: 380, destino: 'Choluteca', empresa: 'Viajes Rápidos' },
        { ruta: 'Danlí → Comayagua', fecha: '2025-05-08', horario: '3:00 PM', duracion: '3h 10m', precio: 210, destino: 'Comayagua', empresa: 'Línea Dorada' },
        { ruta: 'Danlí → Comayagua', fecha: '2025-06-12', horario: '6:00 AM', duracion: '3h 10m', precio: 210, destino: 'Comayagua', empresa: 'Autobuses Unidos' },
        { ruta: 'Danlí → Colón', fecha: '2025-06-18', horario: '10:30 AM', duracion: '4h 05m', precio: 290, destino: 'Colón', empresa: 'Transporte Express' },
        { ruta: 'Danlí → Colón', fecha: '2025-07-14', horario: '1:30 PM', duracion: '4h 05m', precio: 290, destino: 'Colón', empresa: 'Buses del Norte' },
        { ruta: 'Danlí → Copán', fecha: '2025-07-25', horario: '1:30 PM', duracion: '4h 40m', precio: 340, destino: 'Copán', empresa: 'Viajes Rápidos' },
        { ruta: 'Danlí → Copán', fecha: '2025-08-19', horario: '4:30 PM', duracion: '4h 40m', precio: 340, destino: 'Copán', empresa: 'Línea Dorada' },
        { ruta: 'Danlí → El Paraíso', fecha: '2025-08-14', horario: '4:30 PM', duracion: '2h 55m', precio: 165, destino: 'El Paraíso', empresa: 'Autobuses Unidos' },
        { ruta: 'Danlí → El Paraíso', fecha: '2025-09-10', horario: '6:00 PM', duracion: '2h 55m', precio: 165, destino: 'El Paraíso', empresa: 'Transporte Express' },
        { ruta: 'Danlí → Yoro', fecha: '2025-09-22', horario: '6:00 PM', duracion: '3h 20m', precio: 220, destino: 'Yoro', empresa: 'Buses del Norte' },
        { ruta: 'Danlí → Yoro', fecha: '2025-10-16', horario: '9:00 AM', duracion: '3h 20m', precio: 220, destino: 'Yoro', empresa: 'Viajes Rápidos' },
        { ruta: 'Danlí → Gracias a Dios', fecha: '2025-10-05', horario: '8:00 AM', duracion: '4h 50m', precio: 295, destino: 'Gracias a Dios', empresa: 'Línea Dorada' },
        { ruta: 'Danlí → Intibucá', fecha: '2025-11-30', horario: '2:00 PM', duracion: '3h 25m', precio: 185, destino: 'Intibucá', empresa: 'Autobuses Unidos' },
        { ruta: 'Danlí → Islas de la Bahía', fecha: '2025-01-25', horario: '7:30 AM', duracion: '5h 10m', precio: 420, destino: 'Islas de la Bahía', empresa: 'Transporte Express' },
        { ruta: 'Danlí → Islas de la Bahía', fecha: '2025-03-12', horario: '10:30 AM', duracion: '5h 10m', precio: 420, destino: 'Islas de la Bahía', empresa: 'Buses del Norte' },
        { ruta: 'Danlí → La Paz', fecha: '2025-02-14', horario: '12:00 PM', duracion: '3h 35m', precio: 195, destino: 'La Paz', empresa: 'Viajes Rápidos' },
        { ruta: 'Danlí → La Paz', fecha: '2025-04-22', horario: '1:30 PM', duracion: '3h 35m', precio: 195, destino: 'La Paz', empresa: 'Línea Dorada' },
        { ruta: 'Danlí → Lempira', fecha: '2025-05-18', horario: '6:00 AM', duracion: '4h 25m', precio: 310, destino: 'Lempira', empresa: 'Autobuses Unidos' },
        { ruta: 'Danlí → Lempira', fecha: '2025-07-08', horario: '9:00 AM', duracion: '4h 25m', precio: 310, destino: 'Lempira', empresa: 'Transporte Express' },
        { ruta: 'Danlí → Ocotepeque', fecha: '2025-06-05', horario: '3:00 PM', duracion: '4h 55m', precio: 360, destino: 'Ocotepeque', empresa: 'Buses del Norte' },
        { ruta: 'Danlí → Ocotepeque', fecha: '2025-08-28', horario: '4:30 PM', duracion: '4h 55m', precio: 360, destino: 'Ocotepeque', empresa: 'Viajes Rápidos' },
        { ruta: 'Danlí → Olancho', fecha: '2025-07-17', horario: '7:30 AM', duracion: '3h 40m', precio: 240, destino: 'Olancho', empresa: 'Línea Dorada' },
        { ruta: 'Danlí → Olancho', fecha: '2025-09-19', horario: '10:30 AM', duracion: '3h 40m', precio: 240, destino: 'Olancho', empresa: 'Autobuses Unidos' },
        { ruta: 'Danlí → Santa Bárbara', fecha: '2025-08-06', horario: '12:00 PM', duracion: '4h 15m', precio: 285, destino: 'Santa Bárbara', empresa: 'Transporte Express' },
        { ruta: 'Danlí → Santa Bárbara', fecha: '2025-10-24', horario: '1:30 PM', duracion: '4h 15m', precio: 285, destino: 'Santa Bárbara', empresa: 'Buses del Norte' },
        { ruta: 'Danlí → Valle', fecha: '2025-09-03', horario: '6:00 PM', duracion: '5h 30m', precio: 395, destino: 'Valle', empresa: 'Viajes Rápidos' },
        { ruta: 'Danlí → Valle', fecha: '2025-11-14', horario: '9:00 AM', duracion: '5h 30m', precio: 395, destino: 'Valle', empresa: 'Línea Dorada' }
    ];

    const departamentos = ['Cortés', 'Atlántida', 'Francisco Morazán', 'Choluteca', 'Comayagua', 'Colón', 'Copán', 'El Paraíso', 'Yoro', 'Gracias a Dios', 'Intibucá', 'Islas de la Bahía', 'La Paz', 'Lempira', 'Ocotepeque', 'Olancho', 'Santa Bárbara', 'Valle'];

    function cargarEmpresas() {
        const empresasUnicas = [...new Set(viajesDatos.map(v => v.empresa))];
        const selectEmpresa = document.getElementById('empresa');
        empresasUnicas.forEach(emp => {
            const option = document.createElement('option');
            option.value = emp;
            option.textContent = emp;
            selectEmpresa.appendChild(option);
        });
    }

    function getDaysInMonth(m) {
        const d = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        return d[m - 1];
    }

    function mostrarDias() {
        const m = document.getElementById('fecha').value;
        const ds = document.getElementById('dia');
        if (m === '') {
            ds.innerHTML = '<option value="">Seleccionar Día</option>';
            return;
        }
        let h = '<option value="">Seleccionar Día</option>';
        for (let i = 1; i <= getDaysInMonth(parseInt(m)); i++) {
            h += `<option value="${String(i).padStart(2, '0')}">${String(i).padStart(2, '0')}</option>`;
        }
        ds.innerHTML = h;
    }

    function filtrarDestino(d) {
        document.getElementById('destino').value = d;
        document.getElementById('fecha').value = '';
        document.getElementById('dia').value = '';
        document.getElementById('horario').value = '';
        document.getElementById('empresa').value = '';
        filtrar();
        document.querySelector('.viajes-section').scrollIntoView({ behavior: 'smooth' });
    }

    function filtrar() {
        const d = document.getElementById('destino').value;
        const m = document.getElementById('fecha').value;
        const dia = document.getElementById('dia').value;
        const h = document.getElementById('horario').value;
        const e = document.getElementById('empresa').value;

        let f = '';
        if (m && dia) {
            f = `2025-${m.padStart(2, '0')}-${dia}`;
        }

        mostrarViajes(viajesDatos.filter(v => {
            const cd = !d || v.destino === d;
            const cf = !f || v.fecha === f;
            const ch = !h || v.horario === h;
            const ce = !e || v.empresa === e;
            return cd && cf && ch && ce;
        }));
    }

    function solicitarViaje(index) {
        viajeSeleccionado = index;
        esEliminacion = false;
        const viaje = viajesDatos[index];
        const fechaFormateada = new Date(viaje.fecha + 'T00:00:00').toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });

        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-ticket-alt"></i> Confirmar Compra';
        document.getElementById('modalMessage').textContent = '¿Deseas confirmar la compra de este boleto?';
        document.getElementById('waitlistDetails').innerHTML = `
            <strong>Empresa:</strong> ${viaje.empresa}<br>
            <strong>Ruta:</strong> ${viaje.ruta}<br>
            <strong>Fecha:</strong> ${fechaFormateada}<br>
            <strong>Horario:</strong> ${viaje.horario}<br>
            <strong>Precio:</strong> L${viaje.precio.toFixed(2)}<br>
            <strong>Asientos Vendidos:</strong> ${asientosVendidos[index] || 0}/30
        `;
        document.getElementById('waitlistModal').classList.add('show');
    }

    function eliminarCompra(index) {
        viajeSeleccionado = index;
        esEliminacion = true;
        const viaje = viajesDatos[index];
        const fechaFormateada = new Date(viaje.fecha + 'T00:00:00').toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });

        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-trash"></i> Eliminar Compra';
        document.getElementById('modalMessage').textContent = '¿Deseas eliminar esta compra?';
        document.getElementById('waitlistDetails').innerHTML = `
            <strong>Empresa:</strong> ${viaje.empresa}<br>
            <strong>Ruta:</strong> ${viaje.ruta}<br>
            <strong>Fecha:</strong> ${fechaFormateada}<br>
            <strong>Horario:</strong> ${viaje.horario}<br>
            <strong>Precio:</strong> L${viaje.precio.toFixed(2)}<br>
            <strong>Asientos Vendidos:</strong> ${asientosVendidos[index] || 0}/30
        `;
        document.getElementById('waitlistModal').classList.add('show');
    }

    function confirmarAccion() {
        if (esEliminacion) {
            boletosComprados--;
            if (boletosComprados < 0) boletosComprados = 0;
            asientosVendidos[viajeSeleccionado] = (asientosVendidos[viajeSeleccionado] || 0) - 1;
            if (asientosVendidos[viajeSeleccionado] < 0) asientosVendidos[viajeSeleccionado] = 0;
            delete comprasUsuario[viajeSeleccionado];
        } else {
            if (boletosComprados < 30) {
                boletosComprados++;
                asientosVendidos[viajeSeleccionado] = (asientosVendidos[viajeSeleccionado] || 0) + 1;
                comprasUsuario[viajeSeleccionado] = true;
            }
        }

        document.getElementById('waitlistModal').classList.remove('show');
        mostrarViajes(viajesDatos);
    }

    function cerrarModal() {
        document.getElementById('waitlistModal').classList.remove('show');
        viajeSeleccionado = null;
        esEliminacion = false;
    }

    function mostrarViajes(v) {
        const c = document.getElementById('viajesContainer');
        const cn = document.getElementById('contador');

        if (v.length === 0) {
            const destino = document.getElementById('destino').value;
            const mes = document.getElementById('fecha').value;
            const dia = document.getElementById('dia').value;
            const horario = document.getElementById('horario').value;
            const empresa = document.getElementById('empresa').value;

            let mensajeFiltros = '';
            if (destino) mensajeFiltros += `<strong>Destino:</strong> ${destino}<br>`;
            if (empresa) mensajeFiltros += `<strong>Empresa:</strong> ${empresa}<br>`;
            if (mes && dia) mensajeFiltros += `<strong>Fecha:</strong> ${dia}/${mes}/2025<br>`;
            if (horario) mensajeFiltros += `<strong>Horario:</strong> ${horario}<br>`;

            c.innerHTML = `
                <div style="background: #dbeafe; padding: 40px; border-radius: 12px; border: 2px dashed #3b82f6; text-align: center;">
                    <div style="font-size: 4rem; margin-bottom: 20px; color: #3b82f6;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 style="color: #1e40af; margin-bottom: 15px; font-size: 1.3rem;">No hay viajes disponibles</h3>
                    <p style="color: #1e40af; margin-bottom: 20px;">No encontramos viajes con los siguientes criterios:</p>
                    <div style="background: white; padding: 15px; border-radius: 8px; margin: 0 auto 25px; text-align: left; display: inline-block; max-width: 400px;">
                        ${mensajeFiltros || '<em>Sin filtros aplicados</em>'}
                    </div>
                    <div style="margin-top: 20px;">
                        <button onclick="location.reload()" style="background: #6c757d; color: white; border: none; padding: 14px 30px; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);">
                            <i class="fas fa-sync"></i> Ver todos los viajes
                        </button>
                    </div>
                </div>
            `;
            cn.textContent = '(0)';
            return;
        }

        c.innerHTML = v.map((x, i) => {
            const viajeFull = viajesDatos.indexOf(x);
            const hayAsientos = (asientosVendidos[viajeFull] || 0) > 0;
            return `<div class="viaje-card">
                <div class="viaje-content">
                    <div class="viaje-info">
                        <span class="viaje-label"><i class="fas fa-route"></i> Ruta</span>
                        <span class="viaje-value">${x.ruta}</span>
                    </div>
                    <div class="viaje-info">
                        <span class="viaje-label"><i class="fas fa-building"></i> Empresa</span>
                        <span class="viaje-value">${x.empresa}</span>
                    </div>
                    <div class="viaje-info">
                        <span class="viaje-label"><i class="fas fa-calendar"></i> Fecha</span>
                        <span class="viaje-value">${new Date(x.fecha + 'T00:00:00').toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' })}</span>
                    </div>
                    <div class="viaje-info">
                        <span class="viaje-label"><i class="fas fa-clock"></i> Horario</span>
                        <span class="viaje-value">${x.horario}</span>
                    </div>
                    <div class="viaje-info">
                        <span class="viaje-label"><i class="fas fa-hourglass"></i> Duración</span>
                        <span class="viaje-value">${x.duracion}</span>
                    </div>
                    <div class="viaje-info">
                        <span class="viaje-label"><i class="fas fa-dollar-sign"></i> Precio</span>
                        <span class="viaje-precio">L${x.precio.toFixed(2)}</span>
                    </div>
                    <div class="viaje-precio-compra">
                        <button class="btn-comprar" onclick="solicitarViaje(${viajeFull})"><i class="fas fa-shopping-cart"></i> Comprar</button>
                        <button class="btn-eliminar" onclick="eliminarCompra(${viajeFull})" ${!hayAsientos ? 'disabled' : ''}><i class="fas fa-trash"></i> Eliminar Compra</button>
                    </div>
                </div>
            </div>`;
        }).join('');
        cn.textContent = `(${v.length})`;
    }

    function cargarDepartamentos() {
        const grid = document.getElementById('departamentosGrid');
        const imgMap = {
            'Cortés': '/catalago/img/cortes.jpg',
            'Atlántida': '/catalago/img/atlantida.jpg',
            'Francisco Morazán': '/catalago/img/francisco.jpg',
            'Choluteca': '/catalago/img/choluteca.jpg',
            'Comayagua': '/catalago/img/comayagua.jpg',
            'Colón': '/catalago/img/colon.jpg',
            'Copán': '/catalago/img/copan.jpg',
            'El Paraíso': '/catalago/img/elparaiso.jpg',
            'Yoro': '/catalago/img/yoro.jpg',
            'Gracias a Dios': '/catalago/img/gracias.jpg',
            'Intibucá': '/catalago/img/intibuca.jpg',
            'Islas de la Bahía': '/catalago/img/islas.jpg',
            'La Paz': '/catalago/img/lapaz.jpg',
            'Lempira': '/catalago/img/lempira.jpg',
            'Ocotepeque': '/catalago/img/ocotepeque.jpg',
            'Olancho': '/catalago/img/olancho.jpg',
            'Santa Bárbara': '/catalago/img/santabarbara.jpg',
            'Valle': '/catalago/img/valle.jpg'
        };

        grid.innerHTML = departamentos.map(d => `
            <div class="departamento-card" onclick="filtrarDestino('${d}')">
                <img src="${imgMap[d]}" alt="${d}" onerror="this.src='https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600'">
                <div class="departamento-overlay">
                    <p class="departamento-title">Autobuses de Danlí a ${d}</p>
                </div>
            </div>
        `).join('');
    }

    cargarEmpresas();
    cargarDepartamentos();
    mostrarViajes(viajesDatos);
</script>
</body>
</html>
