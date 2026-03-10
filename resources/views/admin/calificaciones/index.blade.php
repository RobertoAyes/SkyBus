@extends('layouts.layoutadmin')

@section('title', 'Calificaciones de Choferes')

@section('content')
    @php $estadisticas = $estadisticas ?? collect(); @endphp

    <div class="container mt-4">

        {{-- STATS --}}
        @php
            $totalEvals    = 0;
            $sumaPromedios = 0;
            $mejorChofer   = null;
            $mejorProm     = 0;
            foreach($estadisticas as $ch) {
                $prom = $ch->calificaciones_recibidas_avg_estrellas ?? 0;
                $cnt  = $ch->calificaciones_recibidas_count ?? 0;
                $totalEvals    += $cnt;
                $sumaPromedios += $prom;
                if ($prom > $mejorProm) { $mejorProm = $prom; $mejorChofer = $ch; }
            }
            $total           = $estadisticas->count();
            $promedioGeneral = $total > 0 ? $sumaPromedios / $total : 0;
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:38px;height:38px;background:#dbeafe;color:#1d4ed8;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5" style="color:#0c1a2e;">{{ $total }}</div>
                            <div class="text-muted" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Conductores</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:38px;height:38px;background:#fef9c3;color:#b45309;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5" style="color:#0c1a2e;">{{ number_format($promedioGeneral, 1) }}</div>
                            <div class="text-muted" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Promedio gral.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:38px;height:38px;background:#ede9fe;color:#6d28d9;">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5" style="color:#0c1a2e;">{{ $totalEvals }}</div>
                            <div class="text-muted" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Evaluaciones</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:38px;height:38px;background:#dcfce7;color:#15803d;">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="color:#0c1a2e;font-size:.9rem;line-height:1.3;">
                                {{ $mejorChofer ? \Illuminate\Support\Str::limit($mejorChofer->name, 14) : '—' }}
                            </div>
                            <div class="text-muted" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Mejor calificado</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- ===== TABLA COMENTARIOS ===== --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-comments me-2"></i>Comentarios de Usuarios
                </h2>
            </div>
            <div class="card-body">

                {{-- Filtros comentarios --}}
                <div class="card border-0 shadow-sm mb-4" style="background:#f8faff;">
                    <div class="card-body py-3">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-search me-1"></i>Buscar
                                </label>
                                <input type="text" id="fil-comentario" class="form-control form-control-sm" placeholder="Chofer, cliente, comentario...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-star me-1"></i>Estrellas
                                </label>
                                <select id="fil-estrellas" class="form-select form-select-sm">
                                    <option value="">Todas</option>
                                    <option value="5">5 ⭐</option>
                                    <option value="4">4 ⭐</option>
                                    <option value="3">3 ⭐</option>
                                    <option value="2">2 ⭐</option>
                                    <option value="1">1 ⭐</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button id="btn-clear2" class="btn btn-outline-secondary btn-sm w-100">
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
                            <th>Cliente</th>
                            <th class="text-center">Estrellas</th>
                            <th>Comentario</th>
                        </tr>
                        </thead>
                        <tbody id="tbody-comentarios">
                        @php $hayComentarios = false; @endphp
                        @foreach($estadisticas as $chofer)
                            @foreach($chofer->calificacionesRecibidas as $cal)
                                @php $hayComentarios = true; @endphp
                                <tr data-search="{{ strtolower($chofer->name.' '.($cal->usuario->name ?? '').' '.($cal->comentario ?? '')) }}"
                                    data-estrellas="{{ $cal->estrellas }}">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="itn-avatar">{{ strtoupper(substr($chofer->name, 0, 2)) }}</div>
                                            <span class="fw-semibold" style="color:#1e3a5f;">{{ $chofer->name }}</span>
                                        </div>
                                    </td>
                                    <td style="font-size:.85rem;font-weight:500;color:#1e3a5f;">
                                        {{ $cal->usuario->name ?? '—' }}
                                    </td>
                                    <td class="text-center">
                                        <span style="color:#fbbf24;font-size:.85rem;">
                                            @for($s = 1; $s <= 5; $s++)
                                                <i class="fas fa-star" style="{{ $s > $cal->estrellas ? 'opacity:.2;' : '' }}"></i>
                                            @endfor
                                        </span>
                                        <div class="text-muted" style="font-size:.7rem;">{{ $cal->estrellas }}/5</div>
                                    </td>
                                    <td style="font-size:.82rem;color:#64748b;max-width:260px;">
                                        {{ $cal->comentario ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        @if(!$hayComentarios)
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fas fa-comments fa-2x mb-2 d-block"></i>
                                    <span class="fw-semibold d-block">Sin comentarios aún</span>
                                    <small>Aquí aparecerán las reseñas de los usuarios</small>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div id="sin-resultados2" class="text-center text-muted py-4" style="display:none;">
                        <i class="fas fa-search fa-2x mb-2 d-block"></i>
                        No se encontraron comentarios con los filtros aplicados.
                    </div>
                </div>

            </div>
        </div>
        {{-- ===== FIN TABLA COMENTARIOS ===== --}}

    </div>

    <style>
        .itn-avatar {
            width: 32px; height: 32px; border-radius: 7px;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: #fff; font-size: .72rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputComentario = document.getElementById('fil-comentario');
            const selectEstrellas = document.getElementById('fil-estrellas');
            const btnClear2       = document.getElementById('btn-clear2');
            const filasC          = document.querySelectorAll('#tbody-comentarios tr[data-search]');
            const sinRes2         = document.getElementById('sin-resultados2');

            function filtrarComentarios() {
                const q  = inputComentario.value.toLowerCase().trim();
                const es = selectEstrellas.value;
                let visibles = 0;

                filasC.forEach(function(fila) {
                    const coincide = (!q  || fila.dataset.search.includes(q))
                        && (!es || fila.dataset.estrellas === es);
                    if (coincide) { fila.style.display = ''; visibles++; }
                    else          { fila.style.display = 'none'; }
                });
                sinRes2.style.display = (filasC.length > 0 && visibles === 0) ? 'block' : 'none';
            }

            inputComentario.addEventListener('input', filtrarComentarios);
            selectEstrellas.addEventListener('change', filtrarComentarios);
            btnClear2.addEventListener('click', function () {
                inputComentario.value  = '';
                selectEstrellas.value  = '';
                filtrarComentarios();
            });
        });
    </script>
@endsection
