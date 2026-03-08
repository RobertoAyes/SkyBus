@extends('layouts.layoutadmin')

@section('title', 'Panel Administrativo')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-road me-2"></i>Listado de Rutas
                </h2>
            </div>

            <div class="card-body">

                <a href="{{ route('rutas.create') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-lg"></i> Nueva Ruta
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
                                    <i class="fas fa-location-arrow me-1"></i>Origen
                                </label>
                                <input type="text" id="filtroOrigen" class="form-control form-control-sm" placeholder="Buscar por origen...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-map-marker-alt me-1"></i>Destino
                                </label>
                                <input type="text" id="filtroDestino" class="form-control form-control-sm" placeholder="Buscar por destino...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-muted small mb-1">
                                    <i class="fas fa-toggle-on me-1"></i>Estado
                                </label>
                                <select id="filtroEstado" class="form-select form-select-sm">
                                    <option value="">Todos</option>
                                    <option value="activa">Activa</option>
                                    <option value="bloqueada">Bloqueada</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button id="btnLimpiarFiltros" class="btn btn-outline-secondary btn-sm w-100">
                                    <i class="fas fa-times me-1"></i>Limpiar filtros
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="tablaRutas">
                        <thead class="table-primary">
                        <tr>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Distancia</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoTabla">
                        @forelse($rutas as $ruta)
                            <tr>
                                <td>{{ $ruta->origen }}</td>
                                <td>{{ $ruta->destino }}</td>
                                <td>{{ $ruta->distancia }} km</td>
                                <td>{{ $ruta->duracion_estimada }} min</td>
                                <td>
                                    @if($ruta->estado)
                                        <span class="badge bg-success">Activa</span>
                                    @else
                                        <span class="badge bg-danger">Bloqueada</span>
                                    @endif
                                </td>
                                <td class="text-center">

                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $ruta->id }}">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>

                                    <form action="{{ route('rutas.bloquear', $ruta->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')

                                        @if($ruta->estado)
                                            <button class="btn btn-sm btn-bloquear">
                                                <i class="fas fa-ban"></i> Bloquear
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm btn-activar">
                                                <i class="fas fa-check"></i> Activar
                                            </button>
                                        @endif
                                    </form>

                                    {{-- MODAL EDITAR --}}
                                    <div class="modal fade" id="editModal{{ $ruta->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $ruta->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-sm border-0">

                                                <div class="modal-header bg-white border-bottom-0">
                                                    <h5 class="modal-title" id="editModalLabel{{ $ruta->id }}" style="color:#1e63b8; font-weight:600; font-size:1.5rem;">
                                                        <i class="fas fa-road me-2"></i>Editar Ruta
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('rutas.update', $ruta->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-bold"><i class="fas fa-location-arrow me-1"></i>Origen</label>
                                                            <input type="text" name="origen" class="form-control"
                                                                   value="{{ old('origen', $ruta->origen) }}"
                                                                   onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                                                                   required>
                                                            @error('origen')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-bold"><i class="fas fa-map-marker-alt me-1"></i>Destino</label>
                                                            <input type="text" name="destino" class="form-control"
                                                                   value="{{ old('destino', $ruta->destino) }}"
                                                                   onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                                                                   required>
                                                            @error('destino')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-bold"><i class="fas fa-road me-1"></i>Distancia (km)</label>
                                                            <input type="number" step="0.01" name="distancia" class="form-control" value="{{ old('distancia', $ruta->distancia) }}" min="5" required>
                                                            @error('distancia')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-bold"><i class="fas fa-clock me-1"></i>Duración estimada (min)</label>
                                                            <input type="number" name="duracion_estimada" class="form-control" value="{{ old('duracion_estimada', $ruta->duracion_estimada) }}" min="15" required>
                                                            @error('duracion_estimada')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="d-flex justify-content-between mt-4">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Cancelar
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-save me-1"></i>Guardar Cambios
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-road fa-2x mb-2 d-block"></i>No hay rutas registradas
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{-- Mensaje sin resultados (filtro) --}}
                    <div id="sinResultados" class="text-center text-muted py-4" style="display:none;">
                        <i class="fas fa-search fa-2x mb-2 d-block"></i>
                        No se encontraron rutas con los filtros aplicados.
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Botón Bloquear en color naranja/amber */
        .btn-bloquear {
            background-color: #f59e0b;
            border-color: #d97706;
            color: #fff;
        }
        .btn-bloquear:hover {
            background-color: #d97706;
            border-color: #b45309;
            color: #fff;
        }

        /* Ancho fijo para que no cambie al alternar Bloquear/Activar */
        .btn-bloquear,
        .btn-activar {
            width: 100px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputOrigen  = document.getElementById('filtroOrigen');
            const inputDestino = document.getElementById('filtroDestino');
            const selectEstado = document.getElementById('filtroEstado');
            const btnLimpiar   = document.getElementById('btnLimpiarFiltros');
            const filas        = document.querySelectorAll('#cuerpoTabla tr');
            const sinResultados = document.getElementById('sinResultados');

            function filtrar() {
                const origen  = inputOrigen.value.toLowerCase().trim();
                const destino = inputDestino.value.toLowerCase().trim();
                const estado  = selectEstado.value.toLowerCase();

                let visibles = 0;

                filas.forEach(function (fila) {
                    // Fila vacía (forelse empty)
                    if (fila.querySelector('td[colspan]')) return;

                    const celdas      = fila.querySelectorAll('td');
                    const textoOrigen  = celdas[0] ? celdas[0].textContent.toLowerCase() : '';
                    const textoDestino = celdas[1] ? celdas[1].textContent.toLowerCase() : '';
                    const textoEstado  = celdas[4] ? celdas[4].textContent.toLowerCase().trim() : '';

                    const coincideOrigen  = textoOrigen.includes(origen);
                    const coincideDestino = textoDestino.includes(destino);
                    const coincideEstado  = estado === '' || textoEstado.includes(estado);

                    if (coincideOrigen && coincideDestino && coincideEstado) {
                        fila.style.display = '';
                        visibles++;
                    } else {
                        fila.style.display = 'none';
                    }
                });

                sinResultados.style.display = visibles === 0 ? 'block' : 'none';
            }

            inputOrigen.addEventListener('input', filtrar);
            inputDestino.addEventListener('input', filtrar);
            selectEstado.addEventListener('change', filtrar);

            btnLimpiar.addEventListener('click', function () {
                inputOrigen.value  = '';
                inputDestino.value = '';
                selectEstado.value = '';
                filtrar();
            });
        });
    </script>
@endsection
