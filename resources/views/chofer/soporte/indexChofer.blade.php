@extends('layouts.layoutchofer')

@section('title', 'Mis Solicitudes de Soporte')

@section('contenido')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .sop-wrap { font-family: 'DM Sans', sans-serif; background: #f0f9ff; min-height: 100vh; padding: 1.75rem 1.5rem; }

        .sop-greeting-banner { background: linear-gradient(135deg,#3a9fd6 0%,#5bb8e8 100%); border-radius: 20px; padding: 1.8rem 2rem; margin-bottom: 1.25rem; color: #fff; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 8px 28px rgba(58,159,214,0.25); }
        .sop-btn-new { display: inline-flex; align-items: center; gap: .4rem; background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.4); padding: .5rem 1.1rem; border-radius: 8px; font-size: .82rem; font-weight: 600; text-decoration: none; transition: background .18s; }
        .sop-btn-new:hover { background: rgba(255,255,255,0.35); color: #fff; }
        .sop-btn-new i { font-size: .75rem; }

        .sop-flash { display: flex; align-items: center; gap: .5rem; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: .65rem 1rem; border-radius: 8px; font-size: .83rem; font-weight: 500; margin-bottom: 1rem; }

        .sop-stats { display: flex; gap: .75rem; margin-bottom: 1.1rem; flex-wrap: wrap; }
        .sop-stat { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .65rem 1rem; display: flex; align-items: center; gap: .7rem; flex: 1; min-width: 120px; }
        .sop-stat-ico { width: 30px; height: 30px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; }
        .sop-stat-ico.blue   { background: #e0f2fe; color: #0284c7; }
        .sop-stat-ico.amber  { background: #fffbeb; color: #d97706; }
        .sop-stat-ico.cyan   { background: #ecfeff; color: #0891b2; }
        .sop-stat-ico.green  { background: #f0fdf4; color: #16a34a; }
        .sop-stat-num { font-family: 'DM Mono', monospace; font-size: 1.35rem; font-weight: 500; color: #0c1a2e; line-height: 1; }
        .sop-stat-lbl { font-size: .7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; font-weight: 500; margin-top: .1rem; }

        .sop-filters { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .7rem 1rem; display: flex; gap: .6rem; align-items: center; flex-wrap: wrap; margin-bottom: 1rem; }
        .sop-fg { display: flex; align-items: center; gap: .35rem; flex: 1; min-width: 140px; }
        .sop-fg-ico { color: #94a3b8; font-size: .75rem; flex-shrink: 0; }
        .sop-filters input, .sop-filters select { font-family: 'DM Sans', sans-serif; font-size: .82rem; border: 1px solid #c9dff2; border-radius: 7px; padding: .38rem .65rem; color: #1e3a5f; background: #f8fbff; width: 100%; outline: none; transition: border .15s, box-shadow .15s; }
        .sop-filters input:focus, .sop-filters select:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff; }
        .sop-btn-search { font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600; color: #fff; background: #0284c7; border: none; border-radius: 7px; padding: .38rem .9rem; cursor: pointer; white-space: nowrap; transition: all .15s; display: inline-flex; align-items: center; gap: .35rem; }
        .sop-btn-search:hover { background: #0369a1; }
        .sop-btn-clear { font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600; color: #64748b; background: none; border: 1px solid #e2edf8; border-radius: 7px; padding: .38rem .8rem; cursor: pointer; white-space: nowrap; transition: all .15s; text-decoration: none; }
        .sop-btn-clear:hover { background: #f8fbff; color: #1e3a5f; border-color: #c9dff2; }

        .sop-table-wrap { background: #fff; border: 1px solid #e2edf8; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 12px rgba(14,165,233,.06); }
        .sop-table-wrap table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .sop-table-wrap thead { background: #f8fbff; border-bottom: 1px solid #c9dff2; }
        .sop-table-wrap thead th { padding: .7rem 1rem; color: #64748b; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; white-space: nowrap; }
        .sop-table-wrap tbody tr { border-bottom: 1px solid #f1f7fc; transition: background .12s; }
        .sop-table-wrap tbody tr:last-child { border-bottom: none; }
        .sop-table-wrap tbody tr:hover { background: #f0f9ff; }
        .sop-table-wrap tbody td { padding: .72rem 1rem; color: #2d5a8e; vertical-align: middle; }

        .sop-num { width: 28px; height: 28px; border-radius: 7px; background: #e0f2fe; border: 1px solid #bae6fd; display: flex; align-items: center; justify-content: center; font-family: 'DM Mono', monospace; font-size: .72rem; font-weight: 700; color: #0284c7; }

        .sop-titulo { font-weight: 600; color: #1e3a5f; font-size: .85rem; }
        .sop-desc { font-size: .8rem; color: #64748b; margin-top: .15rem; }

        .sop-estado { font-size: .78rem; font-weight: 600; }
        .sop-estado.pendiente { color: #d97706; }
        .sop-estado.en_proceso { color: #0891b2; }
        .sop-estado.resuelto { color: #16a34a; }

        .sop-date { font-family: 'DM Mono', monospace; font-size: .78rem; color: #64748b; }
        .sop-date-day { color: #1e3a5f; font-weight: 500; display: block; font-size: .82rem; }

        .sop-btn-ver { display: inline-flex; align-items: center; gap: .3rem; padding: .3rem .75rem; border-radius: 6px; font-size: .76rem; font-weight: 600; cursor: pointer; border: 1px solid #bae6fd; background: #e0f2fe; color: #0284c7; transition: all .15s; font-family: 'DM Sans', sans-serif; }
        .sop-btn-ver:hover { background: #bae6fd; transform: scale(1.02); }

        .sop-empty td { text-align: center; padding: 3.5rem 1rem; }
        .sop-empty-ico { width: 52px; height: 52px; background: #e0f2fe; border: 2px dashed #bae6fd; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto .8rem; color: #38bdf8; font-size: 1.3rem; }
        .sop-empty-t { font-weight: 600; color: #64748b; font-size: .9rem; }
        .sop-empty-s { font-size: .78rem; color: #94a3b8; margin-top: .25rem; }

        .sop-pag { padding: .7rem 1rem; border-top: 1px solid #e2edf8; display: flex; justify-content: center; }

        .sop-pag-bar { display: flex; align-items: center; justify-content: space-between; padding: .7rem 1rem; border-top: 1px solid #e2edf8; flex-wrap: wrap; gap: .5rem; }
        .sop-pag-info { font-size: .77rem; color: #94a3b8; }
        .sop-pag-info strong { color: #64748b; }
        .sop-pag-links { display: flex; align-items: center; gap: .3rem; }
        .sop-pag-btn { min-width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: .78rem; font-weight: 600; border: 1px solid #e2edf8; background: #fff; color: #64748b; cursor: pointer; transition: all .15s; padding: 0 .5rem; font-family: 'DM Sans', sans-serif; text-decoration: none; }
        .sop-pag-btn:hover { border-color: #38bdf8; color: #0284c7; background: #f0f9ff; }
        .sop-pag-active { background: #0284c7 !important; border-color: #0284c7 !important; color: #fff !important; }
        .sop-pag-btn:disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }

        .sop-modal .modal-content { font-family: 'DM Sans', sans-serif; border: 1px solid #e2edf8 !important; border-radius: 12px !important; }
        .sop-modal .modal-header { background: #f8fbff !important; border-bottom: 1px solid #c9dff2 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.25rem !important; }
        .sop-modal .modal-title { font-size: .9rem !important; font-weight: 700 !important; color: #0c1a2e !important; }
        .sop-modal .modal-body { padding: 1.25rem !important; font-size: .85rem !important; color: #2d5a8e !important; line-height: 1.65; }
        .sop-modal .modal-body strong { color: #0c1a2e; display: block; font-size: .72rem; text-transform: uppercase; letter-spacing: .06em; color: #94a3b8; margin-bottom: .2rem; margin-top: .9rem; }
        .sop-modal .modal-body strong:first-child { margin-top: 0; }
        .sop-modal .modal-body p { margin: 0; color: #1e3a5f; font-weight: 500; }
        .sop-modal .modal-footer { border-top: 1px solid #e2edf8 !important; padding: .8rem 1.25rem !important; }
        .sop-btn-mc { font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 600; padding: .42rem 1rem; border-radius: 7px; cursor: pointer; border: 1px solid #e2edf8; background: #fff; color: #64748b; transition: all .15s; }
        .sop-btn-mc:hover { background: #f8fbff; }
    </style>

    <div class="sop-wrap">

        <div class="sop-greeting-banner">
            <div>
                <div style="font-weight:800;font-size:1.5rem;">Solicitudes de Soporte</div>
                <div style="font-size:0.9rem;opacity:0.85;">Gestiona y revisa el estado de tus solicitudes.</div>
            </div>
            <div style="display:flex;align-items:center;gap:1rem;">
                <a href="{{ route('chofer.soporte.crear') }}" class="sop-btn-new">
                    <i class="fas fa-plus"></i> Nueva Solicitud
                </a>
                <i class="fas fa-bus" style="font-size:1.6rem;"></i>
            </div>
        </div>

        @if(session('success'))
            <div class="sop-flash"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <div class="sop-stats">
            <div class="sop-stat">
                <div class="sop-stat-ico blue"><i class="fas fa-headset"></i></div>
                <div>
                    <div class="sop-stat-num">{{ $solicitudes->total() }}</div>
                    <div class="sop-stat-lbl">Total</div>
                </div>
            </div>
            <div class="sop-stat">
                <div class="sop-stat-ico amber"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="sop-stat-num">{{ $solicitudes->getCollection()->where('estado','pendiente')->count() }}</div>
                    <div class="sop-stat-lbl">Pendientes</div>
                </div>
            </div>
            <div class="sop-stat">
                <div class="sop-stat-ico cyan"><i class="fas fa-spinner"></i></div>
                <div>
                    <div class="sop-stat-num">{{ $solicitudes->getCollection()->where('estado','en_proceso')->count() }}</div>
                    <div class="sop-stat-lbl">En proceso</div>
                </div>
            </div>
            <div class="sop-stat">
                <div class="sop-stat-ico green"><i class="fas fa-circle-check"></i></div>
                <div>
                    <div class="sop-stat-num">{{ $solicitudes->getCollection()->where('estado','resuelto')->count() }}</div>
                    <div class="sop-stat-lbl">Resueltos</div>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('chofer.soporte.index') }}">
            <div class="sop-filters">
                <div class="sop-fg" style="max-width:280px;">
                    <i class="fas fa-search sop-fg-ico"></i>
                    <input type="text" name="buscar" placeholder="Buscar por título o descripción..." value="{{ request('buscar') }}" autocomplete="off">
                </div>
                <div class="sop-fg" style="max-width:180px;">
                    <i class="fas fa-filter sop-fg-ico"></i>
                    <select name="estado">
                        <option value="">Todos los estados</option>
                        <option value="pendiente"  {{ request('estado')=='pendiente'  ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_proceso" {{ request('estado')=='en_proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="resuelto"   {{ request('estado')=='resuelto'   ? 'selected' : '' }}>Resuelto</option>
                    </select>
                </div>
                <button type="submit" class="sop-btn-search"><i class="fas fa-search"></i> Buscar</button>
                <a href="{{ route('chofer.soporte.index') }}" class="sop-btn-clear"><i class="fas fa-times"></i> Limpiar</a>
            </div>
        </form>

        <div class="sop-table-wrap">
            <table>
                <thead>
                <tr>
                    <th style="width:45px;">#</th>
                    <th>Título / Descripción</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th style="text-align:center;width:80px;">Acción</th>
                </tr>
                </thead>
                <tbody>
                @forelse($solicitudes as $solicitud)
                    <tr>
                        <td>
                            <div class="sop-num">
                                {{ str_pad($loop->iteration + ($solicitudes->firstItem() - 1), 2, '0', STR_PAD_LEFT) }}
                            </div>
                        </td>

                        <td>
                            <div class="sop-titulo">{{ $solicitud->titulo }}</div>
                            <div class="sop-desc">{{ \Illuminate\Support\Str::limit($solicitud->descripcion, 60) }}</div>
                        </td>
                        <td>
                        <span class="sop-estado {{ $solicitud->estado }}">
                            @if($solicitud->estado == 'pendiente')
                                <i class="fas fa-clock"></i> Pendiente
                            @elseif($solicitud->estado == 'en_proceso')
                                <i class="fas fa-spinner"></i> En proceso
                            @else
                                <i class="fas fa-circle-check"></i> Resuelto
                            @endif
                        </span>
                        </td>
                        <td>
                            <div class="sop-date">
                                <span class="sop-date-day">{{ $solicitud->created_at->format('d M Y') }}</span>
                                {{ $solicitud->created_at->format('H:i') }}
                            </div>
                        </td>
                        <td style="text-align:center;">
                            <button type="button" class="sop-btn-ver" data-bs-toggle="modal" data-bs-target="#sopDet{{ $solicitud->id }}">
                                <i class="fas fa-eye"></i> Ver
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade sop-modal" id="sopDet{{ $solicitud->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-headset me-2" style="color:#0284c7;"></i>Solicitud #{{ $solicitud->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <strong>Título</strong>
                                    <p>{{ $solicitud->titulo }}</p>

                                    <strong>Descripción</strong>
                                    <p>{{ $solicitud->descripcion }}</p>

                                    <strong>Estado</strong>
                                    <p>{{ ucfirst(str_replace('_', ' ', $solicitud->estado)) }}</p>

                                    <strong>Fecha de envío</strong>
                                    <p>{{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="sop-btn-mc" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr class="sop-empty">
                        <td colspan="5">
                            <div class="sop-empty-ico"><i class="fas fa-headset"></i></div>
                            <div class="sop-empty-t">Sin solicitudes registradas</div>
                            <div class="sop-empty-s">Aún no has enviado ninguna solicitud de soporte.</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="sop-pag-bar">
            <span class="sop-pag-info">
                Mostrando <strong>{{ $solicitudes->firstItem() ?? 0 }}</strong>–<strong>{{ $solicitudes->lastItem() ?? 0 }}</strong>
                de <strong>{{ $solicitudes->total() }}</strong>
            </span>
                <div class="sop-pag-links">
                    {{-- Anterior --}}
                    @if($solicitudes->onFirstPage())
                        <button class="sop-pag-btn" disabled><i class="fas fa-chevron-left"></i></button>
                    @else
                        <a href="{{ $solicitudes->appends(request()->query())->previousPageUrl() }}" class="sop-pag-btn"><i class="fas fa-chevron-left"></i></a>
                    @endif

                    {{-- Números --}}
                    @php
                        $current  = $solicitudes->currentPage();
                        $last     = $solicitudes->lastPage();
                        $start    = max(1, $current - 2);
                        $end      = min($last, $start + 4);
                        $start    = max(1, $end - 4);
                    @endphp
                    @for($p = $start; $p <= $end; $p++)
                        @if($p == $current)
                            <button class="sop-pag-btn sop-pag-active">{{ $p }}</button>
                        @else
                            <a href="{{ $solicitudes->appends(request()->query())->url($p) }}" class="sop-pag-btn">{{ $p }}</a>
                        @endif
                    @endfor

                    {{-- Siguiente --}}
                    @if($solicitudes->hasMorePages())
                        <a href="{{ $solicitudes->appends(request()->query())->nextPageUrl() }}" class="sop-pag-btn"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <button class="sop-pag-btn" disabled><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
