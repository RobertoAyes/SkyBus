@extends('layouts.layoutadmin')

@section('title', 'Historial de Incidentes')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-exclamation-triangle me-2"></i>Historial de Incidentes
                </h2>
            </div>

            <div class="card-body">


                <div class="card border-0 shadow-sm mb-4" style="background: #f8faff;">
                    <div class="card-body py-3">
                        <div class="row g-2 align-items-end">

                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-search me-1"></i>Buscar
                                </label>
                                <input type="text" id="inc-search" class="form-control form-control-sm" placeholder="Chofer, ruta, bus, motivo...">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-user-tie me-1"></i>Chofer
                                </label>
                                <select id="inc-fchofer" class="form-select form-select-sm">
                                    <option value="">Todos los choferes</option>
                                    @foreach($incidentes->unique('conductor_nombre') as $inc)
                                        <option value="{{ strtolower($inc->conductor_nombre ?? '') }}">{{ $inc->conductor_nombre ?? 'Sin chofer' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-calendar me-1"></i>Fecha
                                </label>
                                <input type="date" id="inc-fdate" class="form-control form-control-sm">
                            </div>

                            <div class="col-md-3">
                                <button id="inc-clear" class="btn btn-outline-secondary btn-sm w-100">
                                    <i class="fas fa-times me-1"></i>Limpiar filtros
                                </button>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">

                        <thead class="table-primary">
                        <tr>
                            <th>Chofer</th>
                            <th>Ruta</th>
                            <th>Bus</th>
                            <th>Motivo</th>
                            <th>Fecha</th>
                            <th class="text-center">Accion</th>
                        </tr>
                        </thead>

                        <tbody id="inc-body">

                        @forelse($incidentes as $incidente)

                            <tr
                                data-chofer="{{ strtolower($incidente->conductor_nombre ?? '') }}"
                                data-date="{{ $incidente->fecha_hora ? \Carbon\Carbon::parse($incidente->fecha_hora)->format('Y-m-d') : '' }}"
                                data-search="{{ strtolower(($incidente->conductor_nombre ?? '').' '.($incidente->ruta ?? '').' '.($incidente->bus_numero ?? '').' '.($incidente->tipo_incidente ?? '')) }}"
                            >

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="inc-avatar">
                                            {{ strtoupper(substr($incidente->conductor_nombre ?? 'S',0,2)) }}
                                        </div>
                                        <span class="fw-semibold" style="color:#1e3a5f;">
                                        {{ $incidente->conductor_nombre ?? 'Sin chofer' }}
                                    </span>
                                    </div>
                                </td>

                                <td>
                                <span class="badge rounded-pill" style="background:#e0f2fe;color:#0369a1;border:1px solid #bae6fd;font-size:.78rem;padding:.35rem .75rem;font-weight:600;">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $incidente->ruta ?? '?' }}
                                </span>
                                </td>

                                <td style="font-size:.85rem;color:#1e3a5f;">
                                    {{ $incidente->bus_numero ?? '—' }}
                                </td>

                                <td>
                                <span class="badge rounded-pill" style="background:#fee2e2;color:#b91c1c;border:1px solid #fca5a5;font-size:.78rem;padding:.35rem .75rem;font-weight:600;">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    {{ $incidente->tipo_incidente ?? '—' }}
                                </span>
                                </td>


                                <td style="font-size:.85rem;color:#1e3a5f;">
                                    @if($incidente->fecha_hora)
                                        {{ \Carbon\Carbon::parse($incidente->fecha_hora)->locale('es')->translatedFormat('d F Y') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <button class="inc-btn" data-bs-toggle="modal" data-bs-target="#incModal{{ $incidente->id }}">
                                    <span class="btn-icon-wrap">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    </button>
                                </td>

                            </tr>


                            <div class="modal fade" id="incModal{{ $incidente->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content shadow-sm border-0 rounded-3">

                                        <div class="modal-header" style="background:#e0f2fe;color:#0369a1;">
                                            <h5 class="modal-title">
                                                <i class="fas fa-eye me-2"></i>Detalle Incidente
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row g-3">

                                                <div class="col-md-6"><strong>Chofer:</strong> {{ $incidente->conductor_nombre }}</div>
                                                <div class="col-md-6"><strong>Ruta:</strong> {{ $incidente->ruta }}</div>
                                                <div class="col-md-6"><strong>Bus:</strong> {{ $incidente->bus_numero }}</div>
                                                <div class="col-md-6"><strong>Motivo:</strong> {{ $incidente->tipo_incidente }}</div>

                                                <div class="col-12">
                                                    <strong>Descripción:</strong> {{ $incidente->descripcion }}
                                                </div>

                                                @if($incidente->acciones_tomadas)
                                                    <div class="col-12">
                                                        <strong>Acciones Tomadas:</strong> {{ $incidente->acciones_tomadas }}
                                                    </div>
                                                @endif

                                                <div class="col-12">
                                                    <strong>Fecha:</strong>
                                                    {{ $incidente->fecha_hora ? \Carbon\Carbon::parse($incidente->fecha_hora)->format('d/m/Y H:i') : '—' }}
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                                                Cerrar
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-exclamation-circle fa-2x mb-2 d-block"></i>
                                    <span class="fw-semibold d-block">No hay incidentes registrados</span>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>


                <div class="d-flex justify-content-center mt-4">
                    {{ $incidentes->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>

    <style>
        .inc-avatar{
            width:32px;
            height:32px;
            border-radius:7px;
            background:linear-gradient(135deg,#0ea5e9,#0284c7);
            color:#fff;
            font-size:.72rem;
            font-weight:700;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .inc-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:36px;
            height:36px;
            border:none;
            border-radius:10px;
            cursor:pointer;
            background:linear-gradient(135deg,#3b82f6,#6366f1);
            color:#fff;
            transition:transform .2s ease,box-shadow .2s ease;
        }

        .inc-btn:hover{
            transform:translateY(-2px) scale(1.08);
            box-shadow:0 6px 16px rgba(99,102,241,.5);
        }

        .btn-icon-wrap{
            display:flex;
            align-items:center;
            justify-content:center;
            width:100%;
            height:100%;
            font-size:14px;
        }


        .pagination{
            gap:6px;
        }

        .pagination .page-link{
            border-radius:8px;
            border:none;
            color:#1e63b8;
            font-weight:600;
            padding:6px 12px;
            transition:all .2s ease;
        }

        .pagination .page-link:hover{
            background:#e0f2fe;
            color:#0369a1;
            transform:translateY(-1px);
        }

        .pagination .page-item.active .page-link{
            background:linear-gradient(135deg,#3b82f6,#6366f1);
            color:#fff;
            box-shadow:0 4px 10px rgba(59,130,246,.4);
        }

        .pagination .page-item.disabled .page-link{
            color:#9ca3af;
            background:#f3f4f6;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded',function(){
            const inputSearch=document.getElementById('inc-search');
            const selectChofer=document.getElementById('inc-fchofer');
            const inputFecha=document.getElementById('inc-fdate');
            const btnClear=document.getElementById('inc-clear');
            const filas=document.querySelectorAll('#inc-body tr[data-search]');

            function filtrar(){
                const q=inputSearch.value.toLowerCase().trim();
                const ch=selectChofer.value.toLowerCase();
                const dt=inputFecha.value;

                filas.forEach(fila=>{
                    const coincideSearch=!q||fila.dataset.search.includes(q);
                    const coincideChofer=!ch||fila.dataset.chofer===ch;
                    const coincideFecha=!dt||fila.dataset.date===dt;
                    fila.style.display=(coincideSearch&&coincideChofer&&coincideFecha)?'':'none';
                });
            }

            inputSearch.addEventListener('input',filtrar);
            selectChofer.addEventListener('change',filtrar);
            inputFecha.addEventListener('change',filtrar);

            btnClear.addEventListener('click',function(){
                inputSearch.value='';
                selectChofer.value='';
                inputFecha.value='';
                filtrar();
            });
        });
    </script>

@endsection

