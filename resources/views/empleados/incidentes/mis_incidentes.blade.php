@extends('layouts.layoutchofer')

@section('contenido')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

        :root {
            --bg-base:       #f0f7ff;
            --bg-card:       #ffffff;
            --bg-hover:      #f5faff;
            --bg-header:     #e8f3fd;
            --border:        #d0e8f8;
            --border-accent: #a8d4f0;
            --celeste-1:     #3a9fd6;
            --celeste-2:     #5bb8e8;
            --celeste-light: #e0f3fc;
            --celeste-soft:  #b8dff5;
            --text-primary:  #1a3a52;
            --text-secondary:#3a6a8a;
            --text-muted:    #7aaac8;
        }

        .incidentes-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: var(--bg-base);
            padding: 2.5rem 2rem;
        }

        .page-inner {
            max-width: 960px;
            margin: 0 auto;
        }

        /* ── Banner ── */
        .greeting-banner {
            background: linear-gradient(135deg, #3a9fd6 0%, #5bb8e8 100%);
            border-radius: 20px;
            padding: 2rem 2.2rem;
            margin-bottom: 1.8rem;
            display: flex; align-items: center;
            justify-content: space-between;
            gap: 1.5rem; flex-wrap: wrap;
            box-shadow: 0 8px 28px rgba(58,159,214,0.22);
            position: relative; overflow: hidden;
        }
        .greeting-banner::before {
            content: '';
            position: absolute; top: -40px; right: -40px;
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%; pointer-events: none;
        }
        .greeting-banner::after {
            content: '';
            position: absolute; bottom: -50px; right: 80px;
            width: 120px; height: 120px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%; pointer-events: none;
        }
        .greeting-text { position: relative; z-index: 1; }
        .greeting-label {
            font-size: 0.78rem; font-weight: 700;
            letter-spacing: 0.14em; text-transform: uppercase;
            color: rgba(255,255,255,0.75); margin-bottom: 0.3rem;
        }
        .greeting-title {
            font-size: 1.7rem; font-weight: 800;
            color: #fff; line-height: 1.15; letter-spacing: -0.02em;
        }
        .greeting-sub {
            font-size: 0.85rem; color: rgba(255,255,255,0.75); margin-top: 0.3rem;
        }
        .greeting-icon-wrap {
            position: relative; z-index: 1;
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.18);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #fff; flex-shrink: 0;
        }

        /* ── Summary chips ── */
        .summary-chips {
            display: flex; gap: 1rem;
            margin-bottom: 1.8rem; flex-wrap: wrap;
        }
        .chip {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.4rem;
            display: flex; align-items: center; gap: 0.85rem;
            flex: 1; min-width: 140px;
            box-shadow: 0 2px 8px rgba(58,159,214,0.06);
            transition: all 0.2s;
        }
        .chip:hover {
            border-color: var(--border-accent);
            box-shadow: 0 4px 16px rgba(58,159,214,0.12);
            transform: translateY(-2px);
        }
        .chip-icon {
            width: 40px; height: 40px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .chip-icon.orange { background: #e0f3fc; color: #3a9fd6; }
        .chip-icon.blue   { background: var(--celeste-light); color: var(--celeste-1); }
        .chip-icon.red    { background: #fff0f0; color: #c0392b; }
        .chip-value {
            font-size: 1.5rem; font-weight: 800;
            color: var(--text-primary); line-height: 1;
            font-family: 'JetBrains Mono', monospace;
        }
        .chip-label {
            font-size: 0.72rem; color: var(--text-muted);
            font-weight: 500; text-transform: uppercase;
            letter-spacing: 0.05em; margin-top: 0.15rem;
        }

        /* ── Toolbar ── */
        .toolbar {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;
        }
        .section-title {
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.15em; text-transform: uppercase;
            color: var(--celeste-1);
            display: flex; align-items: center; gap: 0.45rem;
        }
        .section-title::before {
            content: ''; display: inline-block;
            width: 16px; height: 2px;
            background: var(--celeste-1); border-radius: 2px;
        }
        .btn-print {
            display: inline-flex; align-items: center; gap: 0.45rem;
            background: var(--bg-card);
            border: 1px solid var(--border-accent);
            color: var(--celeste-1);
            padding: 0.55rem 1.2rem; border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600; font-size: 0.84rem;
            cursor: pointer; transition: all 0.22s;
            box-shadow: 0 2px 8px rgba(58,159,214,0.07);
        }
        .btn-print:hover {
            background: var(--celeste-light);
            border-color: var(--celeste-soft);
            box-shadow: 0 4px 14px rgba(58,159,214,0.15);
            transform: translateY(-1px);
        }

        /* ── Incident cards ── */
        .incidents-list {
            display: flex; flex-direction: column; gap: 0.85rem;
        }

        .incident-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.2rem 1.5rem;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 1.2rem;
            box-shadow: 0 2px 8px rgba(58,159,214,0.05);
            transition: all 0.22s;
            animation: cardIn 0.4s ease both;
            border-left: 4px solid transparent;
        }
        .incident-card:nth-child(1){animation-delay:.05s}
        .incident-card:nth-child(2){animation-delay:.10s}
        .incident-card:nth-child(3){animation-delay:.15s}
        .incident-card:nth-child(4){animation-delay:.20s}
        .incident-card:nth-child(5){animation-delay:.25s}
        @keyframes cardIn {
            from { opacity:0; transform:translateY(10px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .incident-card:hover {
            border-color: var(--border-accent);
            box-shadow: 0 6px 20px rgba(58,159,214,0.11);
            transform: translateY(-2px);
        }

        /* Tipo color accent */
        .incident-card.tipo-accidente  { border-left-color: #e74c3c; }
        .incident-card.tipo-mecanico   { border-left-color: #e67e22; }
        .incident-card.tipo-trafico    { border-left-color: #f1c40f; }
        .incident-card.tipo-otro       { border-left-color: var(--celeste-1); }

        /* Left: number + tipo badge */
        .card-left { display:flex; flex-direction:column; align-items:center; gap:0.5rem; }
        .card-number {
            width: 38px; height: 38px; border-radius: 11px;
            background: var(--celeste-light);
            border: 1px solid var(--celeste-soft);
            display: flex; align-items: center; justify-content: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.88rem; font-weight: 700; color: var(--celeste-1);
        }

        /* Center: main info */
        .card-body-content { min-width: 0; }
        .card-top-row {
            display: flex; align-items: center; gap: 0.6rem;
            flex-wrap: wrap; margin-bottom: 0.45rem;
        }
        .tipo-badge {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.22rem 0.7rem; border-radius: 30px;
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
            white-space: nowrap;
        }
        .tipo-badge.accidente { background:#ffeaea; color:#c0392b; border:1px solid #f5c2c2; }
        .tipo-badge.mecanico  { background:#fff3e0; color:#b34700; border:1px solid #ffd5a8; }
        .tipo-badge.trafico   { background:#fffde7; color:#8a6d00; border:1px solid #ffe082; }
        .tipo-badge.otro      { background:var(--celeste-light); color:var(--celeste-1); border:1px solid var(--celeste-soft); }

        .card-bus {
            font-size: 0.8rem; font-weight: 600;
            color: var(--text-muted);
            display: flex; align-items: center; gap: 0.3rem;
        }
        .card-bus i { font-size: 0.72rem; }

        .card-desc {
            font-size: 0.88rem; color: var(--text-secondary);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-route-row {
            display: flex; align-items: center; gap: 0.45rem;
            margin-top: 0.4rem;
        }
        .route-pill {
            display: inline-flex; align-items: center; gap: 0.35rem;
            background: var(--bg-header);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            padding: 0.22rem 0.7rem; border-radius: 30px;
            font-size: 0.78rem; font-weight: 500;
        }
        .route-pill i { font-size: 0.68rem; color: var(--celeste-1); }

        /* Right: date/time */
        .card-meta {
            display: flex; flex-direction: column;
            align-items: flex-end; gap: 0.4rem; flex-shrink: 0;
        }
        .meta-pill {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.28rem 0.75rem; border-radius: 30px;
            font-size: 0.79rem; font-weight: 600; white-space: nowrap;
        }
        .meta-pill.date {
            background: var(--bg-header);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }
        .meta-pill.time {
            background: var(--celeste-light);
            border: 1px solid var(--celeste-soft);
            color: var(--celeste-1);
            font-family: 'JetBrains Mono', monospace;
        }
        .meta-pill i { font-size: 0.7rem; opacity: 0.75; }

        /* ── Empty state ── */
        .empty-state {
            background: var(--bg-card);
            border: 2px dashed var(--celeste-soft);
            border-radius: 20px;
            padding: 4rem 2rem; text-align: center;
        }
        .empty-icon-wrap {
            width: 72px; height: 72px;
            background: var(--celeste-light);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 1.9rem; color: var(--celeste-1);
        }
        .empty-title { font-size:1.05rem; font-weight:700; color:var(--text-secondary); margin-bottom:0.35rem; }
        .empty-sub   { font-size:0.84rem; color:var(--text-muted); }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .incident-card { grid-template-columns: auto 1fr; }
            .card-meta { flex-direction: row; flex-wrap: wrap; justify-content: flex-start; }
            .card-left { flex-direction: row; }
        }

        /* ── Print ── */
        @media print {
            .greeting-banner, .summary-chips, .btn-print, .toolbar { display: none !important; }
            .incidentes-wrapper { background: #fff; padding: 0; }
            .incident-card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                break-inside: avoid;
                margin-bottom: 0.5rem;
            }
            .incident-card:hover { transform: none !important; }
        }
    </style>

    <div class="incidentes-wrapper">
        <div class="page-inner">

            <!-- Banner -->
            <div class="greeting-banner">
                <div class="greeting-text">
                    <div class="greeting-title">Mis Incidentes Registrados</div>
                    <div class="greeting-sub">Historial completo de incidencias reportadas.</div>
                </div>
                <div class="greeting-icon-wrap">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>

            @if(!$incidentes->isEmpty())
                <!-- Chips -->
                <div class="summary-chips">
                    <div class="chip">
                        <div class="chip-icon orange"><i class="fas fa-clipboard-list"></i></div>
                        <div>
                            <div class="chip-value">{{ $incidentes->count() }}</div>
                            <div class="chip-label">Total incidentes</div>
                        </div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon blue"><i class="fas fa-bus"></i></div>
                        <div>
                            <div class="chip-value">{{ $incidentes->unique('bus_numero')->count() }}</div>
                            <div class="chip-label">Buses involucrados</div>
                        </div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon red"><i class="fas fa-car-crash"></i></div>
                        <div>
                            <div class="chip-value">{{ $incidentes->where('tipo_incidente', 'Accidente')->count() }}</div>
                            <div class="chip-label">Accidentes</div>
                        </div>
                    </div>
                </div>

                <!-- Toolbar -->
                <div class="toolbar">
                    <div class="section-title">Historial de incidencias</div>
                    <button onclick="window.print()" class="btn-print">
                        <i class="fas fa-print"></i> Imprimir historial
                    </button>
                </div>

                <!-- Cards -->
                <div class="incidents-list">
                    @foreach($incidentes as $index => $incidente)
                        @php
                            $tipo = strtolower($incidente->tipo_incidente ?? 'otro');
                            $tipoClass = str_contains($tipo, 'accidente') ? 'accidente'
                                : (str_contains($tipo, 'mec') ? 'mecanico'
                                : (str_contains($tipo, 'tr') ? 'trafico' : 'otro'));
                        @endphp
                        <div class="incident-card tipo-{{ $tipoClass }}">

                            <!-- Left -->
                            <div class="card-left">
                                <div class="card-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            </div>

                            <!-- Center -->
                            <div class="card-body-content">
                                <div class="card-top-row">
                        <span class="tipo-badge {{ $tipoClass }}">
                            <i class="fas fa-tag"></i>
                            {{ $incidente->tipo_incidente ?? 'Otro' }}
                        </span>
                                    <span class="card-bus">
                            <i class="fas fa-bus"></i> Bus #{{ $incidente->bus_numero ?? '—' }}
                        </span>
                                </div>

                                <div class="card-desc">{{ $incidente->descripcion ?? 'Sin descripción.' }}</div>

                                @if($incidente->ruta)
                                    <div class="card-route-row">
                        <span class="route-pill">
                            <i class="fas fa-route"></i>{{ $incidente->ruta }}
                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Right: date + time -->
                            <div class="card-meta">
                    <span class="meta-pill date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $incidente->fecha_hora ? \Carbon\Carbon::parse($incidente->fecha_hora)->format('d/m/Y') : '—' }}
                    </span>
                                <span class="meta-pill time">
                        <i class="fas fa-clock"></i>
                        {{ $incidente->fecha_hora ? \Carbon\Carbon::parse($incidente->fecha_hora)->format('H:i') : '--:--' }}
                    </span>
                            </div>

                        </div>
                    @endforeach
                </div>

            @else
                <div class="empty-state">
                    <div class="empty-icon-wrap">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="empty-title">Sin incidentes registrados</div>
                    <div class="empty-sub">No tienes incidencias reportadas actualmente.<br>¡Todo marcha bien!</div>
                </div>
            @endif

        </div>
    </div>

@endsection
