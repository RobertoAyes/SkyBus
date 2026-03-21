@extends('layouts.layoutchofer')

@section('title', 'Confirmar salida y llegada')

@section('contenido')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <div class="chofer-wrapper">
        <div class="page-inner">

            <div class="greeting-banner">
                <div class="greeting-text">
                    <div class="greeting-title">Confirmar salida / llegada</div>
                    <div class="greeting-sub">Gestiona tus viajes y marca su estado en tiempo real.</div>
                </div>
                <div class="greeting-icon-wrap">
                    <i class="fas fa-bus"></i>
                </div>
            </div>

            @if(!$itinerarios->isEmpty())
                <div class="summary-chips">
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-play"></i></div>
                        <div>
                            <div class="chip-value">{{ $itinerarios->where('estado_viaje', 'Pendiente')->count() }}</div>
                            <div class="chip-label">Pendientes</div>
                        </div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-road"></i></div>
                        <div>
                            <div class="chip-value">{{ $itinerarios->where('estado_viaje', 'En ruta')->count() }}</div>
                            <div class="chip-label">En ruta</div>
                        </div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon"><i class="fas fa-flag-checkered"></i></div>
                        <div>
                            <div class="chip-value">{{ $itinerarios->where('estado_viaje', 'Finalizado')->count() }}</div>
                            <div class="chip-label">Finalizados</div>
                        </div>
                    </div>
                </div>
            @endif


            <form method="GET" action="{{ route('confirmar') }}" id="formFiltros">
                <div class="filter-bar">
                    <div class="ch-fg" style="max-width:260px;">
                        <i class="fas fa-search ch-fg-ico"></i>
                        <input type="text" name="buscar" class="f-input"
                               placeholder="Buscar ruta, origen, destino..."
                               value="{{ request('buscar') }}">
                    </div>
                    <div class="ch-fg" style="max-width:165px;">
                        <i class="fas fa-calendar ch-fg-ico"></i>
                        <input type="date" name="fecha" class="f-input"
                               value="{{ request('fecha') }}">
                    </div>
                    <div class="ch-fg" style="max-width:175px;">
                        <i class="fas fa-filter ch-fg-ico"></i>
                        <select name="estado_viaje" class="f-input select2" data-placeholder="Todos los viajes">
                            <option value=""></option>
                            <option value="Pendiente"  {{ request('estado_viaje')=='Pendiente'  ? 'selected':'' }}>Pendiente</option>
                            <option value="En ruta"    {{ request('estado_viaje')=='En ruta'    ? 'selected':'' }}>En ruta</option>
                            <option value="Finalizado" {{ request('estado_viaje')=='Finalizado' ? 'selected':'' }}>Finalizado</option>
                        </select>
                    </div>
                    @if(request()->hasAny(['buscar','estado_viaje','fecha']))
                        <button class="btn-limpiar" type="button"
                                onclick="window.location='{{ route('confirmar') }}'">
                            <i class="fas fa-times"></i> Limpiar
                        </button>
                    @endif
                </div>
            </form>


            <div class="table-card">
                <table class="main-table">
                    <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['orden' => request('orden')=='ruta_asc' ? 'ruta_desc':'ruta_asc']) }}" class="th-link">
                                Ruta <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['orden' => request('orden')=='fecha_asc' ? 'fecha_desc':'fecha_asc']) }}" class="th-link">
                                Fecha <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['orden' => request('orden')=='salida_asc' ? 'salida_desc':'salida_asc']) }}" class="th-link">
                                Hora salida <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th>Hora llegada</th>
                        <th>Estado</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($itinerarios as $key => $itinerario)
                        <tr>
                            <td>
                                <div class="row-num">{{ str_pad(($itinerarios->currentPage()-1)*$itinerarios->perPage()+$key+1, 2, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td>
                                <span class="ruta-pill">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $itinerario->ruta->origen ?? 'N/A' }}
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                    {{ $itinerario->ruta->destino ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="td-date">{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d M Y') : '—' }}</td>
                            <td class="td-date">{{ $itinerario->hora_salida ? \Carbon\Carbon::parse($itinerario->hora_salida)->format('H:i') : '—' }}</td>
                            <td class="td-date">{{ $itinerario->hora_llegada ? \Carbon\Carbon::parse($itinerario->hora_llegada)->format('H:i') : '—' }}</td>
                            <td>
                                <span class="estado-badge {{ $itinerario->estado_viaje=='Finalizado' ? 'est-success' : ($itinerario->estado_viaje=='En ruta' ? 'est-info' : 'est-warning') }}">
                                    {{ $itinerario->estado_viaje ?? 'Pendiente' }}
                                </span>
                            </td>
                            <td style="text-align:center;">
                                @if($itinerario->estado_viaje == 'Pendiente')
                                    <form action="{{ route('viaje.salida', $itinerario->id) }}" method="POST">
                                        @csrf
                                        <button class="btn-accion btn-salida">
                                            <i class="fas fa-play me-1"></i>Salida
                                        </button>
                                    </form>
                                @elseif($itinerario->estado_viaje == 'En ruta')
                                    <form action="{{ route('viaje.llegada', $itinerario->id) }}" method="POST">
                                        @csrf
                                        <button class="btn-accion btn-llegada">
                                            <i class="fas fa-flag-checkered me-1"></i>Llegada
                                        </button>
                                    </form>
                                @else
                                    <span class="finalizado-txt">
                                        <i class="fas fa-check-circle me-1"></i>Finalizado
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="ch-empty-ico"><i class="fas fa-bus"></i></div>
                                <div class="ch-empty-t">Sin viajes asignados</div>
                                <div class="ch-empty-s">No tienes rutas programadas.</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>


                <div class="ch-pag-bar">
                    <span class="ch-pag-info">
                        Mostrando <strong>{{ $itinerarios->firstItem() ?? 0 }}</strong>–<strong>{{ $itinerarios->lastItem() ?? 0 }}</strong>
                        de <strong>{{ $itinerarios->total() }}</strong>
                    </span>
                    @if($itinerarios->hasPages())
                        <div class="ch-pag-links">
                            <a href="{{ $itinerarios->previousPageUrl() }}"
                               class="ch-pag-btn {{ $itinerarios->onFirstPage() ? 'ch-pag-dis' : '' }}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            @for($p = 1; $p <= $itinerarios->lastPage(); $p++)
                                <a href="{{ $itinerarios->url($p) }}"
                                   class="ch-pag-btn {{ $p == $itinerarios->currentPage() ? 'ch-pag-active' : '' }}">
                                    {{ $p }}
                                </a>
                            @endfor
                            <a href="{{ $itinerarios->nextPageUrl() }}"
                               class="ch-pag-btn {{ !$itinerarios->hasMorePages() ? 'ch-pag-dis' : '' }}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    <style>
        .chofer-wrapper { font-family: 'DM Sans', sans-serif; background: #f0f7ff; padding: 2rem; }
        .greeting-banner {
            background: linear-gradient(135deg,#3a9fd6 0%,#5bb8e8 100%);
            border-radius: 20px; padding: 1.8rem 2rem; margin-bottom: 1.8rem;
            color: #fff; display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 8px 28px rgba(58,159,214,0.25);
        }
        .greeting-title { font-weight: 800; font-size: 1.5rem; }
        .greeting-sub   { font-size: 0.9rem; opacity: 0.85; }
        .greeting-icon-wrap { font-size: 1.6rem; }
        .summary-chips  { display: flex; gap: 1rem; margin-bottom: 1.8rem; flex-wrap: wrap; }
        .chip { background: #fff; border: 1px solid #d0e8f8; border-radius: 14px; padding: 0.8rem 1rem; display: flex; align-items: center; gap: 0.7rem; min-width: 120px; }
        .chip-icon  { background: #e0f3fc; color: #3a9fd6; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .chip-value { font-family: 'DM Mono', monospace; font-weight: 800; font-size: 1.2rem; }
        .chip-label { font-size: 0.7rem; color: #7aaac8; text-transform: uppercase; }


        .filter-bar { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .7rem 1rem; display: flex; gap: .6rem; align-items: center; flex-wrap: wrap; margin-bottom: 1rem; }
        .ch-fg { display: flex; align-items: center; gap: .35rem; flex: 1; min-width: 120px; }
        .ch-fg-ico { color: #94a3b8; font-size: .75rem; flex-shrink: 0; }
        .f-input {
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem; border: 1px solid #c9dff2; border-radius: 7px;
            padding: .38rem .65rem; color: #1e3a5f; background: #f8fbff;
            width: 100%; outline: none; transition: border .15s, box-shadow .15s;
        }
        .f-input:focus {
            border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff;
        }
        .btn-limpiar { font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600; color: #64748b; background: none; border: 1px solid #e2edf8; border-radius: 7px; padding: .38rem .8rem; cursor: pointer; white-space: nowrap; transition: all .15s; }
        .btn-limpiar:hover { background: #f8fbff; color: #1e3a5f; border-color: #c9dff2; }


        .select2-container .select2-selection--single {
            font-family: 'DM Sans', sans-serif !important;
            font-size: .82rem !important;
            border: 1px solid #c9dff2 !important;
            border-radius: 7px !important;
            background: #f8fbff !important;
            height: auto !important;
            padding: .38rem .65rem !important;
            color: #1e3a5f !important;
            transition: border .15s, box-shadow .15s !important;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            font-size: .82rem !important;
            color: #1e3a5f !important;
            padding: 0 !important;
            line-height: 1.5 !important;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
            color: #94a3b8 !important;
            font-size: .82rem !important;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            top: 50% !important;
            transform: translateY(-50%) !important;
        }
        .select2-container--bootstrap-5.select2-container--focus .select2-selection--single,
        .select2-container--bootstrap-5.select2-container--open .select2-selection--single {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 3px rgba(56,189,248,.15) !important;
            background: #fff !important;
        }
        .select2-container--bootstrap-5 .select2-dropdown {
            font-family: 'DM Sans', sans-serif !important;
            font-size: .82rem !important;
            border: 1px solid #c9dff2 !important;
            border-radius: 7px !important;
            color: #1e3a5f !important;
        }
        .select2-container--bootstrap-5 .select2-results__option {
            font-size: .82rem !important;
            color: #1e3a5f !important;
            padding: .35rem .65rem !important;
        }
        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background: #e0f2fe !important;
            color: #0369a1 !important;
        }
        .select2-container--bootstrap-5 .select2-results__option--selected {
            background: #0284c7 !important;
            color: #fff !important;
        }


        .table-card { background: #fff; border: 1px solid #e2edf8; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 12px rgba(14,165,233,.06); }
        .main-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .main-table thead { background: #f8fbff; border-bottom: 1px solid #c9dff2; }
        .main-table thead th { padding: .7rem 1rem; color: #64748b; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; white-space: nowrap; }
        .main-table tbody tr { border-bottom: 1px solid #f1f7fc; transition: background .12s; }
        .main-table tbody tr:last-child { border-bottom: none; }
        .main-table tbody tr:hover { background: #f0f9ff; }
        .main-table tbody td { padding: .72rem 1rem; color: #374151; vertical-align: middle; }
        .th-link { color: #64748b; text-decoration: none; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; }
        .th-link:hover { color: #0284c7; }
        .th-link i { font-size: 9px; margin-left: 2px; }

        .row-num { width: 28px; height: 28px; border-radius: 7px; background: #e0f2fe; border: 1px solid #bae6fd; display: inline-flex; align-items: center; justify-content: center; font-family: 'DM Mono', monospace; font-weight: 700; font-size: .72rem; color: #0284c7; }

        .ruta-pill { display: inline-flex; align-items: center; gap: .35rem; background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: .25rem .65rem; border-radius: 20px; font-size: .78rem; font-weight: 600; white-space: nowrap; }
        .ruta-pill i { font-size: 9px; opacity: .5; }

        .td-date { color: #64748b; font-size: .82rem; }

        .estado-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: .7rem; font-weight: 600; text-transform: uppercase; }
        .est-warning { background: #fef3c7; color: #92400e; }
        .est-info    { background: #cffafe; color: #155e75; }
        .est-success { background: #dcfce7; color: #166534; }

        .btn-accion { border: none; border-radius: 7px; padding: 5px 14px; font-size: .78rem; font-weight: 600; cursor: pointer; }
        .btn-salida  { background: #0284c7; color: #fff; }
        .btn-salida:hover  { background: #0369a1; }
        .btn-llegada { background: #16a34a; color: #fff; }
        .btn-llegada:hover { background: #15803d; }
        .finalizado-txt { color: #16a34a; font-size: .78rem; font-weight: 600; }

        .ch-empty-ico { width: 48px; height: 48px; background: #e0f2fe; border: 2px dashed #bae6fd; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 2rem auto .7rem; color: #38bdf8; font-size: 1.2rem; }
        .ch-empty-t { text-align: center; font-weight: 600; color: #64748b; font-size: .88rem; }
        .ch-empty-s { text-align: center; font-size: .75rem; color: #94a3b8; margin: .2rem 0 2rem; }


        .ch-pag-bar   { display: flex; align-items: center; justify-content: space-between; padding: .7rem 1rem; border-top: 1px solid #e2edf8; flex-wrap: wrap; gap: .5rem; }
        .ch-pag-info  { font-size: .77rem; color: #94a3b8; }
        .ch-pag-info strong { color: #64748b; }
        .ch-pag-links { display: flex; align-items: center; gap: .3rem; }
        .ch-pag-btn   { min-width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: .78rem; font-weight: 600; border: 1px solid #e2edf8; background: #fff; color: #64748b; cursor: pointer; transition: all .15s; padding: 0 .5rem; text-decoration: none; }
        .ch-pag-btn:hover  { border-color: #38bdf8; color: #0284c7; background: #f0f9ff; }
        .ch-pag-active     { background: #0284c7 !important; border-color: #0284c7 !important; color: #fff !important; }
        .ch-pag-dis        { opacity: .35; pointer-events: none; }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Todos los viajes',
                allowClear: true,
            });
            $('#formFiltros select, #formFiltros input[type=date]').on('change', function () {
                $('#formFiltros').submit();
            });
        });
    </script>
@endsection
