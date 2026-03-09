@extends('layouts.layoutchofer')

@section('contenido')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .inc-wrap { font-family: 'DM Sans', sans-serif; background: #f0f9ff; min-height: 100vh; padding: 1.75rem 1.5rem; }

        .inc-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; flex-wrap: wrap; gap: .75rem; }
        .inc-topbar-left { display: flex; align-items: baseline; gap: .5rem; }
        .inc-title { font-size: 1.3rem; font-weight: 700; color: #0c1a2e; letter-spacing: -.02em; margin: 0; }
        .inc-badge { font-family: 'DM Mono', monospace; font-size: .72rem; font-weight: 500; background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; padding: .15rem .55rem; border-radius: 20px; }
        .inc-btn-print { display: inline-flex; align-items: center; gap: .4rem; background: #fff; border: 1px solid #c9dff2; color: #0284c7; border-radius: 8px; padding: .45rem 1rem; font-size: .8rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all .15s; }
        .inc-btn-print:hover { background: #e0f2fe; border-color: #bae6fd; }

        .inc-stats { display: flex; gap: .75rem; margin-bottom: 1.1rem; flex-wrap: wrap; }
        .inc-stat { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .65rem 1rem; display: flex; align-items: center; gap: .7rem; flex: 1; min-width: 130px; }
        .inc-stat-ico { width: 30px; height: 30px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; }
        .inc-stat-ico.blue { background: #e0f2fe; color: #0284c7; }
        .inc-stat-ico.red  { background: #fff1f0; color: #dc2626; }
        .inc-stat-ico.amber { background: #fffbeb; color: #d97706; }
        .inc-stat-ico.green { background: #f0fdf4; color: #16a34a; }
        .inc-stat-num { font-family: 'DM Mono', monospace; font-size: 1.35rem; font-weight: 500; color: #0c1a2e; line-height: 1; }
        .inc-stat-lbl { font-size: .7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; font-weight: 500; margin-top: .1rem; }

        .inc-filters { background: #fff; border: 1px solid #e2edf8; border-radius: 10px; padding: .7rem 1rem; display: flex; gap: .6rem; align-items: center; flex-wrap: wrap; margin-bottom: 1rem; }
        .inc-fg { display: flex; align-items: center; gap: .35rem; flex: 1; min-width: 140px; }
        .inc-fg-ico { color: #94a3b8; font-size: .75rem; flex-shrink: 0; }
        .inc-filters input, .inc-filters select { font-family: 'DM Sans', sans-serif; font-size: .82rem; border: 1px solid #c9dff2; border-radius: 7px; padding: .38rem .65rem; color: #1e3a5f; background: #f8fbff; width: 100%; outline: none; transition: border .15s, box-shadow .15s; }
        .inc-filters input:focus, .inc-filters select:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff; }
        .inc-btn-clear { font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 600; color: #64748b; background: none; border: 1px solid #e2edf8; border-radius: 7px; padding: .38rem .8rem; cursor: pointer; white-space: nowrap; transition: all .15s; }
        .inc-btn-clear:hover { background: #f8fbff; color: #1e3a5f; border-color: #c9dff2; }
        .inc-filter-count { font-size: .75rem; color: #94a3b8; margin-left: auto; }

        .inc-table-wrap { background: #fff; border: 1px solid #e2edf8; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 12px rgba(14,165,233,.06); }
        .inc-table-wrap table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .inc-table-wrap thead { background: #f8fbff; border-bottom: 1px solid #c9dff2; }
        .inc-table-wrap thead th { padding: .7rem 1rem; color: #64748b; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; white-space: nowrap; }
        .inc-th-sort { cursor: pointer; user-select: none; }
        .inc-th-sort:hover { color: #0284c7; }
        .inc-sort-ico { margin-left: .3rem; opacity: .4; font-size: .62rem; }
        .inc-table-wrap tbody tr { border-bottom: 1px solid #f1f7fc; transition: background .12s; }
        .inc-table-wrap tbody tr:last-child { border-bottom: none; }
        .inc-table-wrap tbody tr:hover { background: #f0f9ff; }
        .inc-table-wrap tbody td { padding: .72rem 1rem; color: #2d5a8e; vertical-align: middle; }

        .inc-num { width: 28px; height: 28px; border-radius: 7px; background: #e0f2fe; border: 1px solid #bae6fd; display: flex; align-items: center; justify-content: center; font-family: 'DM Mono', monospace; font-size: .72rem; font-weight: 700; color: #0284c7; }

        .inc-tipo-plain { font-size: .85rem; font-weight: 600; color: #1e3a5f; }
        .inc-tipo-plain i { font-size: .75rem; color: #94a3b8; margin-right: .25rem; }

        .inc-bus { display: inline-flex; align-items: center; gap: .3rem; font-size: .8rem; font-weight: 600; color: #1e3a5f; }
        .inc-bus i { font-size: .72rem; color: #94a3b8; }

        .inc-route-plain { display: flex; align-items: center; gap: .3rem; font-size: .8rem; color: #2d5a8e; margin-top: .25rem; }
        .inc-route-plain i { font-size: .68rem; color: #38bdf8; }
        .inc-no-ruta { font-size: .75rem; color: #94a3b8; font-style: italic; }

        .inc-desc { font-size: .8rem; color: #64748b; line-height: 1.45; max-width: 280px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        .inc-date { font-family: 'DM Mono', monospace; font-size: .78rem; color: #64748b; }
        .inc-date-day { color: #1e3a5f; font-weight: 500; display: block; font-size: .82rem; }

        .inc-empty td { text-align: center; padding: 3.5rem 1rem; }
        .inc-empty-ico { width: 52px; height: 52px; background: #e0f2fe; border: 2px dashed #bae6fd; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto .8rem; color: #38bdf8; font-size: 1.3rem; }
        .inc-empty-t { font-weight: 600; color: #64748b; font-size: .9rem; }
        .inc-empty-s { font-size: .78rem; color: #94a3b8; margin-top: .25rem; }

        .inc-pag-bar { display: flex; align-items: center; justify-content: space-between; padding: .7rem 1rem; border-top: 1px solid #e2edf8; flex-wrap: wrap; gap: .5rem; }
        .inc-pag-info { font-size: .77rem; color: #94a3b8; }
        .inc-pag-info strong { color: #64748b; }
        .inc-pag-links { display: flex; align-items: center; gap: .3rem; }
        .inc-pag-btn { min-width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: .78rem; font-weight: 600; border: 1px solid #e2edf8; background: #fff; color: #64748b; cursor: pointer; transition: all .15s; padding: 0 .5rem; font-family: 'DM Sans', sans-serif; }
        .inc-pag-btn:hover { border-color: #38bdf8; color: #0284c7; background: #f0f9ff; }
        .inc-pag-active { background: #0284c7 !important; border-color: #0284c7 !important; color: #fff !important; }
        .inc-pag-btn:disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }

        #inc-no-results { display: none; }
    </style>

    <div class="inc-wrap">

        <div class="inc-topbar">
            <div class="inc-topbar-left">
                <h1 class="inc-title">Mis Incidentes</h1>
                <span class="inc-badge" id="inc-counter">{{ $incidentes->count() }}</span>
            </div>
            <button onclick="window.print()" class="inc-btn-print">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>

        <div class="inc-stats">
            <div class="inc-stat">
                <div class="inc-stat-ico blue"><i class="fas fa-clipboard-list"></i></div>
                <div>
                    <div class="inc-stat-num">{{ $incidentes->count() }}</div>
                    <div class="inc-stat-lbl">Total</div>
                </div>
            </div>
            <div class="inc-stat">
                <div class="inc-stat-ico red"><i class="fas fa-car-crash"></i></div>
                <div>
                    <div class="inc-stat-num">{{ $incidentes->where('tipo_incidente', 'Accidente')->count() }}</div>
                    <div class="inc-stat-lbl">Accidentes</div>
                </div>
            </div>
            <div class="inc-stat">
                <div class="inc-stat-ico amber"><i class="fas fa-wrench"></i></div>
                <div>
                    <div class="inc-stat-num">{{ $incidentes->where('tipo_incidente', 'Falla mecánica')->count() }}</div>
                    <div class="inc-stat-lbl">Fallas</div>
                </div>
            </div>
            <div class="inc-stat">
                <div class="inc-stat-ico blue"><i class="fas fa-bus"></i></div>
                <div>
                    <div class="inc-stat-num">{{ $incidentes->unique('bus_numero')->count() }}</div>
                    <div class="inc-stat-lbl">Buses</div>
                </div>
            </div>
        </div>

        <div class="inc-filters">
            <div class="inc-fg" style="max-width:250px;">
                <i class="fas fa-search inc-fg-ico"></i>
                <input type="text" id="inc-search" placeholder="Buscar ruta, bus, descripción..." autocomplete="off">
            </div>
            <div class="inc-fg" style="max-width:175px;">
                <i class="fas fa-tag inc-fg-ico"></i>
                <select id="inc-ftipo">
                    <option value="">Todos los tipos</option>
                    <option value="accidente">Accidente</option>
                    <option value="mecanico">Falla mecánica</option>
                    <option value="trafico">Tráfico</option>
                    <option value="medico">Incidente médico</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="inc-fg" style="max-width:165px;">
                <i class="fas fa-calendar inc-fg-ico"></i>
                <input type="date" id="inc-fdate">
            </div>
            <button class="inc-btn-clear" id="inc-clear"><i class="fas fa-times"></i> Limpiar</button>
            <span class="inc-filter-count" id="inc-fcount"></span>
        </div>

        <div class="inc-table-wrap">
            <table>
                <thead>
                <tr>
                    <th style="width:45px;">#</th>
                    <th class="inc-th-sort" data-col="1">Tipo <i class="fas fa-sort inc-sort-ico"></i></th>
                    <th class="inc-th-sort" data-col="2">Bus <i class="fas fa-sort inc-sort-ico"></i></th>
                    <th class="inc-th-sort" data-col="3">Ruta <i class="fas fa-sort inc-sort-ico"></i></th>
                    <th>Descripción</th>
                    <th class="inc-th-sort" data-col="5">Estado <i class="fas fa-sort inc-sort-ico"></i></th>
                    <th class="inc-th-sort" data-col="5">Fecha y Hora <i class="fas fa-sort inc-sort-ico"></i></th>
                </tr>
                </thead>
                <tbody id="inc-body">
                @forelse($incidentes as $index => $incidente)
                    @php
                        $tipo = strtolower($incidente->tipo_incidente ?? 'otro');
                        $tipoKey = str_contains($tipo, 'accidente') ? 'accidente'
                            : (str_contains($tipo, 'mec') ? 'mecanico'
                            : (str_contains($tipo, 'tr') ? 'trafico'
                            : (str_contains($tipo, 'med') ? 'medico' : 'otro')));
                    @endphp
                    <tr
                        data-search="{{ strtolower(($incidente->tipo_incidente ?? '').' '.($incidente->bus_numero ?? '').' '.($incidente->ruta ?? '').' '.($incidente->descripcion ?? '')) }}"
                        data-tipo="{{ $tipoKey }}"
                        data-date="{{ $incidente->fecha_hora ? \Carbon\Carbon::parse($incidente->fecha_hora)->format('Y-m-d') : '' }}"
                    >
                        <td><div class="inc-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div></td>
                        <td>
                            <span class="inc-tipo-plain">{{ $incidente->tipo_incidente ?? 'Otro' }}</span>
                        </td>
                        <td>
                            <div class="inc-bus"><i class="fas fa-bus"></i> Bus #{{ $incidente->bus_numero ?? '—' }}</div>
                        </td>
                        <td>
                            @if($incidente->ruta)
                                <div class="inc-route-plain"><i class="fas fa-route"></i> {{ $incidente->ruta }}</div>
                            @else
                                <span class="inc-no-ruta">Sin ruta</span>
                            @endif
                        </td>
                        <td>
                            <div class="inc-desc">{{ $incidente->descripcion ?? 'Sin descripción.' }}</div>
                        </td>

                        <td>
                            @php
                                $estado = $incidente->estado ?? 'pendiente';
                            @endphp

                            @if($estado == 'pendiente')
                                <span style="background:#fff7ed;color:#c2410c;padding:4px 10px;border-radius:6px;font-size:.75rem;font-weight:600;">
                                    Pendiente
                                </span>
                            @elseif($estado == 'en_proceso')
                                <span style="background:#eff6ff;color:#1d4ed8;padding:4px 10px;border-radius:6px;font-size:.75rem;font-weight:600;">
                                    En proceso
                                </span>
                            @elseif($estado == 'resuelto')
                                <span style="background:#ecfdf5;color:#047857;padding:4px 10px;border-radius:6px;font-size:.75rem;font-weight:600;">
                                    Resuelto
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="inc-date">
                                @if($incidente->fecha_hora)
                                    <span class="inc-date-day">{{ \Carbon\Carbon::parse($incidente->fecha_hora)->format('d M Y') }}</span>
                                    {{ \Carbon\Carbon::parse($incidente->fecha_hora)->format('H:i') }}
                                @else
                                    <span style="color:#94a3b8">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="inc-empty">
                        <td colspan="6">
                            <div class="inc-empty-ico"><i class="fas fa-clipboard-check"></i></div>
                            <div class="inc-empty-t">Sin incidentes registrados</div>
                            <div class="inc-empty-s">No tienes incidencias reportadas.<br>¡Todo marcha bien!</div>
                        </td>
                    </tr>
                @endforelse

                <tr id="inc-no-results" class="inc-empty">
                    <td colspan="6">
                        <div class="inc-empty-ico"><i class="fas fa-filter"></i></div>
                        <div class="inc-empty-t">Sin resultados</div>
                        <div class="inc-empty-s">Prueba ajustando los filtros</div>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="inc-pag-bar">
                <span class="inc-pag-info">Mostrando <strong id="inc-pfrom">1</strong>–<strong id="inc-pto">10</strong> de <strong id="inc-ptotal">{{ $incidentes->count() }}</strong></span>
                <div class="inc-pag-links" id="inc-plinks"></div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var PER_PAGE = 10;
            var currentPage = 1;
            var visibleRows = [];

            var tbody    = document.getElementById('inc-body');
            var noRes    = document.getElementById('inc-no-results');
            var fSearch  = document.getElementById('inc-search');
            var fTipo    = document.getElementById('inc-ftipo');
            var fDate    = document.getElementById('inc-fdate');
            var btnClear = document.getElementById('inc-clear');
            var fCount   = document.getElementById('inc-fcount');
            var pfrom    = document.getElementById('inc-pfrom');
            var pto      = document.getElementById('inc-pto');
            var ptotal   = document.getElementById('inc-ptotal');
            var plinks   = document.getElementById('inc-plinks');
            var badge    = document.getElementById('inc-counter');

            function getRows() {
                return Array.from(tbody.querySelectorAll('tr[data-search]'));
            }

            function applyFilters() {
                var q  = fSearch.value.toLowerCase().trim();
                var tp = fTipo.value;
                var dt = fDate.value;
                var all = getRows();

                visibleRows = all.filter(function(r) {
                    return (!q  || r.dataset.search.includes(q))
                        && (!tp || r.dataset.tipo === tp)
                        && (!dt || r.dataset.date === dt);
                });

                all.forEach(function(r) { r.style.display = 'none'; });
                noRes.style.display = visibleRows.length === 0 ? '' : 'none';
                fCount.textContent = (q || tp || dt) ? visibleRows.length + ' resultado(s)' : '';
                badge.textContent  = visibleRows.length;
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
                    b.className = 'inc-pag-btn' + (active ? ' inc-pag-active' : '');
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
            document.querySelectorAll('.inc-th-sort').forEach(function(th) {
                th.addEventListener('click', function() {
                    var col = parseInt(th.dataset.col);
                    sortDir[col] = !sortDir[col];
                    visibleRows.sort(function(a, b) {
                        var ta = a.cells[col] ? a.cells[col].innerText.trim() : '';
                        var tb = b.cells[col] ? b.cells[col].innerText.trim() : '';
                        return sortDir[col] ? ta.localeCompare(tb) : tb.localeCompare(ta);
                    });
                    document.querySelectorAll('.inc-sort-ico').forEach(function(i) {
                        i.className = 'fas fa-sort inc-sort-ico';
                    });
                    th.querySelector('.inc-sort-ico').className = 'fas fa-sort-' + (sortDir[col] ? 'up' : 'down') + ' inc-sort-ico';
                    currentPage = 1;
                    renderPage();
                });
            });

            fSearch.addEventListener('input', applyFilters);
            fTipo.addEventListener('change', applyFilters);
            fDate.addEventListener('change', applyFilters);
            btnClear.addEventListener('click', function() {
                fSearch.value = '';
                fTipo.value   = '';
                fDate.value   = '';
                applyFilters();
            });

            visibleRows = getRows();
            renderPage();
        })();
    </script>
@endsection
