@extends('layouts.layoutuser')

@section('title', 'Mis Facturas')

@section('contenido')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        /* WRAPPER CON MÁRGENES Y PADDING */
        .ch-wrap {
            font-family: 'DM Sans', sans-serif;
            background: #f0f9ff;
            min-height: 10vh;
            padding: 1.7rem 4rem;
        }

        .greeting-banner {
            background: linear-gradient(135deg,#3a9fd6 0%,#5bb8e8 100%);
            border-radius: 20px;
            padding: 1.8rem 2rem;
            margin-bottom: 1.8rem;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 28px rgba(58,159,214,0.25);
        }
        .greeting-title { font-weight: 800; font-size: 1.5rem; }
        .greeting-sub   { font-size: 0.9rem; opacity: 0.85; }
        .greeting-icon-wrap { font-size: 1.6rem; }

        /* FILTROS */
        .ch-filters {
            background: #fff;
            border: 1px solid #e2edf8;
            border-radius: 10px;
            padding: .7rem 1rem;
            display: flex;
            gap: .6rem;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem; /* margen similar al card-body */
        }
        .ch-fg { display: flex; align-items: center; gap: .35rem; flex: 1; min-width: 140px; }
        .ch-fg-ico { color: #94a3b8; font-size: .75rem; flex-shrink: 0; }
        .ch-filters input, .ch-filters select {
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            border: 1px solid #c9dff2;
            border-radius: 7px;
            padding: .38rem .65rem;
            color: #1e3a5f;
            background: #f8fbff;
            width: 100%;
            outline: none;
            transition: border .15s, box-shadow .15s;
        }
        .ch-filters input:focus, .ch-filters select:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff; }
        .ch-btn-clear { font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600; color: #64748b; background: none; border: 1px solid #e2edf8; border-radius: 7px; padding: .38rem .8rem; cursor: pointer; white-space: nowrap; transition: all .15s; }
        .ch-btn-clear:hover { background: #f8fbff; color: #1e3a5f; border-color: #c9dff2; }
        .ch-filter-count { font-size: .75rem; color: #94a3b8; margin-left: auto; }

        /* TABLA */
        .ch-table-wrap {
            background: #fff;
            border: 1px solid #e2edf8;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 12px rgba(14,165,233,.06);
            padding: 1rem; /* padding tipo card-body */
        }
        .ch-table-wrap table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .ch-table-wrap thead { background: #f8fbff; border-bottom: 1px solid #c9dff2; }
        .ch-table-wrap thead th { padding: .7rem 1rem; color: #64748b; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; white-space: nowrap; }
        .ch-table-wrap tbody tr { border-bottom: 1px solid #f1f7fc; transition: background .12s; }
        .ch-table-wrap tbody tr:last-child { border-bottom: none; }
        .ch-table-wrap tbody tr:hover { background: #f0f9ff; }
        .ch-table-wrap tbody td { padding: .72rem 1rem; color: #2d5a8e; vertical-align: middle; }

        .ch-num { width: 28px; height: 28px; border-radius: 7px; background: #e0f2fe; border: 1px solid #bae6fd; display: flex; align-items: center; justify-content: center; font-family: 'DM Mono', monospace; font-size: .72rem; font-weight: 700; color: #0284c7; }

        .ch-route { display: inline-flex; align-items: center; gap: .35rem; background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: .25rem .65rem; border-radius: 20px; font-size: .78rem; font-weight: 600; white-space: nowrap; }
        .ch-route .sep { opacity: .4; font-size: .65rem; }

        .ch-date { font-family: 'DM Mono', monospace; font-size: .78rem; color: #64748b; }
        .ch-date-day { color: #1e3a5f; font-weight: 500; display: block; font-size: .82rem; }

        .ch-today-badge { display: inline-flex; align-items: center; gap: .3rem; font-size: .7rem; font-weight: 700; background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; border-radius: 20px; padding: .12rem .5rem; margin-top: .2rem; }

        .ch-empty td { text-align: center; padding: 3.5rem 1rem; }
        .ch-empty-ico { width: 52px; height: 52px; background: #e0f2fe; border: 2px dashed #bae6fd; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto .8rem; color: #38bdf8; font-size: 1.3rem; }
        .ch-empty-t { font-weight: 600; color: #64748b; font-size: .9rem; }
        .ch-empty-s { font-size: .78rem; color: #94a3b8; margin-top: .25rem; }

        /* PAGINACIÓN */
        .ch-pag-bar { display: flex; align-items: center; justify-content: space-between; padding: .7rem 1rem; border-top: 1px solid #e2edf8; flex-wrap: wrap; gap: .5rem; }
        .ch-pag-info { font-size: .77rem; color: #94a3b8; }
        .ch-pag-info strong { color: #64748b; }
        .ch-pag-links { display: flex; align-items: center; gap: .3rem; }
        .ch-pag-btn { min-width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: .78rem; font-weight: 600; border: 1px solid #e2edf8; background: #fff; color: #64748b; cursor: pointer; transition: all .15s; padding: 0 .5rem; font-family: 'DM Sans', sans-serif; }
        .ch-pag-btn:hover { border-color: #38bdf8; color: #0284c7; background: #f0f9ff; }
        .ch-pag-active { background: #0284c7 !important; border-color: #0284c7 !important; color: #fff !important; }
        .ch-pag-btn:disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }

        /* HEADER SIMILAR CARD */
        .card-header {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem 0.5rem 0 0;
            margin-bottom: 1rem;
        }
        .card-header h2 { font-size: 2rem; color: #1e63b8; font-weight: 600; }
    </style>

    <div class="ch-wrap">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
                <i class="fas fa-file-invoice-dollar me-2"></i> Mis Facturas
            </h2>
        </div>

        <div class="ch-filters">
            <div class="ch-fg">
                <i class="fas fa-search ch-fg-ico"></i>
                <input type="text" id="ch-search" placeholder="Buscar por número, origen, destino..." autocomplete="off">
            </div>
            <div class="ch-fg">
                <i class="fas fa-calendar ch-fg-ico"></i>
                <input type="date" id="ch-fdate">
            </div>
            <div class="ch-fg">
                <i class="fas fa-filter ch-fg-ico"></i>
                <select id="ch-festado">
                    <option value="">Todos</option>
                    <option value="emitida">Emitida</option>
                    <option value="anulada">Anulada</option>
                    <option value="duplicada">Duplicada</option>
                </select>
            </div>
            <button class="ch-btn-clear" id="ch-clear"><i class="fas fa-times"></i> Limpiar</button>
            <span class="ch-filter-count" id="ch-fcount"></span>
        </div>

        <div class="ch-table-wrap">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Número</th>
                    <th>Fecha Emisión</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Fecha Viaje</th>
                    <th>Asiento</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody id="ch-body">
                @forelse($facturas as $key => $factura)
                    <tr data-search="{{ strtolower($factura->numero_factura.' '.$factura->reserva->viaje->origen->nombre ?? '' .' '.$factura->reserva->viaje->destino->nombre ?? '') }}">
                        <td><div class="ch-num">{{ $key + 1 }}</div></td>
                        <td>{{ $factura->numero_factura }}</td>
                        <td>{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</td>
                        <td>{{ $factura->reserva->viaje->origen->nombre ?? '-' }}</td>
                        <td>{{ $factura->reserva->viaje->destino->nombre ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($factura->reserva->viaje->fecha_hora_salida)->format('d/m/Y H:i') }}</td>
                        <td>#{{ $factura->reserva->asiento->numero_asiento ?? '-' }}</td>
                        <td>L. {{ number_format($factura->monto_total,2) }}</td>
                        <td>
                        <span class="ch-route {{ $factura->estado === 'emitida' ? 'bg-success' : ($factura->estado === 'anulada' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($factura->estado) }}
                        </span>
                        </td>
                        <td>
                            <a href="{{ route('cliente.facturas.pdf', $factura->id) }}" target="_blank" class="ch-btn-clear"><i class="fas fa-download"></i></a>
                            <button onclick="enviarPorCorreo({{ $factura->id }})" class="ch-btn-clear"><i class="fas fa-envelope"></i></button>
                            <a href="{{ route('cliente.facturas.ver', $factura->id) }}" class="ch-btn-clear"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr class="ch-empty">
                        <td colspan="10">
                            <div class="ch-empty-ico"><i class="fas fa-inbox"></i></div>
                            <div class="ch-empty-t">No tienes facturas disponibles</div>
                            <div class="ch-empty-s">Realiza una búsqueda o consulta con tu administrador.</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="ch-pag-bar">
                <span class="ch-pag-info">Mostrando <strong id="ch-pfrom">1</strong>–<strong id="ch-pto">10</strong> de <strong id="ch-ptotal">{{ $facturas->count() }}</strong></span>
                <div class="ch-pag-links" id="ch-plinks"></div>
            </div>
        </div>

    </div>

@endsection
