@extends('layouts.layoutchofer')
@section('contenido')

    <style>
        html, body {
            height: auto !important;
            overflow: visible !important;
            background: #f3f6fb;
        }

        .container-profile {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 15px;
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        /* CARD IZQUIERDA: Foto, perfil, correo */
        .card-left {
            flex: 0 0 260px;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100%;
        }

        .avatar-lg {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: #dfe6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            font-weight: bold;
            margin: auto 0 10px 0;
            object-fit: cover;
        }

        .card-left .value {
            font-weight: 700;
            margin-top: 10px;
            font-size: 16px;
        }

        .card-left .info-item {
            margin-top: 15px;
            background: #eef2ff;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 14px;
            color: #3b5bdb;
        }

        /* CARD DERECHA: Información del chofer */
        .card-right {
            flex: 1;
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .top-card {
            background: linear-gradient(90deg, #4f6edb, #6ea8fe);
            color: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 40px;
        }

        .info-group {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .label {
            font-size: 12px;
            color: #888;
            font-weight: 600;
        }

        .value {
            font-size: 15px;
            font-weight: 600;
            color: #222;
            margin-top: 5px;
            display: block; /* fuerza salto de línea */
        }

        .badge-status, .badge-type {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 5px;
            text-align: center;
        }

        .badge-type {
            background: #e7f0ff;
            color: #3b5bdb;
        }

        .badge-status {
            background: #d4edda;
            color: #155724;
        }

        @media (max-width: 768px) {
            .container-profile {
                flex-direction: column;
            }
            .card-left {
                width: 100%;
            }
            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px 0;
            }
        }
    </style>

    <div class="container-profile">

        <!-- Card izquierda: Foto, perfil, correo -->
        <div class="card-left">
            @if($chofer->foto && file_exists(public_path('storage/' . $chofer->foto)))
                <img src="{{ asset('storage/' . $chofer->foto) }}" class="avatar-lg">
            @else
                <div class="avatar-lg">{{ strtoupper(substr($chofer->nombre_completo,0,1)) }}</div>
            @endif
            <div class="value">{{ $chofer->nombre_completo }}</div>
            <div class="info-item">Perfil</div>
            <div class="info-item">{{ $chofer->email ?? 'No registrado' }}</div>
        </div>

        <!-- Card derecha: Información del chofer -->
        <div class="card-right">
            <div class="top-card">
                <h4>Información del Chofer</h4>
                <small>Detalles generales de su cuenta</small>
            </div>

            <div class="info-grid">
                <!-- Columna izquierda de info -->
                <div class="info-group">
                    <div>
                        <span class="label">Nombre Completo</span>
                        <span class="value">{{ $chofer->nombre_completo }}</span>
                    </div>
                    <div>
                        <span class="label">Teléfono</span>
                        <span class="value">{{ $chofer->telefono ?? 'No registrado' }}</span>
                    </div>
                    <div>
                        <span class="label">Tipo de Cuenta</span>
                        <span class="badge-type">Chofer</span>
                    </div>
                </div>

                <!-- Columna derecha de info -->
                <div class="info-group">
                    <div>
                        <span class="label">Miembro Desde</span>
                        <span class="value">{{ $chofer->fecha_ingreso ? $chofer->fecha_ingreso->format('d/m/Y') : 'No registrada' }}</span>
                    </div>
                    <div>
                        <span class="label">DNI</span>
                        <span class="value">{{ $chofer->dni ?? 'No registrado' }}</span>
                    </div>
                    <div>
                        <span class="label">Estado</span>
                        <span class="badge-status">{{ ucfirst($chofer->estado) }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
