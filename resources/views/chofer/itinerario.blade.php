@extends('layouts.layoutchofer')

@section('title', 'Mi Itinerario')

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

        .chofer-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: var(--bg-base);
            padding: 2.5rem 2rem;
        }

        .page-inner {
            max-width: 860px;
            margin: 0 auto;
        }

        /* ── Top greeting banner ── */
        .greeting-banner {
            background: linear-gradient(135deg, var(--celeste-1) 0%, var(--celeste-2) 100%);
            border-radius: 20px;
            padding: 2rem 2.2rem;
            margin-bottom: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            box-shadow: 0 8px 28px rgba(58,159,214,0.25);
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
        }
        /* decorative circles */
        .greeting-banner::before {
            content: '';
            position: absolute; top: -40px; right: -40px;
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            pointer-events: none;
        }
        .greeting-banner::after {
            content: '';
            position: absolute; bottom: -50px; right: 80px;
            width: 120px; height: 120px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
            pointer-events: none;
        }

        .greeting-text { position: relative; z-index: 1; }
        .greeting-label {
            font-size: 0.78rem; font-weight: 700;
            letter-spacing: 0.14em; text-transform: uppercase;
            color: rgba(255,255,255,0.75); margin-bottom: 0.3rem;
        }
        .greeting-title {
            font-size: 1.7rem; font-weight: 800;
            color: #fff; line-height: 1.15;
            letter-spacing: -0.02em;
        }
        .greeting-sub {
            font-size: 0.85rem; color: rgba(255,255,255,0.75);
            margin-top: 0.3rem;
        }

        .greeting-icon-wrap {
            position: relative; z-index: 1;
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.18);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #fff;
            flex-shrink: 0;
            backdrop-filter: blur(4px);
        }

        /* ── Summary chips ── */
        .summary-chips {
            display: flex; gap: 1rem;
            margin-bottom: 1.8rem;
            flex-wrap: wrap;
        }
        .chip {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.4rem;
            display: flex; align-items: center; gap: 0.85rem;
            flex: 1; min-width: 150px;
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
            background: var(--celeste-light);
            display: flex; align-items: center; justify-content: center;
            color: var(--celeste-1); font-size: 1rem; flex-shrink: 0;
        }
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

        /* ── Section title ── */
        .section-title {
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.15em; text-transform: uppercase;
            color: var(--celeste-1);
            display: flex; align-items: center; gap: 0.45rem;
            margin-bottom: 1rem;
        }
        .section-title::before {
            content: ''; display: inline-block;
            width: 16px; height: 2px;
            background: var(--celeste-1); border-radius: 2px;
        }

        /* ── Itinerary cards (mobile-friendly) ── */
        .itinerary-list {
            display: flex; flex-direction: column; gap: 0.85rem;
        }

        .itinerary-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.2rem 1.4rem;
            display: flex; align-items: center;
            gap: 1.2rem;
            box-shadow: 0 2px 8px rgba(58,159,214,0.05);
            transition: all 0.22s;
            animation: cardIn 0.4s ease both;
        }
        .itinerary-card:nth-child(1){animation-delay:.05s}
        .itinerary-card:nth-child(2){animation-delay:.10s}
        .itinerary-card:nth-child(3){animation-delay:.15s}
        .itinerary-card:nth-child(4){animation-delay:.20s}
        @keyframes cardIn {
            from { opacity:0; transform:translateY(10px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .itinerary-card:hover {
            border-color: var(--border-accent);
            box-shadow: 0 6px 20px rgba(58,159,214,0.13);
            transform: translateY(-2px);
        }

        /* Number badge */
        .card-number {
            width: 40px; height: 40px; border-radius: 12px;
            background: var(--celeste-light);
            border: 1px solid var(--celeste-soft);
            display: flex; align-items: center; justify-content: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem; font-weight: 700;
            color: var(--celeste-1); flex-shrink: 0;
        }

        /* Route info */
        .card-route { flex: 1; min-width: 0; }
        .route-main {
            display: flex; align-items: center; gap: 0.5rem;
            flex-wrap: wrap;
        }
        .route-origin, .route-dest {
            font-weight: 700; color: var(--text-primary);
            font-size: 0.95rem; white-space: nowrap;
        }
        .route-arrow {
            display: flex; align-items: center; justify-content: center;
            width: 26px; height: 26px; border-radius: 50%;
            background: var(--celeste-light);
            color: var(--celeste-1); font-size: 0.65rem;
            flex-shrink: 0;
        }
        .route-label {
            font-size: 0.72rem; color: var(--text-muted);
            font-weight: 500; margin-top: 0.2rem;
            text-transform: uppercase; letter-spacing: 0.05em;
        }

        /* Date + time pills */
        .card-meta {
            display: flex; flex-direction: column;
            align-items: flex-end; gap: 0.4rem; flex-shrink: 0;
        }
        .meta-pill {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.28rem 0.75rem; border-radius: 30px;
            font-size: 0.8rem; font-weight: 600; white-space: nowrap;
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
            padding: 4rem 2rem;
            text-align: center;
        }
        .empty-icon-wrap {
            width: 72px; height: 72px;
            background: var(--celeste-light);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 1.9rem; color: var(--celeste-1);
        }
        .empty-title {
            font-size: 1.1rem; font-weight: 700;
            color: var(--text-secondary); margin-bottom: 0.4rem;
        }
        .empty-sub { font-size: 0.85rem; color: var(--text-muted); }

        /* ── Responsive ── */
        @media (max-width: 540px) {
            .greeting-banner { padding: 1.5rem 1.4rem; }
            .greeting-title  { font-size: 1.35rem; }
            .card-meta       { flex-direction: row; align-items: center; }
            .itinerary-card  { flex-wrap: wrap; }
        }
    </style>

    <div class="chofer-wrapper">
        <div class="page-inner">

            <!-- Greeting banner -->
            <div class="greeting-banner">
                <div class="greeting-text">
                    <div class="greeting-title">Mi Itinerario Asignado</div>
                    <div class="greeting-sub">Aquí puedes ver todas tus rutas programadas.</div>
                </div>
                <div class="greeting-icon-wrap">
                    <i class="fas fa-route"></i>
                </div>
            </div>

            <!-- Summary chips -->
            @if(!$itinerarios->isEmpty())
                <div class="summary-chips">
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <div class="chip-value">{{ $itinerarios->count() }}</div>
                            <div class="chip-label">Viajes asignados</div>
                        </div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-map-signs"></i></div>
                        <div>
                            <div class="chip-value">{{ $itinerarios->unique('ruta_id')->count() }}</div>
                            <div class="chip-label">Rutas distintas</div>
                        </div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-calendar-day"></i></div>
                        <div>
                            <div class="chip-value">
                                {{ $itinerarios->filter(fn($i) => $i->fecha && \Carbon\Carbon::parse($i->fecha)->isToday())->count() }}
                            </div>
                            <div class="chip-label">Viajes hoy</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Section label -->
            <div class="section-title">
                <span>Próximos viajes</span>
            </div>

            <!-- Content -->
            @if($itinerarios->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon-wrap">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <div class="empty-title">Sin itinerarios por ahora</div>
                    <div class="empty-sub">No tienes rutas asignadas actualmente.<br>Consulta con tu administrador.</div>
                </div>
            @else
                <div class="itinerary-list">
                    @foreach($itinerarios as $index => $itinerario)
                        <div class="itinerary-card">

                            <!-- Number -->
                            <div class="card-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                            <!-- Route -->
                            <div class="card-route">
                                <div class="route-main">
                                    <span class="route-origin">{{ $itinerario->ruta->origen ?? 'Sin origen' }}</span>
                                    <div class="route-arrow"><i class="fas fa-arrow-right"></i></div>
                                    <span class="route-dest">{{ $itinerario->ruta->destino ?? 'Sin destino' }}</span>
                                </div>
                                <div class="route-label"><i class="fas fa-route me-1"></i>Ruta asignada</div>
                            </div>

                            <!-- Date + Time -->
                            <div class="card-meta">
                        <span class="meta-pill date">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y') : 'Sin fecha' }}
                        </span>
                                <span class="meta-pill time">
                            <i class="fas fa-clock"></i>
                            {{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('H:i') : '--:--' }}
                        </span>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

@endsection
