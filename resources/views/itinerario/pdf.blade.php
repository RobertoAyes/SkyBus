<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Itinerario de Viajes - {{ $usuario->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 10px;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 20px;
            margin: -10px -10px 20px -10px;
            text-align: center;
            border-bottom: 3px solid #1e40af;
        }

        .logo-container {
            margin-bottom: 8px;
        }

        .logo-container img {
            max-width: 100px;
            height: auto;
        }

        .header h1 {
            color: white;
            margin: 8px 0;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
            opacity: 0.9;
        }

        .info-usuario {
            background: linear-gradient(to right, #eff6ff 0%, #dbeafe 100%);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 18px;
            border-left: 4px solid #1e3a8a;
        }

        .info-usuario h3 {
            color: #1e3a8a;
            margin: 0 0 12px 0;
            font-size: 14px;
            border-bottom: 1px solid #3b82f6;
            padding-bottom: 6px;
        }

        .info-usuario p {
            margin: 6px 0;
            line-height: 1.6;
            font-size: 11px;
        }

        .info-usuario strong {
            color: #1e40af;
            min-width: 80px;
            display: inline-block;
        }

        .reservas-title {
            background-color: #1e3a8a;
            color: white;
            padding: 10px 15px;
            border-radius: 3px;
            margin-bottom: 15px;
            font-size: 13px;
            font-weight: bold;
        }

        .reserva {
            border: 2px solid #3b82f6;
            border-left: 6px solid #1e3a8a;
            padding: 15px;
            margin-bottom: 15px;
            page-break-inside: avoid;
            background: white;
            border-radius: 5px;
        }

        .reserva-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dbeafe;
        }

        .reserva h3 {
            color: #1e3a8a;
            margin: 0;
            font-size: 15px;
            font-weight: bold;
        }

        .ruta-icono {
            font-size: 16px;
            color: #3b82f6;
            margin: 0 6px;
        }

        .detalle {
            display: table;
            width: 100%;
            margin-bottom: 6px;
            padding: 4px 0;
        }

        .detalle-label {
            display: table-cell;
            width: 35%;
            font-weight: bold;
            color: #1e40af;
            padding-right: 10px;
            font-size: 11px;
        }

        .detalle-label i {
            margin-right: 5px;
            color: #3b82f6;
        }

        .detalle-valor {
            display: table-cell;
            width: 65%;
            color: #374151;
            font-size: 11px;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-success {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .badge-warning {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        }

        .qr-code {
            text-align: center;
            margin: 12px 0 8px 0;
            padding: 12px;
            background-color: #f8fafc;
            border-radius: 5px;
            border: 1px dashed #3b82f6;
        }

        .qr-code img {
            width: 90px;
            height: 90px;
            padding: 8px;
            background: white;
            border-radius: 5px;
        }

        .qr-code p {
            font-size: 10px;
            color: #1e40af;
            margin-top: 8px;
            font-weight: bold;
        }

        .qr-code p i {
            margin-right: 3px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            border-top: 2px solid #1e3a8a;
            padding-top: 12px;
            background-color: #f8fafc;
            padding: 15px;
            margin-left: -10px;
            margin-right: -10px;
            margin-bottom: -10px;
        }

        .footer p {
            margin: 4px 0;
        }

        .footer strong {
            color: #1e3a8a;
            font-size: 10px;
        }

        .footer i {
            margin: 0 3px;
        }

        .no-reservas {
            text-align: center;
            color: #6b7280;
            padding: 30px 15px;
            background-color: #f8fafc;
            border-radius: 5px;
            border: 1px dashed #cbd5e1;
        }

        .codigo-reserva {
            background-color: #1e3a8a;
            color: white;
            padding: 6px 12px;
            border-radius: 3px;
            display: inline-block;
            margin-top: 8px;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .reserva-grid {
            display: table;
            width: 100%;
        }

        .reserva-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 8px;
        }

        .icon-title {
            margin-right: 5px;
            color: white;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="logo-container">
        @if(isset($logoBase64) && $logoBase64)
            <img src="{{ $logoBase64 }}" alt="BUSTRAK">
        @endif
    </div>
    <h1> BUSTRAK</h1>
    <p>Sistema de Gestión de Transporte Interurbano</p>
</div>

<div class="info-usuario">
    <h3> Información del Pasajero</h3>
    <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
    <p><strong>DNI:</strong> {{ $usuario->dni }} | <strong>Email:</strong> {{ $usuario->email }}</p>
    <p><strong>Teléfono:</strong> {{ $usuario->telefono }} | <strong>Generado:</strong> {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
</div>

<div class="reservas-title">
     Total de Reservas: {{ $reservas->count() }}
</div>

@forelse($reservas as $reserva)
    <div class="reserva">
        <div class="reserva-header">
            <h3>
                {{ $reserva->viaje->origen->nombre ?? 'Origen' }}
                <span class="ruta-icono">a</span>
                {{ $reserva->viaje->destino->nombre ?? 'Destino' }}
            </h3>
            <span class="badge {{ $reserva->estado == 'confirmado' ? 'badge-success' : ($reserva->estado == 'pendiente' ? 'badge-warning' : 'badge-danger') }}">
                    {{ strtoupper($reserva->estado) }}
                </span>
        </div>

        <div class="reserva-grid">
            <div class="reserva-col">
                <div class="detalle">
                    <span class="detalle-label"> Origen:</span>
                    <span class="detalle-valor">{{ $reserva->viaje->origen->nombre ?? 'N/A' }}</span>
                </div>
                <div class="detalle">
                    <span class="detalle-label"> Destino:</span>
                    <span class="detalle-valor">{{ $reserva->viaje->destino->nombre ?? 'N/A' }}</span>
                </div>
                <div class="detalle">
                    <span class="detalle-label"> Fecha:</span>
                    <span class="detalle-valor">
                            {{ $reserva->viaje->fecha_hora_salida ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('d/m/Y') : 'N/A' }}
                        </span>
                </div>
                <div class="detalle">
                    <span class="detalle-label"> Hora:</span>
                    <span class="detalle-valor">
                            {{ $reserva->viaje->fecha_hora_salida ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('H:i') : 'N/A' }}
                        </span>
                </div>
                <div class="detalle">
                    <span class="detalle-label"> Asiento:</span>
                    <span class="detalle-valor">{{ $reserva->asiento->numero_asiento ?? 'N/A' }}</span>
                </div>
                <div class="detalle">
                    <span class="detalle-label"> Reserva:</span>
                    <span class="detalle-valor">{{ $reserva->id }}</span>
                </div>
            </div>

            <div class="reserva-col">
                <div style="text-align: center; margin-bottom: 5px;">
                    <span class="codigo-reserva">{{ $reserva->codigo_reserva }}</span>
                </div>
                <div class="qr-code">
                    <img src="{{ $qrCodes[$reserva->id] }}" alt="QR">
                    <p> Código QR para abordar</p>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="no-reservas">
        <p style="font-size: 12px; color: #1e3a8a; font-weight: bold;">ℹ No hay reservas</p>
        <p style="margin-top: 5px;">No se encontraron reservas para mostrar.</p>
    </div>
@endforelse

<div class="footer">
    <p><strong>BUSTRAK</strong> - Sistema de Gestión de Reservas | Este documento es válido como comprobante</p>
    <p> soporte@bustrak.com   | © 2024 BUSTRAK. Todos los derechos reservados.</p>
</div>
</body>
</html>
