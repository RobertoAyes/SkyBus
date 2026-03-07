@extends('layouts.layoutadmin')

@section('title', 'Itinerarios de Choferes')


@section('content')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .itn-wrap { font-family: 'DM Sans', sans-serif; background: #f0f9ff; min-height: 100vh; padding: 1.75rem 1.5rem; }

        .itn-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; flex-wrap: wrap; gap: .75rem; }
        .itn-topbar-left { display: flex; align-items: baseline; gap: .5rem; }
        .itn-title { font-size: 1.3rem; font-weight: 700; color: #0c1a2e; letter-spacing: -.02em; margin: 0; }
        .itn-badge { font-family: 'DM Mono', monospace; font-size: .72rem; font-weight: 500; background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; padding: .15rem .55rem; border-radius: 20px; }

        .itn-btn-new { display: inline-flex; align-items: center; gap: .4rem; background: #0284c7; color: #fff; border: none; padding: .5rem 1.1rem; border-radius: 8px; font-size: .82rem; font-weight: 600; text-decoration: none; box-shadow: 0 2px 8px rgba(2,132,199,.25); transition: background .18s, transform .15s, box-shadow .18s; }
        .itn-btn-new:hover { background: #0369a1; transform: translateY(-1px); box-shadow: 0 5px 16px rgba(2,132,199,.35); color: #fff; }
        .itn-btn-new i { font-size: .75rem; }

        .itn-flash { display: flex; align-items: center; gap: .5rem; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: .65rem 1rem; border-radius: 8px; font-size: .83rem; font-weight: 500; margin-bottom: 1rem; }

        .itn-stats { display: flex; gap: .75rem; margin-bottom: 1.1rem; flex-wrap: wrap; }
        .itn-stat { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .65rem 1rem; display: flex; align-items: center; gap: .7rem; flex: 1; min-width: 130px; }
        .itn-stat-ico { width: 30px; height: 30px; border-radius: 7px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; }
        .itn-stat-num { font-family: 'DM Mono', monospace; font-size: 1.35rem; font-weight: 500; color: #0c1a2e; line-height: 1; }
        .itn-stat-lbl { font-size: .7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; font-weight: 500; margin-top: .1rem; }

        .itn-filters { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .7rem 1rem; display: flex; gap: .6rem; align-items: center; flex-wrap: wrap; margin-bottom: 1rem; }
        .itn-fg { display: flex; align-items: center; gap: .35rem; flex: 1; min-width: 140px; }
        .itn-fg-ico { color: #94a3b8; font-size: .75rem; flex-shrink: 0; }
        .itn-filters input, .itn-filters select { font-family: 'DM Sans', sans-serif; font-size: .82rem; border: 1px solid #c9dff2; border-radius: 7px; padding: .38rem .65rem; color: #1e3a5f; background: #f8fbff; width: 100%; outline: none; transition: border .15s, box-shadow .15s; }
        .itn-filters input:focus, .itn-filters select:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff; }
        .itn-btn-clear { font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600; color: #64748b; background: none; border: 1px solid #e2edf8; border-radius: 7px; padding: .38rem .8rem; cursor: pointer; white-space: nowrap; transition: all .15s; }
        .itn-btn-clear:hover { background: #f8fbff; color: #1e3a5f; border-color: #c9dff2; }
        .itn-filter-count { font-size: .75rem; color: #94a3b8; margin-left: auto; }

        .itn-table-wrap { background: #fff; border: 1px solid #e2edf8; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 12px rgba(14,165,233,.06); }
        .itn-table-wrap table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .itn-table-wrap thead { background: #f8fbff; border-bottom: 1px solid #c9dff2; }
        .itn-table-wrap thead th { padding: .7rem 1rem; color: #64748b; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; white-space: nowrap; }
        .itn-th-sort { cursor: pointer; user-select: none; }
        .itn-th-sort:hover { color: #0284c7; }
        .itn-sort-ico { margin-left: .3rem; opacity: .4; font-size: .62rem; }
        .itn-table-wrap tbody tr { border-bottom: 1px solid #f1f7fc; transition: background .12s; }
        .itn-table-wrap tbody tr:last-child { border-bottom: none; }
        .itn-table-wrap tbody tr:hover { background: #f0f9ff; }
        .itn-table-wrap tbody td { padding: .72rem 1rem; color: #2d5a8e; vertical-align: middle; }

        .itn-driver { display: flex; align-items: center; gap: .6rem; }
        .itn-avatar { width: 30px; height: 30px; border-radius: 7px; background: linear-gradient(135deg, #0ea5e9, #0284c7); color: #fff; font-size: .72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .itn-dname { font-weight: 600; color: #1e3a5f; font-size: .85rem; }

        .itn-route { display: inline-flex; align-items: center; gap: .35rem; background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: .25rem .65rem; border-radius: 20px; font-size: .78rem; font-weight: 600; white-space: nowrap; }
        .itn-route .sep { opacity: .4; font-size: .65rem; }

        .itn-paradas-col { display: flex; flex-direction: column; gap: .22rem; }
        .itn-parada { display: grid; grid-template-columns: auto 1fr auto; align-items: center; gap: .4rem; font-size: .78rem; color: #2d5a8e; background: #f8fbff; border: 1px solid #e2edf8; border-radius: 6px; padding: .28rem .55rem; }
        .itn-parada-num { width: 18px; height: 18px; border-radius: 50%; background: #e0f2fe; color: #0284c7; font-size: .62rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .itn-parada-lugar { font-size: .78rem; color: #1e3a5f; font-weight: 500; }
        .itn-ptime { font-family: 'DM Mono', monospace; font-size: .68rem; background: #e0f2fe; color: #0284c7; border-radius: 4px; padding: .08rem .35rem; white-space: nowrap; flex-shrink: 0; }
        .itn-no-paradas { font-size: .75rem; color: #94a3b8; font-style: italic; }

        .itn-date { font-family: 'DM Mono', monospace; font-size: .78rem; color: #64748b; }
        .itn-date-day { color: #1e3a5f; font-weight: 500; display: block; font-size: .82rem; }

        .itn-btn-del { display: inline-flex; align-items: center; gap: .3rem; padding: .3rem .75rem; border-radius: 6px; font-size: .76rem; font-weight: 600; cursor: pointer; border: 1px solid #fecaca; background: #fff1f0; color: #dc2626; transition: all .15s; font-family: 'DM Sans', sans-serif; }
        .itn-btn-del:hover { background: #fee2e2; border-color: #fca5a5; transform: scale(1.02); }

        .itn-empty td { text-align: center; padding: 3.5rem 1rem; }
        .itn-empty-ico { width: 52px; height: 52px; background: #e0f2fe; border: 2px dashed #bae6fd; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto .8rem; color: #38bdf8; font-size: 1.3rem; }
        .itn-empty-t { font-weight: 600; color: #64748b; font-size: .9rem; }
        .itn-empty-s { font-size: .78rem; color: #94a3b8; margin-top: .25rem; }

        .itn-pag-bar { display: flex; align-items: center; justify-content: space-between; padding: .7rem 1rem; border-top: 1px solid #e2edf8; flex-wrap: wrap; gap: .5rem; }
        .itn-pag-info { font-size: .77rem; color: #94a3b8; }
        .itn-pag-info strong { color: #64748b; }
        .itn-pag-links { display: flex; align-items: center; gap: .3rem; }
        .itn-pag-btn { min-width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: .78rem; font-weight: 600; border: 1px solid #e2edf8; background: #fff; color: #64748b; cursor: pointer; transition: all .15s; padding: 0 .5rem; font-family: 'DM Sans', sans-serif; }
        .itn-pag-btn:hover { border-color: #38bdf8; color: #0284c7; background: #f0f9ff; }
        .itn-pag-active { background: #0284c7 !important; border-color: #0284c7 !important; color: #fff !important; }
        .itn-pag-btn:disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }

        .itn-modal .modal-content { font-family: 'DM Sans', sans-serif; border: 1px solid #e2edf8 !important; border-radius: 12px !important; }
        .itn-modal .modal-header { background: #fff5f5 !important; border-bottom: 1px solid #fee2e2 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.25rem !important; }
        .itn-modal .modal-title { font-size: .9rem !important; font-weight: 700 !important; color: #991b1b !important; }
        .itn-modal .modal-body { font-size: .84rem !important; color: #2d5a8e !important; padding: 1.1rem 1.25rem !important; line-height: 1.6; }
        .itn-modal .modal-body strong { color: #0c1a2e; }
        .itn-modal .modal-footer { border-top: 1px solid #e2edf8 !important; padding: .8rem 1.25rem !important; }
        .itn-btn-mc { font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 600; padding: .42rem 1rem; border-radius: 7px; cursor: pointer; border: 1px solid #e2edf8; background: #fff; color: #64748b; transition: all .15s; }
        .itn-btn-mc:hover { background: #f8fbff; }
        .itn-btn-md { font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 600; padding: .42rem 1rem; border-radius: 7px; cursor: pointer; border: none; background: #dc2626; color: #fff; transition: all .15s; }
        .itn-btn-md:hover { background: #b91c1c; }

        #itn-no-results { display: none; }
    </style>
    <div class="itn-wrap">

        <div class="itn-topbar">
            <div class="itn-topbar-left">
                <h1 class="itn-title">Itinerarios</h1>
                <span class="itn-badge" id="itn-counter">{{ $itinerarios->count() }}</span>
            </div>
            <a href="{{ route('itinerarioChofer.create') }}" class="itn-btn-new">
                <i class="fas fa-plus"></i> Asignar Itinerario
            </a>
        </div>

        @if(session('success'))
            <div class="itn-flash"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <div class="itn-stats">
            <div class="itn-stat">
                <div class="itn-stat-ico"><i class="fas fa-calendar-check"></i></div>
                <div>
                    <div class="itn-stat-num">{{ $itinerarios->count() }}</div>
                    <div class="itn-stat-lbl">Total</div>
                </div>
            </div>
            <div class="itn-stat">
                <div class="itn-stat-ico"><i class="fas fa-user-tie"></i></div>
                <div>
                    <div class="itn-stat-num">{{ $itinerarios->unique('chofer_id')->count() }}</div>
                    <div class="itn-stat-lbl">Choferes</div>
                </div>
            </div>
            <div class="itn-stat">
                <div class="itn-stat-ico"><i class="fas fa-route"></i></div>
                <div>
                    <div class="itn-stat-num">{{ $itinerarios->unique('ruta_id')->count() }}</div>
                    <div class="itn-stat-lbl">Rutas</div>
                </div>
            </div>
            <div class="itn-stat">
                <div class="itn-stat-ico"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <div class="itn-stat-num">{{ $itinerarios->sum(fn($i) => $i->paradas ? $i->paradas->count() : 0) }}</div>
                    <div class="itn-stat-lbl">Paradas</div>
                </div>
            </div>
        </div>

        <div class="itn-filters">
            <div class="itn-fg" style="max-width:260px;">
                <i class="fas fa-search itn-fg-ico"></i>
                <input type="text" id="itn-search" placeholder="Buscar chofer, ruta..." autocomplete="off">
            </div>
            <div class="itn-fg" style="max-width:190px;">
                <i class="fas fa-user-tie itn-fg-ico"></i>
                <select id="itn-fchofer">
                    <option value="">Todos los choferes</option>
                    @foreach($itinerarios->unique('chofer_id') as $it)
                        <option value="{{ strtolower($it->chofer->name ?? '') }}">{{ $it->chofer->name ?? 'Sin chofer' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="itn-fg" style="max-width:165px;">
                <i class="fas fa-calendar itn-fg-ico"></i>
                <input type="date" id="itn-fdate">
            </div>
            <button class="itn-btn-clear" id="itn-clear"><i class="fas fa-times"></i> Limpiar</button>
            <span class="itn-filter-count" id="itn-fcount"></span>
        </div>

        <div class="itn-table-wrap">
            <table>
                <thead>
                <tr>
                    <th class="itn-th-sort" data-col="0">Chofer <i class="fas fa-sort itn-sort-ico"></i></th>
                    <th class="itn-th-sort" data-col="1">Ruta <i class="fas fa-sort itn-sort-ico"></i></th>
                    <th>Paradas y tiempo de espera</th>
                    <th class="itn-th-sort" data-col="3">Fecha y Hora <i class="fas fa-sort itn-sort-ico"></i></th>
                    <th style="text-align:center;width:90px;">Acción</th>
                </tr>
                </thead>
                <tbody id="itn-body">
                @forelse($itinerarios as $itinerario)
                    <tr
                        data-chofer="{{ strtolower($itinerario->chofer->name ?? '') }}"
                        data-date="{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('Y-m-d') : '' }}"
                        data-search="{{ strtolower(($itinerario->chofer->name ?? '').' '.($itinerario->ruta->origen ?? '').' '.($itinerario->ruta->destino ?? '')) }}"
                    >
                        <td>
                            <div class="itn-driver">
                                <div class="itn-avatar">{{ strtoupper(substr($itinerario->chofer->name ?? 'S', 0, 2)) }}</div>
                                <span class="itn-dname">{{ $itinerario->chofer->name ?? 'Sin chofer' }}</span>
                            </div>
                        </td>
                        <td>
                        <span class="itn-route">
                            <i class="fas fa-map-marker-alt sep"></i>
                            {{ $itinerario->ruta->origen ?? '?' }}
                            <i class="fas fa-long-arrow-alt-right sep"></i>
                            {{ $itinerario->ruta->destino ?? '?' }}
                        </span>
                        </td>
                        <td>
                            @if($itinerario->paradas && $itinerario->paradas->count() > 0)
                                <div class="itn-paradas-col">
                                    @foreach($itinerario->paradas as $parada)
                                        <div class="itn-parada">
                                            <span class="itn-parada-num">{{ $loop->iteration }}</span>
                                            <span class="itn-parada-lugar">{{ $parada->lugar_parada }}</span>
                                            <span class="itn-ptime">{{ $parada->tiempo_parada }} min</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="itn-no-paradas">Sin paradas</span>
                            @endif
                        </td>
                        <td>
                            <div class="itn-date">
                                @if($itinerario->fecha)
                                    <span class="itn-date-day">{{ \Carbon\Carbon::parse($itinerario->fecha)->format('d M Y') }}</span>
                                    {{ \Carbon\Carbon::parse($itinerario->fecha)->format('H:i') }}
                                @else
                                    <span style="color:#94a3b8">—</span>
                                @endif
                            </div>
                        </td>
                        <td style="text-align:center;">
                            <button type="button" class="itn-btn-del" data-bs-toggle="modal" data-bs-target="#itnDel{{ $itinerario->id }}">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade itn-modal" id="itnDel{{ $itinerario->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Eliminar itinerario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Eliminar el itinerario de <strong>{{ $itinerario->chofer->name ?? 'Sin chofer' }}</strong>
                                    en la ruta <strong>{{ $itinerario->ruta->origen ?? '' }} → {{ $itinerario->ruta->destino ?? '' }}</strong>
                                    del <strong>{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}</strong>?
                                    <br><br><span style="font-size:.75rem;color:#94a3b8;">Esta acción no se puede deshacer.</span>
                                </div>
                                <div class="modal-footer gap-2">
                                    <button type="button" class="itn-btn-mc" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('itinerarioChofer.destroy', $itinerario->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="itn-btn-md"><i class="fas fa-trash-alt me-1"></i>Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr class="itn-empty">
                        <td colspan="5">
                            <div class="itn-empty-ico"><i class="fas fa-calendar-times"></i></div>
                            <div class="itn-empty-t">Sin itinerarios asignados</div>
                            <div class="itn-empty-s">Empieza asignando un itinerario a un chofer</div>
                        </td>
                    </tr>
                @endforelse

                <tr id="itn-no-results" class="itn-empty">
                    <td colspan="5">
                        <div class="itn-empty-ico"><i class="fas fa-filter"></i></div>
                        <div class="itn-empty-t">Sin resultados</div>
                        <div class="itn-empty-s">Prueba ajustando los filtros</div>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="itn-pag-bar">
                <span class="itn-pag-info">Mostrando <strong id="itn-pfrom">1</strong>–<strong id="itn-pto">10</strong> de <strong id="itn-ptotal">{{ $itinerarios->count() }}</strong></span>
                <div class="itn-pag-links" id="itn-plinks"></div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var PER_PAGE = 10;
            var currentPage = 1;
            var visibleRows = [];

            var tbody    = document.getElementById('itn-body');
            var noRes    = document.getElementById('itn-no-results');
            var fSearch  = document.getElementById('itn-search');
            var fChofer  = document.getElementById('itn-fchofer');
            var fDate    = document.getElementById('itn-fdate');
            var btnClear = document.getElementById('itn-clear');
            var fCount   = document.getElementById('itn-fcount');
            var pfrom    = document.getElementById('itn-pfrom');
            var pto      = document.getElementById('itn-pto');
            var ptotal   = document.getElementById('itn-ptotal');
            var plinks   = document.getElementById('itn-plinks');
            var badge    = document.getElementById('itn-counter');

            function getRows() {
                return Array.from(tbody.querySelectorAll('tr[data-search]'));
            }

            function applyFilters() {
                var q  = fSearch.value.toLowerCase().trim();
                var ch = fChofer.value.toLowerCase();
                var dt = fDate.value;
                var all = getRows();
                visibleRows = all.filter(function(r) {
                    return (!q  || r.dataset.search.includes(q))
                        && (!ch || r.dataset.chofer === ch)
                        && (!dt || r.dataset.date === dt);
                });
                all.forEach(function(r) { r.style.display = 'none'; });
                noRes.style.display = visibleRows.length === 0 ? '' : 'none';
                fCount.textContent = (q || ch || dt) ? visibleRows.length + ' resultado(s)' : '';
                badge.textContent = visibleRows.length;
                currentPage = 1;
                renderPage();
            }

            function renderPage() {
                var total = visibleRows.length;
                var pages = Math.max(1, Math.ceil(total / PER_PAGE));
                if (currentPage > pages) currentPage = pages;
                var start = (currentPage - 1) * PER_PAGE;
                var end   = Math.min(start + PER_PAGE, total);
                visibleRows.forEach(function(r, i) {
                    r.style.display = (i >= start && i < end) ? '' : 'none';
                });
                pfrom.textContent  = total ? start + 1 : 0;
                pto.textContent    = end;
                ptotal.textContent = total;
                buildPager(pages);
            }

            function buildPager(pages) {
                plinks.innerHTML = '';
                function makeBtn(label, page, disabled, active) {
                    var b = document.createElement('button');
                    b.className = 'itn-pag-btn' + (active ? ' itn-pag-active' : '');
                    b.innerHTML = label;
                    b.disabled  = disabled;
                    if (!disabled && !active) {
                        b.onclick = function() { currentPage = page; renderPage(); };
                    }
                    return b;
                }
                plinks.appendChild(makeBtn('<i class="fas fa-chevron-left"></i>', currentPage - 1, currentPage === 1, false));
                var ps = Math.max(1, currentPage - 2);
                var pe = Math.min(pages, ps + 4);
                ps = Math.max(1, pe - 4);
                for (var p = ps; p <= pe; p++) {
                    plinks.appendChild(makeBtn(p, p, false, p === currentPage));
                }
                plinks.appendChild(makeBtn('<i class="fas fa-chevron-right"></i>', currentPage + 1, currentPage === pages, false));
            }

            var sortDir = {};
            document.querySelectorAll('.itn-th-sort').forEach(function(th) {
                th.addEventListener('click', function() {
                    var col = parseInt(th.dataset.col);
                    sortDir[col] = !sortDir[col];
                    visibleRows.sort(function(a, b) {
                        var ta = a.cells[col] ? a.cells[col].innerText.trim() : '';
                        var tb = b.cells[col] ? b.cells[col].innerText.trim() : '';
                        return sortDir[col] ? ta.localeCompare(tb) : tb.localeCompare(ta);
                    });
                    document.querySelectorAll('.itn-sort-ico').forEach(function(i) {
                        i.className = 'fas fa-sort itn-sort-ico';
                    });
                    th.querySelector('.itn-sort-ico').className = 'fas fa-sort-' + (sortDir[col] ? 'up' : 'down') + ' itn-sort-ico';
                    currentPage = 1;
                    renderPage();
                });
            });

            fSearch.addEventListener('input', applyFilters);
            fChofer.addEventListener('change', applyFilters);
            fDate.addEventListener('change', applyFilters);
            btnClear.addEventListener('click', function() {
                fSearch.value = '';
                fChofer.value = '';
                fDate.value   = '';
                applyFilters();
            });

            visibleRows = getRows();
            renderPage();
        })();
    </script>
@endsection
