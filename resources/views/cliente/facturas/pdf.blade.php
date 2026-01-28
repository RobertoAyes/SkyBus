<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1976d2;
            padding-bottom: 20px;
        }
        .logo-container {
            margin-bottom: 15px;
        }
        .logo-container img {
            max-width: 120px;
            height: auto;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #1976d2;
            margin: 10px 0 5px 0;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .header .fiscal-info {
            font-size: 10px;
            color: #555;
            margin-top: 10px;
        }
        .factura-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .factura-info h2 {
            color: #1976d2;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .info-row {
            margin: 8px 0;
        }
        .info-label {
            font-weight: bold;
            color: #333;
        }
        .info-value {
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #1976d2;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        .total-row {
            background: #f8f9fa;
            font-weight: bold;
            font-size: 16px;
        }
        .total-row td {
            color: #1976d2;
            padding: 15px 12px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        .estado {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 11px;
        }
        .estado-emitida {
            background: #d4edda;
            color: #155724;
        }
        .estado-anulada {
            background: #f8d7da;
            color: #721c24;
        }
        .estado-duplicada {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
<!-- Header con Logo -->
<div class="header">
    <div class="logo-container">
        @if(file_exists(public_path('Imagenes/bustrak-logo.png')))
            <img src="{{ public_path('Imagenes/bustrak-logo.png') }}" alt="BUSTRAK">
        @else
            <p style="color: #999; font-size: 14px;">[Logo no disponible]</p>
        @endif
    </div>
    <div class="logo">BUSTRAK</div>
    <p>Sistema de Gestión de Boletos de Buses</p>
    <p>Honduras | Tegucigalpa</p>
    <div class="fiscal-info">
        <strong>RTN:</strong> 0801-1990-123456 |
        <strong>Tel:</strong> +504 2222-3333 |
        <strong>Email:</strong> facturas@bustrak.com
    </div>
</div>

<!-- Información de la Factura -->
<div class="factura-info">
    <h2>FACTURA {{ $factura->numero_factura }}</h2>
    <div class="info-row">
        <span class="info-label">Fecha de Emisión:</span>
        <span class="info-value">{{ $factura->fecha_emision->format('d/m/Y H:i') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Estado:</span>
        <span class="estado estado-{{ $factura->estado }}">{{ ucfirst($factura->estado) }}</span>
    </div>
</div>

<!-- Datos del Cliente -->
<div class="factura-info">
    <h2>DATOS DEL CLIENTE</h2>
    <div class="info-row">
        <span class="info-label">Nombre:</span>
        <span class="info-value">{{ $factura->user->name }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Correo:</span>
        <span class="info-value">{{ $factura->user->email }}</span>
    </div>
</div>

<!-- Detalles del Viaje -->
<div class="factura-info">
    <h2>DETALLES DEL VIAJE</h2>
    <div class="info-row">
        <span class="info-label">Origen - Destino:</span>
        <span class="info-value">
            {{ $factura->reserva->viaje->origen->nombre ?? '-' }} →
            {{ $factura->reserva->viaje->destino->nombre ?? '-' }}
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Fecha de Salida:</span>
        <span class="info-value">
            {{ \Carbon\Carbon::parse($factura->reserva->viaje->fecha_hora_salida)->format('d/m/Y H:i') }}
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Asiento:</span>
        <span class="info-value">#{{ $factura->reserva->asiento->numero_asiento ?? '-' }}</span>
    </div>
</div>

<!-- Desglose de Costos -->
<table>
    <thead>
    <tr>
        <th>Descripción</th>
        <th style="text-align: right;">Monto</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Viaje: {{ $factura->reserva->viaje->origen->nombre ?? '-' }} - {{ $factura->reserva->viaje->destino->nombre ?? '-' }}</td>
        <td style="text-align: right;">L. {{ number_format($factura->subtotal, 2) }}</td>
    </tr>
    <tr>
        <td>Impuestos (15%)</td>
        <td style="text-align: right;">L. {{ number_format($factura->impuestos, 2) }}</td>
    </tr>
    <tr>
        <td>Cargos adicionales</td>
        <td style="text-align: right;">L. {{ number_format($factura->cargos_adicionales, 2) }}</td>
    </tr>
    <tr class="total-row">
        <td>TOTAL</td>
        <td style="text-align: right;">L. {{ number_format($factura->monto_total, 2) }}</td>
    </tr>
    </tbody>
</table>

<!-- Información de Pago -->
<div class="info-row">
    <span class="info-label">Método de Pago:</span>
    <span class="info-value">{{ ucfirst($factura->metodo_pago) }}</span>
</div>

<!-- Footer -->
<div class="footer">
    <p><strong>¡Gracias por viajar con BUSTRAK!</strong></p>
    <p>Este documento es una factura oficial válida para fines contables.</p>
    <p>Para cualquier consulta, contáctanos a soporte@bustrak.com</p>
    <p style="margin-top: 20px; color: #999;">Factura generada automáticamente el {{ now()->format('d/m/Y H:i') }}</p>
</div>
</body>
</html>
