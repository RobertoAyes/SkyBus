@extends('layouts.layoutadmin')

@section('title', 'Itinerarios de Choferes')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

        :root {
            --bg-base:        #f0f7ff;
            --bg-card:        #ffffff;
            --bg-hover:       #f5faff;
            --bg-header:      #e8f3fd;
            --border:         #d0e8f8;
            --border-accent:  #a8d4f0;
            --celeste-1:      #3a9fd6;
            --celeste-2:      #5bb8e8;
            --celeste-light:  #e0f3fc;
            --celeste-soft:   #b8dff5;
            --text-primary:   #1a3a52;
            --text-secondary: #3a6a8a;
            --text-muted:     #7aaac8;
            --success-bg:     #e8faf3;
            --success-border: #a7e8cc;
            --success-text:   #1a7a4a;
            --danger-bg:      #fff0f0;
            --danger-border:  #fcc;
            --danger-text:    #c0392b;
        }

        .itinerario-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: var(--bg-base);
            padding: 2.5rem 2rem;
        }

        .page-inner {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* ── Header ── */
        .page-header {
            display: flex; align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap; gap: 1rem;
        }
        .page-label {
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.16em; text-transform: uppercase;
            color: var(--celeste-1); margin-bottom: 0.3rem;
            display: flex; align-items: center; gap: 0.45rem;
        }
        .page-label::before {
            content: ''; display: inline-block;
            width: 18px; height: 2px;
            background: var(--celeste-1); border-radius: 2px;
        }
        .page-title {
            font-size: 2.1rem; font-weight: 800;
            color: var(--text-primary); line-height: 1.1;
            letter-spacing: -0.03em;
        }
        .page-title span { color: var(--celeste-1); }

        .btn-assign {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: linear-gradient(135deg, var(--celeste-1), var(--celeste-2));
            color: #fff; border: none;
            padding: 0.72rem 1.45rem; border-radius: 11px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600; font-size: 0.88rem;
            text-decoration: none; white-space: nowrap;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(58,159,214,0.25);
        }
        .btn-assign:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(58,159,214,0.38);
            color: #fff;
        }

        /* ── Alert ── */
        .alert-success-custom {
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
            border-radius: 11px; padding: 0.85rem 1.2rem;
            margin-bottom: 1.5rem;
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.88rem; font-weight: 500;
            animation: slideDown 0.35s ease;
        }
        @keyframes slideDown {
            from { opacity:0; transform:translateY(-8px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* ── Stats ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
            gap: 1rem; margin-bottom: 1.8rem;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px; padding: 1.2rem 1.4rem;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(58,159,214,0.06);
        }
        .stat-card:hover {
            border-color: var(--border-accent);
            box-shadow: 0 4px 16px rgba(58,159,214,0.12);
            transform: translateY(-2px);
        }
        .stat-icon {
            width: 36px; height: 36px; border-radius: 9px;
            background: var(--celeste-light);
            display: flex; align-items: center; justify-content: center;
            color: var(--celeste-1); font-size: 0.95rem;
            margin-bottom: 0.75rem;
        }
        .stat-value {
            font-size: 1.85rem; font-weight: 800;
            color: var(--text-primary); line-height: 1;
            font-family: 'JetBrains Mono', monospace;
        }
        .stat-label {
            font-size: 0.73rem; color: var(--text-muted);
            margin-top: 0.3rem; font-weight: 500;
            text-transform: uppercase; letter-spacing: 0.05em;
        }

        /* ── Table card ── */
        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px; overflow: hidden;
            box-shadow: 0 4px 24px rgba(58,159,214,0.08);
        }
        .table-card table { width:100%; border-collapse:collapse; font-size:0.9rem; }

        .table-card thead {
            background: var(--bg-header);
            border-bottom: 1px solid var(--border-accent);
        }
        .table-card thead th {
            padding: 0.95rem 1.25rem;
            color: var(--celeste-1); font-weight: 700;
            font-size: 0.76rem; letter-spacing: 0.07em;
            text-transform: uppercase; white-space: nowrap;
        }

        .table-card tbody tr {
            border-bottom: 1px solid #edf5fb;
            transition: background 0.15s;
            animation: fadeRow 0.4s ease both;
        }
        .table-card tbody tr:nth-child(1){animation-delay:.05s}
        .table-card tbody tr:nth-child(2){animation-delay:.10s}
        .table-card tbody tr:nth-child(3){animation-delay:.15s}
        .table-card tbody tr:nth-child(4){animation-delay:.20s}
        .table-card tbody tr:nth-child(5){animation-delay:.25s}
        @keyframes fadeRow {
            from { opacity:0; transform:translateX(-8px); }
            to   { opacity:1; transform:translateX(0); }
        }
        .table-card tbody tr:hover { background: var(--bg-hover); }
        .table-card tbody tr:last-child { border-bottom: none; }
        .table-card td { padding: 1rem 1.25rem; color: var(--text-secondary); vertical-align: middle; }

        /* Driver cell */
        .driver-cell { display:flex; align-items:center; gap:0.75rem; }
        .driver-avatar {
            width: 36px; height: 36px; border-radius: 9px;
            background: linear-gradient(135deg, var(--celeste-1), var(--celeste-2));
            display:flex; align-items:center; justify-content:center;
            font-size: 0.82rem; font-weight: 700; color:#fff; flex-shrink:0;
        }
        .driver-name { font-weight: 600; color: var(--text-primary); }

        /* Route badge */
        .route-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--celeste-light);
            border: 1px solid var(--celeste-soft);
            color: var(--celeste-1);
            padding: 0.3rem 0.8rem; border-radius: 30px;
            font-size: 0.82rem; font-weight: 600; white-space: nowrap;
        }
        .route-badge i { font-size: 0.68rem; opacity: 0.7; }

        .date-mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.82rem; color: var(--text-muted);
        }

        /* Delete button */
        .btn-delete {
            display: inline-flex; align-items: center; gap: 0.35rem;
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger-text);
            padding: 0.38rem 0.9rem; border-radius: 8px;
            font-size: 0.8rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-delete:hover {
            background: #ffe0e0;
            border-color: #e88;
            transform: scale(1.02);
        }

        /* Empty */
        .empty-state { text-align:center; padding:4rem 2rem; }
        .empty-icon {
            width:68px; height:68px;
            background: var(--celeste-light);
            border: 2px dashed var(--celeste-soft);
            border-radius: 18px;
            display:flex; align-items:center; justify-content:center;
            margin: 0 auto 1.1rem;
            font-size: 1.6rem; color: var(--celeste-1); opacity: 0.7;
        }
        .empty-title { font-size:1rem; font-weight:700; color: var(--text-muted); margin-bottom:0.25rem; }
        .empty-sub   { font-size:0.82rem; color: var(--text-muted); opacity: 0.7; }

        /* Modal */
        .modal-content {
            background: #fff !important;
            border: 1px solid var(--border) !important;
            border-radius: 16px !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: 0 20px 60px rgba(58,159,214,0.15) !important;
        }
        .modal-header {
            border-bottom: 1px solid var(--border) !important;
            padding: 1.2rem 1.5rem !important;
            background: var(--bg-header) !important;
            border-radius: 16px 16px 0 0 !important;
        }
        .modal-title { color: var(--text-primary) !important; font-weight: 700 !important; font-size: 0.98rem !important; }
        .modal-body {
            color: var(--text-secondary) !important;
            font-size: 0.88rem !important;
            padding: 1.35rem 1.5rem !important;
            line-height: 1.65;
        }
        .modal-body strong { color: var(--text-primary); }
        .modal-footer { border-top: 1px solid var(--border) !important; padding: 1rem 1.5rem !important; }

        .btn-modal-cancel {
            background: #fff; border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 0.48rem 1.1rem; border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600; font-size: 0.84rem;
            transition: all 0.2s; cursor: pointer;
        }
        .btn-modal-cancel:hover { background: var(--bg-hover); border-color: var(--border-accent); color: var(--text-secondary); }

        .btn-modal-delete {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
            border: none; color: #fff;
            padding: 0.48rem 1.1rem; border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600; font-size: 0.84rem;
            transition: all 0.2s; cursor: pointer;
            box-shadow: 0 4px 12px rgba(192,57,43,0.22);
        }
        .btn-modal-delete:hover { box-shadow: 0 6px 18px rgba(192,57,43,0.35); transform: translateY(-1px); }
    </style>

    <div class="itinerario-wrapper">
        <div class="page-inner">

            <div class="page-header">
                <div>
                    <h1 class="page-title">Itinerarios <span>Asignados</span></h1>
                </div>
                <a href="{{ route('itinerarioChofer.create') }}" class="btn-assign">
                    <i class="fas fa-plus"></i> Asignar Itinerario
                </a>
            </div>

            @if(session('success'))
                <div class="alert-success-custom">
                    <i class="fas fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-value">{{ $itinerarios->count() }}</div>
                    <div class="stat-label">Total itinerarios</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
                    <div class="stat-value">{{ $itinerarios->unique('chofer_id')->count() }}</div>
                    <div class="stat-label">Choferes activos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-route"></i></div>
                    <div class="stat-value">{{ $itinerarios->unique('ruta_id')->count() }}</div>
                    <div class="stat-label">Rutas cubiertas</div>
                </div>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                    <tr>
                        <th><i class="fas fa-user me-1"></i> Chofer</th>
                        <th><i class="fas fa-route me-1"></i> Ruta</th>
                        <th><i class="fas fa-clock me-1"></i> Fecha y Hora</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($itinerarios as $itinerario)
                        <tr>
                            <td>
                                <div class="driver-cell">
                                    <div class="driver-avatar">{{ strtoupper(substr($itinerario->chofer->name ?? 'S', 0, 1)) }}</div>
                                    <span class="driver-name">{{ $itinerario->chofer->name ?? 'Sin chofer' }}</span>
                                </div>
                            </td>
                            <td>
                            <span class="route-badge">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $itinerario->ruta->origen ?? 'Sin origen' }}
                                <i class="fas fa-arrow-right"></i>
                                {{ $itinerario->ruta->destino ?? 'Sin destino' }}
                            </span>
                            </td>
                            <td>
                            <span class="date-mono">
                                {{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y H:i') : '—' }}
                            </span>
                            </td>
                            <td style="text-align:center;">
                                <button type="button" class="btn-delete" data-bs-toggle="modal" data-bs-target="#eliminarModal{{ $itinerario->id }}">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="eliminarModal{{ $itinerario->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="fas fa-exclamation-triangle me-2" style="color:#e74c3c;"></i>
                                            Confirmar eliminación
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de eliminar el itinerario de
                                        <strong>{{ $itinerario->chofer->name ?? 'Sin chofer' }}</strong>
                                        en la ruta
                                        <strong>{{ $itinerario->ruta->origen ?? '' }} → {{ $itinerario->ruta->destino ?? '' }}</strong>
                                        programado para
                                        <strong>{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}</strong>?
                                        <br><br>
                                        <span style="font-size:0.8rem; color:#aac;">Esta acción no se puede deshacer.</span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('itinerarioChofer.destroy', $itinerario->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modal-delete">
                                                <i class="fas fa-trash-alt me-1"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-calendar-times"></i></div>
                                    <div class="empty-title">No hay itinerarios asignados</div>
                                    <div class="empty-sub">Empieza asignando un itinerario a un chofer</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
