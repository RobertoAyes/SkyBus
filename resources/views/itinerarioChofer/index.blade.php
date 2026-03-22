@extends('layouts.layoutadmin')

@section('title', 'Itinerarios de Choferes')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-calendar-alt me-2"></i>Itinerarios de Choferes
                </h2>
            </div>

            <div class="card-body">

                <a href="{{ route('itinerarioChofer.create') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-lg"></i> Asignar Itinerario
                </a>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                {{-- FILTROS DE BÚSQUEDA --}}
                <div class="card border-0 shadow-sm mb-4" style="background: #f8faff;">
                    <div class="card-body py-3">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-search me-1"></i>Buscar
                                </label>
                                <input type="text" id="itn-search" class="form-control form-control-sm" placeholder="Chofer, ruta...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-user-tie me-1"></i>Chofer
                                </label>
                                <select id="itn-fchofer" class="form-select form-select-sm">
                                    <option value="">Todos los choferes</option>
                                    @foreach($itinerarios->unique('chofer_id') as $it)
                                        <option value="{{ strtolower($it->chofer->name ?? '') }}">{{ $it->chofer->name ?? 'Sin chofer' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-calendar me-1"></i>Fecha
                                </label>
                                <input type="date" id="itn-fdate" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <button id="itn-clear" class="btn btn-outline-secondary btn-sm w-100">
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
                            <th>Paradas y tiempo de espera</th>
                            <th>Fecha y Hora</th>
                            <th class="text-center">Acción</th>
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
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="itn-avatar">{{ strtoupper(substr($itinerario->chofer->name ?? 'S', 0, 2)) }}</div>
                                        <span class="fw-semibold" style="color:#1e3a5f;">{{ $itinerario->chofer->name ?? 'Sin chofer' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill" style="background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd; font-size:.78rem; padding:.35rem .75rem; font-weight:600;">
                                        <i class="fas fa-map-marker-alt me-1" style="opacity:.5;"></i>
                                        {{ $itinerario->ruta->origen ?? '?' }}
                                        <i class="fas fa-long-arrow-alt-right mx-1" style="opacity:.5;"></i>
                                        {{ $itinerario->ruta->destino ?? '?' }}
                                    </span>
                                </td>
                                <td>
                                    @if($itinerario->paradas && $itinerario->paradas->count() > 0)
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($itinerario->paradas as $parada)
                                                <div class="d-flex align-items-center gap-2" style="background:#f8fbff; border:1px solid #e2edf8; border-radius:6px; padding:.28rem .55rem;">
                                                    <span style="width:18px; height:18px; border-radius:50%; background:#e0f2fe; color:#0284c7; font-size:.62rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">{{ $loop->iteration }}</span>
                                                    <span style="font-size:.78rem; color:#1e3a5f; font-weight:500; flex:1;">{{ $parada->lugar_parada }}</span>
                                                    <span style="font-size:.68rem; background:#e0f2fe; color:#0284c7; border-radius:4px; padding:.08rem .35rem; white-space:nowrap;">{{ $parada->tiempo_parada }} min</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic" style="font-size:.8rem;">Sin paradas</span>
                                    @endif
                                </td>
                                <td>
                                    @if($itinerario->fecha)
                                        <span class="fw-semibold d-block" style="color:#1e3a5f; font-size:.85rem;">
                                            {{ \Carbon\Carbon::parse($itinerario->fecha)->format('d M Y') }}
                                        </span>
                                        <span class="text-muted" style="font-size:.78rem;">
                                            {{ \Carbon\Carbon::parse($itinerario->fecha)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">


                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('itinerarioChofer.edit', $itinerario->id) }}"
                                           class="itn-btn itn-btn-edit"
                                           title="Editar itinerario">
                                            <span class="btn-icon-wrap">
                                                <i class="fas fa-pen-to-square"></i>
                                            </span>
                                        </a>
                                        <button type="button"
                                                class="itn-btn itn-btn-delete"
                                                title="Eliminar itinerario"
                                                data-bs-toggle="modal"
                                                data-bs-target="#itnDel{{ $itinerario->id }}">
      <span class="btn-icon-wrap">
        <i class="fas fa-trash-can"></i>
      </span>
                                        </button>
                                    </div>



                                </td>
                            </tr>

                            {{-- MODAL ELIMINAR --}}
                            <div class="modal fade" id="itnDel{{ $itinerario->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content shadow-sm border-0">
                                        <div class="modal-header" style="background:#fff5f5; border-bottom:1px solid #fee2e2;">
                                            <h5 class="modal-title" style="color:#991b1b; font-size:.9rem; font-weight:700;">
                                                <i class="fas fa-exclamation-triangle me-2"></i>Eliminar itinerario
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="font-size:.84rem; color:#2d5a8e; line-height:1.6;">
                                            ¿Eliminar el itinerario de <strong>{{ $itinerario->chofer->name ?? 'Sin chofer' }}</strong>
                                            en la ruta <strong>{{ $itinerario->ruta->origen ?? '' }} → {{ $itinerario->ruta->destino ?? '' }}</strong>
                                            del <strong>{{ $itinerario->fecha ? \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}</strong>?
                                            <br><br>
                                            <span style="font-size:.75rem; color:#94a3b8;">Esta acción no se puede deshacer.</span>
                                        </div>
                                        <div class="modal-footer gap-2">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Cancelar
                                            </button>
                                            <form action="{{ route('itinerarioChofer.destroy', $itinerario->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt me-1"></i>Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                                    <span class="fw-semibold d-block">Sin itinerarios asignados</span>
                                    <small>Empieza asignando un itinerario a un chofer</small>
                                </td>
                            </tr>
                        @endforelse

                        <tr id="itn-no-results" style="display:none;">
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                No se encontraron itinerarios con los filtros aplicados.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <style>
        .itn-avatar {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: #fff;
            font-size: .72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .itn-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1),
            box-shadow 0.2s ease;
        }

        .btn-icon-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        /* Botón Editar — azul moderno */
        .itn-btn-edit {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #fff;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.35);
        }

        .itn-btn-edit:hover {
            color: #fff;
            transform: translateY(-2px) scale(1.08);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.5);
        }

        .itn-btn-edit:hover .btn-icon-wrap {
            transform: rotate(-8deg);
        }

        .itn-btn-edit:active {
            transform: scale(0.95);
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
        }

        /* Botón Eliminar — rojo con shimmer */
        .itn-btn-delete {
            background: linear-gradient(135deg, #ef4444, #f97316);
            color: #fff;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.35);
        }

        .itn-btn-delete:hover {
            color: #fff;
            transform: translateY(-2px) scale(1.08);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.5);
        }

        .itn-btn-delete:hover .btn-icon-wrap {
            animation: shake 0.3s ease;
        }

        .itn-btn-delete:active {
            transform: scale(0.95);
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
        }

        @keyframes shake {
            0%   { transform: rotate(0deg); }
            25%  { transform: rotate(-10deg); }
            75%  { transform: rotate(10deg); }
            100% { transform: rotate(0deg); }
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputSearch = document.getElementById('itn-search');
            const selectChofer = document.getElementById('itn-fchofer');
            const inputFecha = document.getElementById('itn-fdate');
            const btnLimpiar = document.getElementById('itn-clear');
            const filas = document.querySelectorAll('#itn-body tr[data-search]');
            const sinResultados = document.getElementById('itn-no-results');

            function filtrar() {
                const q = inputSearch.value.toLowerCase().trim();
                const ch = selectChofer.value.toLowerCase();
                const dt = inputFecha.value;

                let visibles = 0;

                filas.forEach(function (fila) {
                    const coincideSearch = !q  || fila.dataset.search.includes(q);
                    const coincideChofer = !ch || fila.dataset.chofer === ch;
                    const coincideFecha  = !dt || fila.dataset.date === dt;

                    if (coincideSearch && coincideChofer && coincideFecha) {
                        fila.style.display = '';
                        visibles++;
                    } else {
                        fila.style.display = 'none';
                    }
                });

                sinResultados.style.display = visibles === 0 ? '' : 'none';
            }

            inputSearch.addEventListener('input', filtrar);
            selectChofer.addEventListener('change', filtrar);
            inputFecha.addEventListener('change', filtrar);

            btnLimpiar.addEventListener('click', function () {
                inputSearch.value = '';
                selectChofer.value = '';
                inputFecha.value = '';
                filtrar();
            });
        });
    </script>
@endsection
