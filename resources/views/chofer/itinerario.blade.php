@extends('layouts.layoutchofer')

@section('title', 'Mi Itinerario')

@section('contenido')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .ch-wrap { font-family: 'DM Sans', sans-serif; background: #f0f9ff; min-height: 100vh; padding: 1.75rem 1.5rem; }

        .ch-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; flex-wrap: wrap; gap: .75rem; }
        .ch-topbar-left { display: flex; align-items: baseline; gap: .5rem; }
        .ch-title { font-size: 1.3rem; font-weight: 700; color: #0c1a2e; letter-spacing: -.02em; margin: 0; }
        .ch-badge { font-family: 'DM Mono', monospace; font-size: .72rem; font-weight: 500; background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; padding: .15rem .55rem; border-radius: 20px; }

        .ch-stats { display: flex; gap: .75rem; margin-bottom: 1.1rem; flex-wrap: wrap; }
        .ch-stat { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .65rem 1rem; display: flex; align-items: center; gap: .7rem; flex: 1; min-width: 130px; }
        .ch-stat-ico { width: 30px; height: 30px; border-radius: 7px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; }
        .ch-stat-num { font-family: 'DM Mono', monospace; font-size: 1.35rem; font-weight: 500; color: #0c1a2e; line-height: 1; }
        .ch-stat-lbl { font-size: .7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; font-weight: 500; margin-top: .1rem; }

        .ch-filters { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .7rem 1rem; display: flex; gap: .6rem; align-items: center; flex-wrap: wrap; margin-bottom: 1rem; }
        .ch-fg { display: flex; align-items: center; gap: .35rem; flex: 1; min-width: 140px; }
        .ch-fg-ico { color: #94a3b8; font-size: .75rem; flex-shrink: 0; }
        .ch-filters input, .ch-filters select { font-family: 'DM Sans', sans-serif; font-size: .82rem; border: 1px solid #c9dff2; border-radius: 7px; padding: .38rem .65rem; color: #1e3a5f; background: #f8fbff; width: 100%; outline: none; transition: border .15s, box-shadow .15s; }
        .ch-filters input:focus, .ch-filters select:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff; }
        .ch-btn-clear { font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600; color: #64748b; background: none; border: 1px solid #e2edf8; border-radius: 7px; padding: .38rem .8rem; cursor: pointer; white-space: nowrap; transition: all .15s; }
        .ch-btn-clear:hover { background: #f8fbff; color: #1e3a5f; border-color: #c9dff2; }
        .ch-filter-count { font-size: .75rem; color: #94a3b8; margin-left: auto; }

        .ch-table-wrap { background: #fff; border: 1px solid #e2edf8; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 12px rgba(14,165,233,.06); }
        .ch-table-wrap table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .ch-table-wrap thead { background: #f8fbff; border-bottom: 1px solid #c9dff2; }
        .ch-table-wrap thead th { padding: .7rem 1rem; color: #64748b; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; white-space: nowrap; }
        .ch-th-sort { cursor: pointer; user-select: none; }
        .ch-th-sort:hover { color: #0284c7; }
        .ch-sort-ico { margin-left: .3rem; opacity: .4; font-size: .62rem; }
        .ch-table-wrap tbody tr { border-bottom: 1px solid #f1f7fc; transition: background .12s; }
        .ch-table-wrap tbody tr:last-child { border-bottom: none; }
        .ch-table-wrap tbody tr:hover { background: #f0f9ff; }
        .ch-table-wrap tbody td { padding: .72rem 1rem; color: #2d5a8e; vertical-align: middle; }

        .ch-num { width: 28px; height: 28px; border-radius: 7px; background: #e0f2fe; border: 1px solid #bae6fd; display: flex; align-items: center; justify-content: center; font-family: 'DM Mono', monospace; font-size: .72rem; font-weight: 700; color: #0284c7; }

        .ch-route { display: inline-flex; align-items: center; gap: .35rem; background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: .25rem .65rem; border-radius: 20px; font-size: .78rem; font-weight: 600; white-space: nowrap; }
        .ch-route .sep { opacity: .4; font-size: .65rem; }

        .ch-paradas-col { display: flex; flex-direction: column; gap: .22rem; }
        .ch-parada { display: grid; grid-template-columns: auto 1fr auto; align-items: center; gap: .4rem; font-size: .78rem; color: #2d5a8e; background: #f8fbff; border: 1px solid #e2edf8; border-radius: 6px; padding: .28rem .55rem; }
        .ch-parada-num { width: 18px; height: 18px; border-radius: 50%; background: #e0f2fe; color: #0284c7; font-size: .62rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .ch-parada-lugar { font-size: .78rem; color: #1e3a5f; font-weight: 500; }
        .ch-ptime { font-family: 'DM Mono', monospace; font-size: .68rem; background: #e0f2fe; color: #0284c7; border-radius: 4px; padding: .08rem .35rem; white-space: nowrap; flex-shrink: 0; }
        .ch-no-paradas { font-size: .75rem; color: #94a3b8; font-style: italic; }

        .ch-date { font-family: 'DM Mono', monospace; font-size: .78rem; color: #64748b; }
        .ch-date-day { color: #1e3a5f; font-weight: 500; display: block; font-size: .82rem; }

        .ch-today-badge { display: inline-flex; align-items: center; gap: .3rem; font-size: .7rem; font-weight: 700; background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; border-radius: 20px; padding: .12rem .5rem; margin-top: .2rem; }

        .ch-empty td { text-align: center; padding: 3.5rem 1rem; }
        .ch-empty-ico { width: 52px; height: 52px; background: #e0f2fe; border: 2px dashed #bae6fd; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto .8rem; color: #38bdf8; font-size: 1.3rem; }
        .ch-empty-t { font-weight: 600; color: #64748b; font-size: .9rem; }
        .ch-empty-s { font-size: .78rem; color: #94a3b8; margin-top: .25rem; }

        .ch-pag-bar { display: flex; align-items: center; justify-content: space-between; padding: .7rem 1rem; border-top: 1px solid #e2edf8; flex-wrap: wrap; gap: .5rem; }
        .ch-pag-info { font-size: .77rem; color: #94a3b8; }
        .ch-pag-info strong { color: #64748b; }
        .ch-pag-links { display: flex; align-items: center; gap: .3rem; }
        .ch-pag-btn { min-width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: .78rem; font-weight: 600; border: 1px solid #e2edf8; background: #fff; color: #64748b; cursor: pointer; transition: all .15s; padding: 0 .5rem; font-family: 'DM Sans', sans-serif; }
        .ch-pag-btn:hover { border-color: #38bdf8; color: #0284c7; background: #f0f9ff; }
        .ch-pag-active { background: #0284c7 !important; border-color: #0284c7 !important; color: #fff !important; }
        .ch-pag-btn:disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }

        #ch-no-results { display: none; }
    </style>

    <div class="ch-wrap">

        <div class="ch-topbar">
            <div class="ch-topbar-left">
                <h1 class="ch-title">Mi Itinerario</h1>
                <span class="ch-badge" id="ch-counter">{{ $itinerarios->count() }}</span>
            </div>
        </div>

        <div class="ch-stats">
            <div class="ch-stat">
                <div class="ch-stat-ico"><i class="fas fa-calendar-check"></i></div>
                <div>
                    <div class="ch-stat-num">{{ $itinerarios->count() }}</div>
                    <div class="ch-stat-lbl">Viajes asignados</div>
                </div>
            </div>
            <div class="ch-stat">
                <div class="ch-stat-ico"><i class="fas fa-map-signs"></i></div>
                <div>
                    <div class="ch-stat-num">{{ $itinerarios->unique('ruta_id')->count() }}</div>
                    <div class="ch-stat-lbl">Rutas distintas</div>
                </div>
            </div>
            <div class="ch-stat">
                <div class="ch-stat-ico"><i class="fas fa-calendar-day"></i></div>
                <div>
                    <div class="ch-stat-num">{{ $itinerarios->filter(fn($i) => $i->fecha && \Carbon\Carbon::parse($i->fecha)->isToday())->count() }}</div>
                    <div class="ch-stat-lbl">Viajes hoy</div>
                </div>
            </div>
            <div class="ch-stat">
                <div class="ch-stat-ico"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <div class="ch-stat-num">{{ $itinerarios->sum(fn($i) => $i->paradas ? $i->paradas->count() : 0) }}</div>
                    <div class="ch-stat-lbl">Paradas</div>
                </div>
            </div>
        </div>

        <div class="ch-filters">
            <div class="ch-fg" style="max-width:260px;">
                <i class="fas fa-search ch-fg-ico"></i>
                <input type="text" id="ch-search" placeholder="Buscar ruta, origen, destino..." autocomplete="off">
            </div>
            <div class="ch-fg" style="max-width:165px;">
                <i class="fas fa-calendar ch-fg-ico"></i>
                <input type="date" id="ch-fdate">
            </div>
            <div class="ch-fg" style="max-width:165px;">
                <i class="fas fa-filter ch-fg-ico"></i>
                <select id="ch-fhoy">
                    <option value="">Todos los viajes</option>
                    <option value="today">Solo hoy</option>
                    <option value="upcoming">Próximos</option>
                </select>
            </div>
            <button class="ch-btn-clear" id="ch-clear"><i class="fas fa-times"></i> Limpiar</button>
            <span class="ch-filter-count" id="ch-fcount"></span>
        </div>

        <div class="ch-table-wrap">
            <table>
                <thead>
                <tr>
                    <th style="width:45px;">#</th>
                    <th class="ch-th-sort" data-col="1">Ruta <i class="fas fa-sort ch-sort-ico"></i></th>
                    <th>Paradas y tiempo de espera</th>
                    <th class="ch-th-sort" data-col="3">Fecha y Hora <i class="fas fa-sort ch-sort-ico"></i></th>
                </tr>
                </thead>
                <tbody id="ch-body">
                @forelse($itinerarios as $index => $itinerario)
                    <tr
                        data-search="{{ strtolower(($itinerario->ruta->origen ?? '').' '.($itinerario->ruta->destino ?? '')) }}"
                        data-date="{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('Y-m-d') : '' }}"
                        data-today="{{ $itinerario->fecha && \Carbon\Carbon::parse($itinerario->fecha)->isToday() ? '1' : '0' }}"
                        data-upcoming="{{ $itinerario->fecha && \Carbon\Carbon::parse($itinerario->fecha)->isFuture() ? '1' : '0' }}"
                    >
                        <td>
                            <div class="ch-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td>
                        <span class="ch-route">
                            <i class="fas fa-map-marker-alt sep"></i>
                            {{ $itinerario->ruta->origen ?? 'Sin origen' }}
                            <i class="fas fa-long-arrow-alt-right sep"></i>
                            {{ $itinerario->ruta->destino ?? 'Sin destino' }}
                        </span>
                        </td>
                        <td>
                            @if($itinerario->paradas && $itinerario->paradas->count() > 0)
                                <div class="ch-paradas-col">
                                    @foreach($itinerario->paradas as $parada)
                                        <div class="ch-parada">
                                            <span class="ch-parada-num">{{ $loop->iteration }}</span>
                                            <span class="ch-parada-lugar">{{ $parada->lugar_parada }}</span>
                                            <span class="ch-ptime">{{ $parada->tiempo_parada }} min</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="ch-no-paradas">Sin paradas</span>
                            @endif
                        </td>
                        <td>
                            <div class="ch-date">
                                @if($itinerario->fecha)
                                    <span class="ch-date-day">{{ \Carbon\Carbon::parse($itinerario->fecha)->format('d M Y') }}</span>
                                    {{ \Carbon\Carbon::parse($itinerario->fecha)->format('H:i') }}
                                    @if(\Carbon\Carbon::parse($itinerario->fecha)->isToday())
                                        <span class="ch-today-badge"><i class="fas fa-circle" style="font-size:.45rem;"></i> Hoy</span>
                                    @endif
                                @else
                                    <span style="color:#94a3b8">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="ch-empty">
                        <td colspan="4">
                            <div class="ch-empty-ico"><i class="fas fa-calendar-times"></i></div>
                            <div class="ch-empty-t">Sin itinerarios asignados</div>
                            <div class="ch-empty-s">No tienes rutas programadas.<br>Consulta con tu administrador.</div>
                        </td>
                    </tr>
                @endforelse

                <tr id="ch-no-results" class="ch-empty">
                    <td colspan="4">
                        <div class="ch-empty-ico"><i class="fas fa-filter"></i></div>
                        <div class="ch-empty-t">Sin resultados</div>
                        <div class="ch-empty-s">Prueba ajustando los filtros</div>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="ch-pag-bar">
                <span class="ch-pag-info">Mostrando <strong id="ch-pfrom">1</strong>–<strong id="ch-pto">10</strong> de <strong id="ch-ptotal">{{ $itinerarios->count() }}</strong></span>
                <div class="ch-pag-links" id="ch-plinks"></div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var PER_PAGE = 10;
            var currentPage = 1;
            var visibleRows = [];

            var tbody    = document.getElementById('ch-body');
            var noRes    = document.getElementById('ch-no-results');
            var fSearch  = document.getElementById('ch-search');
            var fDate    = document.getElementById('ch-fdate');
            var fHoy     = document.getElementById('ch-fhoy');
            var btnClear = document.getElementById('ch-clear');
            var fCount   = document.getElementById('ch-fcount');
            var pfrom    = document.getElementById('ch-pfrom');
            var pto      = document.getElementById('ch-pto');
            var ptotal   = document.getElementById('ch-ptotal');
            var plinks   = document.getElementById('ch-plinks');
            var badge    = document.getElementById('ch-counter');

            function getRows() {
                return Array.from(tbody.querySelectorAll('tr[data-search]'));
            }

            function applyFilters() {
                var q   = fSearch.value.toLowerCase().trim();
                var dt  = fDate.value;
                var hoy = fHoy.value;
                var all = getRows();

                visibleRows = all.filter(function(r) {
                    var mQ   = !q   || r.dataset.search.includes(q);
                    var mDt  = !dt  || r.dataset.date === dt;
                    var mHoy = !hoy
                        || (hoy === 'today'    && r.dataset.today    === '1')
                        || (hoy === 'upcoming' && r.dataset.upcoming === '1');
                    return mQ && mDt && mHoy;
                });

                all.forEach(function(r) { r.style.display = 'none'; });
                noRes.style.display = visibleRows.length === 0 ? '' : 'none';
                fCount.textContent = (q || dt || hoy) ? visibleRows.length + ' resultado(s)' : '';
                badge.textContent  = visibleRows.length;
                currentPage = 1;
                renderPage();
            }

            function renderPage() {
                var total  = visibleRows.length;
                var pages  = Math.max(1, Math.ceil(total / PER_PAGE));
                if (currentPage > pages) currentPage = pages;
                var start  = (currentPage - 1) * PER_PAGE;
                var end    = Math.min(start + PER_PAGE, total);
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
                    b.className = 'ch-pag-btn' + (active ? ' ch-pag-active' : '');
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
            document.querySelectorAll('.ch-th-sort').forEach(function(th) {
                th.addEventListener('click', function() {
                    var col = parseInt(th.dataset.col);
                    sortDir[col] = !sortDir[col];
                    visibleRows.sort(function(a, b) {
                        var ta = a.cells[col] ? a.cells[col].innerText.trim() : '';
                        var tb = b.cells[col] ? b.cells[col].innerText.trim() : '';
                        return sortDir[col] ? ta.localeCompare(tb) : tb.localeCompare(ta);
                    });
                    document.querySelectorAll('.ch-sort-ico').forEach(function(i) {
                        i.className = 'fas fa-sort ch-sort-ico';
                    });
                    th.querySelector('.ch-sort-ico').className = 'fas fa-sort-' + (sortDir[col] ? 'up' : 'down') + ' ch-sort-ico';
                    currentPage = 1;
                    renderPage();
                });
            });

            fSearch.addEventListener('input', applyFilters);
            fDate.addEventListener('change', applyFilters);
            fHoy.addEventListener('change', applyFilters);
            btnClear.addEventListener('click', function() {
                fSearch.value = '';
                fDate.value   = '';
                fHoy.value    = '';
                applyFilters();
            });

            visibleRows = getRows();
            renderPage();
        })();
    </script>
@endsection
