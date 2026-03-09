@extends('layouts.layoutadmin')

@section('title', 'Panel Administrativo')

@section('content')
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:    #0f2249;
            --blue:    #1a3a82;
            --blue2:   #2e5cbf;
            --teal:    #0d7a6e;
            --teal2:   #14b8a6;
            --red:     #c0392b;
            --red2:    #ef4444;
            --bg:      #f0f2f7;
            --card:    #ffffff;
            --border:  #dde1eb;
            --txt:     #0f2249;
            --muted:   #64748b;
            --light:   #f8fafc;
            --radius:  14px;
        }

        .est-wrap { font-family: 'DM Sans', sans-serif; }

        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.1rem; }
        .topbar-left { display: flex; align-items: center; gap: .9rem; }
        .topbar-icon { width: 44px; height: 44px; background: linear-gradient(135deg, var(--blue), var(--blue2)); border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: white; }
        .topbar-left h1 { font-size: 1.35rem; font-weight: 800; color: var(--navy); line-height: 1; margin: 0; }
        .topbar-left p  { font-size: .75rem; color: var(--muted); margin: 2px 0 0; }
        .topbar-right { display: flex; align-items: center; gap: .6rem; }
        .tb-date { font-size: .75rem; color: var(--muted); font-weight: 500; background: white; border: 1px solid var(--border); padding: .42rem .85rem; border-radius: 8px; display: flex; align-items: center; gap: .4rem; }

        .filterbar { background: white; border: 1px solid var(--border); border-radius: var(--radius); padding: .75rem 1.1rem; display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; box-shadow: 0 1px 6px rgba(0,0,0,.04); margin-bottom: 1.1rem; }
        .fb-group { display: flex; align-items: center; gap: .45rem; }
        .fb-label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: var(--muted); white-space: nowrap; }

        .fb-select { height: 36px; border: 1.5px solid var(--border); border-radius: 8px; padding: 0 .75rem; font-size: .8rem; font-family: inherit; color: var(--txt); background: var(--light); outline: none; cursor: pointer; transition: border-color .2s; min-width: 200px; }
        .fb-select:focus { border-color: var(--blue2); box-shadow: 0 0 0 3px rgba(46,92,191,.1); }
        .fb-div { width: 1px; height: 24px; background: var(--border); flex-shrink: 0; }
        .fb-spacer { flex: 1; }


        .fb-btn { height: 36px; width: 110px; padding: 0; border-radius: 8px; border: none; font-size: .8rem; font-weight: 700; font-family: inherit; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: .4rem; transition: all .2s; }
        .fb-btn.primary { background: linear-gradient(135deg, var(--blue), var(--blue2)); color: white; }
        .fb-btn.primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(26,58,130,.35); }
        .fb-btn.ghost { background: var(--light); color: var(--muted); border: 1.5px solid var(--border); }
        .fb-btn.ghost:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(100,116,139,.18); background: #e8ecf3; color: var(--txt); }

        .banner-viajes { background: linear-gradient(135deg, #0a5c52 0%, #0d7a6e 45%, #10b8a6 100%); border-radius: var(--radius); padding: 1.25rem 1.5rem; display: grid; grid-template-columns: auto 1fr; gap: 1.5rem; align-items: center; box-shadow: 0 6px 28px rgba(13,122,110,.35); position: relative; overflow: hidden; margin-bottom: 1.1rem; }
        .banner-viajes::before { content: ''; position: absolute; right: -50px; top: -60px; width: 230px; height: 230px; background: rgba(255,255,255,.055); border-radius: 50%; }
        .bv-left { display: flex; align-items: center; gap: 1.1rem; z-index: 1; }
        .bv-ico { width: 54px; height: 54px; background: rgba(255,255,255,.18); border-radius: 13px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: white; flex-shrink: 0; }
        .bv-lbl { font-size: .82rem; font-weight: 600; color: rgba(255,255,255,.85); margin-bottom: 3px; }
        .bv-num { font-size: 2.6rem; font-weight: 800; color: white; line-height: 1; }
        .bv-sub { font-size: .7rem; color: rgba(255,255,255,.65); margin-top: 5px; }
        .bv-chart { z-index: 1; min-width: 0; }

        .kpi-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: .85rem; margin-bottom: 1.1rem; }
        @media(max-width:768px) { .kpi-row { grid-template-columns: 1fr; } }
        .kcard { border-radius: var(--radius); padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,.08); transition: transform .22s, box-shadow .22s; position: relative; overflow: hidden; }
        .kcard:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.13); }
        .kcard.k-blue  { background: linear-gradient(135deg, var(--blue), var(--blue2)); color: white; }
        .kcard.k-red   { background: linear-gradient(135deg, var(--red), var(--red2));   color: white; }
        .kcard.k-dark  { background: linear-gradient(135deg, #1a2844, #2a3f6f);           color: white; }
        .kcard::before { content: ''; position: absolute; right: -20px; top: -20px; width: 90px; height: 90px; background: rgba(255,255,255,.06); border-radius: 50%; }
        .kico { width: 46px; height: 46px; flex-shrink: 0; background: rgba(255,255,255,.2); border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .klbl { font-size: .72rem; font-weight: 600; opacity: .82; text-transform: uppercase; letter-spacing: .3px; margin-bottom: 3px; }
        .kval { font-size: 2rem; font-weight: 800; line-height: 1; }
        .ksub { font-size: .7rem; opacity: .65; margin-top: 4px; }

        .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; margin-bottom: 1.1rem; }
        @media(max-width:768px) { .charts-grid { grid-template-columns: 1fr; } }
        .ccard { background: white; border-radius: var(--radius); border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,.04); overflow: hidden; transition: box-shadow .25s; }
        .ccard:hover { box-shadow: 0 6px 22px rgba(0,0,0,.09); }
        .ccard-head { padding: .9rem 1.2rem .65rem; border-bottom: 1px solid #f1f4f9; display: flex; align-items: flex-start; justify-content: space-between; }
        .ccard-head h5 { font-size: .86rem; font-weight: 700; color: var(--navy); margin: 0; }
        .ccard-head p  { font-size: .72rem; color: var(--muted); margin: 2px 0 0; }
        .ccard-body { padding: .85rem 1.1rem; }
        .legend-item { display: flex; align-items: center; gap: 5px; font-size: .72rem; color: var(--muted); font-weight: 500; }
        .legend-dot  { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }


        .roles-body { display: flex; flex-direction: column; align-items: center; padding: .85rem 1.1rem 1rem; gap: .85rem; }
        .roles-chart-wrap { display: flex; align-items: center; justify-content: center; width: 100%; }
        .roles-legend { width: 100%; display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; }
        .roles-legend-item { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 6px 10px; border-radius: 8px; background: #f8fafc; border: 1px solid var(--border); transition: background .15s; }
        .roles-legend-item:hover { background: #eef1f8; }
        .roles-legend-left { display: flex; align-items: center; gap: 7px; min-width: 0; }
        .roles-legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }
        .roles-legend-name { font-size: .8rem; font-weight: 600; color: var(--navy); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .tcard { background: white; border-radius: var(--radius); border: 1px solid var(--border); overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.04); }
        .tcard-head { padding: .9rem 1.4rem; background: linear-gradient(135deg, var(--navy), var(--blue)); color: white; font-size: .88rem; font-weight: 700; display: flex; align-items: center; gap: .5rem; }
        .tcard table { width: 100%; border-collapse: collapse; font-size: .84rem; }
        .tcard thead tr { background: #f8fafc; }
        .tcard th { padding: .6rem 1.25rem; font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--muted); text-align: left; border-bottom: 1px solid var(--border); }
        .tcard td { padding: .78rem 1.25rem; border-bottom: 1px solid #f3f6fb; vertical-align: middle; }
        .tcard tr:last-child td { border-bottom: none; }
        .tcard tr:hover td { background: #f8fafc; }
        .rol-color { width: 8px; height: 32px; border-radius: 4px; display: inline-block; margin-right: 8px; vertical-align: middle; flex-shrink: 0; }
        .rol-name  { font-weight: 600; color: var(--navy); }
        .prog-wrap { display: flex; align-items: center; gap: 8px; }
        .prog-bg   { width: 110px; height: 5px; background: #e8ecf3; border-radius: 10px; overflow: hidden; }
        .prog-fill { height: 100%; border-radius: 10px; }
        .pct-lbl   { font-size: .78rem; color: var(--muted); font-weight: 600; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
        .a1{animation:fadeUp .35s ease both .05s} .a2{animation:fadeUp .35s ease both .12s}
        .a3{animation:fadeUp .35s ease both .19s} .a4{animation:fadeUp .35s ease both .26s}
        .a5{animation:fadeUp .35s ease both .33s} .a6{animation:fadeUp .35s ease both .40s}
    </style>

    <div class="container-fluid px-3 py-3 est-wrap">


        <div class="topbar a1">
            <div class="topbar-left">
                <div class="topbar-icon"><i class="fas fa-chart-bar"></i></div>
                <div>
                    <h1>Estadísticas</h1>
                    <p>Métricas operativas del sistema de transporte</p>
                </div>
            </div>
            <div class="topbar-right">
                <span class="tb-date"><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}</span>
            </div>
        </div>


        <div class="filterbar a2">
            <form method="GET" action="{{ route('estadistica') }}" class="d-contents" style="display:contents">
                <div class="fb-group">
                    <span class="fb-label"><i class="fas fa-calendar me-1"></i> Período de tiempo</span>
                    <select name="periodo" class="fb-select">
                        <option value="">Seleccionar</option>
                        <option value="semana"  {{ request('periodo')=='semana'  ? 'selected':'' }}>Última semana</option>
                        <option value="mes"     {{ request('periodo')=='mes'     ? 'selected':'' }}>Último mes</option>
                        <option value="anio"    {{ request('periodo')=='anio'    ? 'selected':'' }}>Último año</option>
                    </select>
                </div>
                <div class="fb-div"></div>
                <div class="fb-group">
                    <span class="fb-label"><i class="fas fa-toggle-on me-1"></i> Estado de usuario</span>
                    <select name="estado" class="fb-select">
                        <option value="">Todos</option>
                        <option value="activo"   {{ request('estado')=='activo'   ? 'selected':'' }}>Activo</option>
                        <option value="inactivo" {{ request('estado')=='inactivo' ? 'selected':'' }}>Inactivo</option>
                    </select>
                </div>
                <div class="fb-spacer"></div>
                <button type="submit" class="fb-btn primary"><i class="fas fa-filter"></i> Filtrar</button>
                <a href="{{ route('estadistica') }}" class="fb-btn ghost" style="text-decoration:none"><i class="fas fa-times"></i> Limpiar</a>
            </form>
        </div>


        <div class="banner-viajes a3">
            <div class="bv-left">
                <div class="bv-ico"><i class="fas fa-route"></i></div>
                <div>
                    <div class="bv-lbl">Viajes Realizados</div>
                    <div class="bv-num">{{ number_format($totalViajesFinalizados) }}</div>
                    <div class="bv-sub">Total de viajes finalizados en el período</div>
                </div>
            </div>
            <div class="bv-chart">
                <canvas id="chartViajes" height="80"></canvas>
            </div>
        </div>


        @php $totalUsuarios = $usuariosActivos + $usuariosInactivos; @endphp
        <div class="kpi-row a4">
            <div class="kcard k-blue">
                <div class="kico"><i class="fas fa-user-check"></i></div>
                <div>
                    <div class="klbl">Usuarios Activos</div>
                    <div class="kval">{{ $usuariosActivos }}</div>
                    <div class="ksub">Cuentas habilitadas</div>
                </div>
            </div>
            <div class="kcard k-red">
                <div class="kico"><i class="fas fa-user-times"></i></div>
                <div>
                    <div class="klbl">Usuarios Inactivos</div>
                    <div class="kval">{{ $usuariosInactivos }}</div>
                    <div class="ksub">Cuentas inhabilitadas</div>
                </div>
            </div>
            <div class="kcard k-dark">
                <div class="kico"><i class="fas fa-users"></i></div>
                <div>
                    <div class="klbl">Total Usuarios</div>
                    <div class="kval">{{ $totalUsuarios }}</div>
                    <div class="ksub">Registrados en el sistema</div>
                </div>
            </div>
        </div>


        <div class="charts-grid a5">


            <div class="ccard">
                <div class="ccard-head">
                    <div>
                        <h5><i class="fas fa-chart-line" style="color:#667eea;margin-right:6px"></i>Evolución de Usuarios</h5>
                        <p>Crecimiento registrado en el período seleccionado</p>
                    </div>
                    <div class="legend-item"><span class="legend-dot" style="background:#667eea"></span> Usuarios</div>
                </div>
                <div class="ccard-body"><canvas id="chartCrecimiento" height="145"></canvas></div>
            </div>


            <div class="ccard">
                <div class="ccard-head">
                    <div>
                        <h5><i class="fas fa-user-tag" style="color:#f59e0b;margin-right:6px"></i>Distribución por Rol</h5>
                        <p>Usuarios según su tipo</p>
                    </div>
                </div>
                <div class="roles-body">
                    <div class="roles-chart-wrap">
                        <canvas id="chartRoles" style="max-width:150px;max-height:150px"></canvas>
                    </div>
                    <div class="roles-legend">
                        @php
                            $colores = ['#667eea','#10b981','#f59e0b','#ef4444','#3b82f6'];
                            $idx = 0;
                        @endphp
                        @foreach($detallePorRol as $rol => $datosEstado)
                            @php $col = $colores[$idx % count($colores)]; @endphp
                            <div class="roles-legend-item">
                                <div class="roles-legend-left">
                                    <span class="roles-legend-dot" style="background:{{ $col }}"></span>
                                    <span class="roles-legend-name">{{ $rol }}</span>
                                </div>
                            </div>
                            @php $idx++; @endphp
                        @endforeach
                    </div>
                </div>
            </div>

        </div>


        @php
            $colores2         = ['#667eea','#10b981','#f59e0b','#ef4444','#3b82f6'];
            $idx2             = 0;
            $totalUsuariosRol = collect($detallePorRol)->map(function($ds) {
                return (is_array($ds) || $ds instanceof \Illuminate\Support\Collection)
                    ? collect($ds)->sum() : $ds;
            })->sum();
        @endphp
        <div class="tcard a6">
            <div class="tcard-head"><i class="fas fa-table"></i> Detalle de Usuarios por Rol</div>
            <div class="table-responsive">
                <table>
                    <thead>
                    <tr>
                        <th>Rol</th><th>Cantidad</th><th>Distribución</th><th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($detallePorRol as $rol => $datosEstado)
                        @php
                            $col           = $colores2[$idx2 % count($colores2)];
                            $cant          = is_array($datosEstado) || $datosEstado instanceof \Illuminate\Support\Collection
                                             ? collect($datosEstado)->sum() : $datosEstado;
                            $pct           = $totalUsuariosRol > 0 ? round(($cant / $totalUsuariosRol) * 100, 1) : 0;
                            $activos_rol   = is_array($datosEstado) || $datosEstado instanceof \Illuminate\Support\Collection
                                             ? (collect($datosEstado)['activo']   ?? 0) : 0;
                            $inactivos_rol = is_array($datosEstado) || $datosEstado instanceof \Illuminate\Support\Collection
                                             ? (collect($datosEstado)['inactivo'] ?? 0) : 0;
                        @endphp
                        <tr>
                            <td style="display:flex;align-items:center">
                                <span class="rol-color" style="background:{{ $col }}"></span>
                                <span class="rol-name">{{ $rol }}</span>
                            </td>
                            <td style="font-weight:700">{{ $cant }}</td>
                            <td>
                                <div class="prog-wrap">
                                    <div class="prog-bg">
                                        <div class="prog-fill" style="width:{{ $pct }}%;background:{{ $col }}"></div>
                                    </div>
                                    <span class="pct-lbl">{{ $pct }}%</span>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div style="display:flex;align-items:center;gap:5px">
                                        <span style="width:7px;height:7px;border-radius:50%;background:#16a34a;flex-shrink:0"></span>
                                        <span style="font-size:.78rem;color:#15803d;font-weight:700">{{ $activos_rol }}</span>
                                        <span style="font-size:.72rem;color:#6b7280;font-weight:500">activos</span>
                                    </div>
                                    <span style="color:#e2e8f0">|</span>
                                    <div style="display:flex;align-items:center;gap:5px">
                                        <span style="width:7px;height:7px;border-radius:50%;background:#dc2626;flex-shrink:0"></span>
                                        <span style="font-size:.78rem;color:#dc2626;font-weight:700">{{ $inactivos_rol }}</span>
                                        <span style="font-size:.72rem;color:#6b7280;font-weight:500">inactivos</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php $idx2++; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const tip = {
            backgroundColor:'#1f2937', padding:12, borderRadius:8,
            titleColor:'#fff', bodyColor:'#d1d5db', displayColors:false,
            titleFont:{size:13,weight:'bold'}, bodyFont:{size:12}
        };


        new Chart(document.getElementById('chartViajes').getContext('2d'), {
            data: {
                labels: {!! json_encode($viajesPorMes['labels']) !!},
                datasets: [
                    {
                        type: 'bar',
                        data: {!! json_encode($viajesPorMes['values']) !!},
                        backgroundColor: 'rgba(255,255,255,.18)',
                        borderRadius: 5,
                        borderSkipped: false
                    },
                    {
                        type: 'line',
                        label: 'Viajes',
                        data: {!! json_encode($viajesPorMes['values']) !!},
                        borderColor: '#fff',
                        borderWidth: 2.5,
                        fill: false,
                        tension: .4,
                        pointRadius: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0d7a6e',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: { legend: { display: false }, tooltip: tip },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,.1)' }, ticks: { color: 'rgba(255,255,255,.7)', font: { size: 9 } } },
                    x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,.7)', font: { size: 9 }, maxRotation: 0 } }
                }
            }
        });


        const ctxC = document.getElementById('chartCrecimiento').getContext('2d');
        const gradC = ctxC.createLinearGradient(0, 0, 0, 220);
        gradC.addColorStop(0, 'rgba(102,126,234,.3)');
        gradC.addColorStop(1, 'rgba(102,126,234,0)');
        new Chart(ctxC, {
            type: 'line',
            data: {
                labels: {!! json_encode($usuariosPorFecha->keys()) !!},
                datasets: [{
                    label: 'Usuarios',
                    data: {!! json_encode($usuariosPorFecha->values()) !!},
                    borderColor: '#667eea',
                    backgroundColor: gradC,
                    borderWidth: 2.5,
                    fill: true,
                    tension: .4,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#667eea',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: { legend: { display: false }, tooltip: tip },
                scales: {
                    y: { beginAtZero: false, grid: { color: '#f1f4f9' }, ticks: { color: '#94a3b8', font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 }, maxRotation: 45, maxTicksLimit: 8 } }
                }
            }
        });


        new Chart(document.getElementById('chartRoles'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($usuariosPorRol->keys()) !!},
                datasets: [{
                    data: {!! json_encode($usuariosPorRol->values()) !!},
                    backgroundColor: ['#667eea','#10b981','#f59e0b','#ef4444','#3b82f6'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: true, cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor:'#1f2937',
                        padding:12,
                        borderRadius:8,
                        titleColor:'#fff',
                        bodyColor:'#d1d5db',
                        displayColors: false,
                        titleFont:{size:13,weight:'bold'},
                        bodyFont:{size:12},
                        callbacks: {
                            title: function() { return ''; },
                            label: function(ctx) {
                                return ctx.label + ': ' + ctx.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
