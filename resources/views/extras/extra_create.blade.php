@extends('layouts.layoutuser')

@section('title', 'Agregar Servicios Adicionales')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-concierge-bell me-2"></i> Agregar Servicios Adicionales
                </h4>
                <span class="text-white small">Seleccione los servicios para su reserva activa</span>
            </div>

            <div class="card-body">

                {{-- FORMULARIO BÚSQUEDA --}}
                <form method="GET" action="{{ route('servicios_reserva.create') }}" class="mb-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Buscar servicio</label>
                            <input type="text" name="buscar" class="form-control"
                                   placeholder="Nombre del servicio..."
                                   value="{{ request('buscar') }}">
                        </div>
                        <div class="col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                            @if(request()->has('buscar') && request('buscar') != '')
                                <a href="{{ route('servicios_reserva.create') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                {{-- ALERTA --}}
                <div class="alert alert-warning" role="alert">
                    ¡Atención! Solo podrás seleccionar servicios adicionales si tienes una reserva de viaje activa.
                    Si no tienes una reserva vigente, no podrás utilizar esta pantalla.
                </div>

                {{-- FORMULARIO POST PARA GUARDAR --}}
                <form action="{{ route('servicios_reserva.store') }}" method="POST">
                    @csrf

                    {{-- SELECT RESERVA --}}
                    <div class="col-4 mb-3">
                        <label class="form-label fw-bold">Seleccione código de reserva del viaje</label>
                        <select name="reserva_id" class="form-select @error('reserva_id') is-invalid @enderror" id="reserva_id">
                            <option value="">-- Seleccione --</option>
                            @foreach($reservas as $reserva)
                                @if(!$reserva->servicios_extras)
                                    <option value="{{ $reserva->id }}" {{ old('reserva_id') == $reserva->id ? 'selected' : '' }}>
                                        {{ $reserva->codigo_reserva }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('reserva_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FILTRO Y TOTAL SERVICIOS --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold">Mostrar:</label>
                            <select name="perPage" class="form-select form-select-sm border-primary" style="width:90px;"
                                    onchange="this.form.submit()">
                                @foreach([5,10,25,50] as $option)
                                    <option value="{{ $option }}" {{ request('perPage', 5) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            <span>registros</span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted">
                                Total: {{ $extras->total() }} servicios
                            </small>

                            {{-- BOTÓN GUARDAR --}}
                            <button type="button" id="btn-guardar" class="btn btn-primary btn-sm" style="display: none;"
                                    data-bs-toggle="modal" data-bs-target="#confirmModal">
                                <i class="fas fa-save me-1"></i> Guardar
                            </button>
                        </div>
                    </div>

                    {{-- TARJETAS DE SERVICIOS --}}
                    <div class="row g-3">
                        @forelse($extras as $extra)
                            <div class="col-md-4">
                                <div class="card h-100 text-center shadow-sm">
                                    <img src="{{ asset('storage/' . $extra->imagen) }}" class="card-img-top p-3 img-fluid" alt="{{ $extra->nombre }}" style="max-height:150px; object-fit:contain;">
                                    <div class="card-body d-flex flex-column align-items-center py-2"
                                         style="background-color: #f5f5f5; border-top: 1px solid #dee2e6;">
                                        <h5 class="card-title mb-1">{{ $extra->nombre }}</h5>
                                        <p class="mb-2 text-center small">{{ $extra->descripcion }}</p>
                                        <div class="form-check form-switch w-50 d-flex justify-content-center">
                                            <input class="form-check-input servicio-checkbox w-100" type="checkbox" name="extras_seleccionados[]" value="{{ $extra->id }}" id="extra{{ $extra->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                No hay servicios adicionales disponibles.
                            </div>
                        @endforelse
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Mostrando
                            <span class="fw-semibold text-dark">{{ $extras->firstItem() ?? 0 }}</span>
                            –
                            <span class="fw-semibold text-dark">{{ $extras->lastItem() ?? 0 }}</span>
                            de
                            <span class="fw-semibold text-dark">{{ $extras->total() }}</span>
                            servicios
                        </div>

                        @if($extras->hasPages())
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item {{ $extras->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $extras->appends(request()->all())->previousPageUrl() }}">Anterior</a>
                                    </li>
                                    @for($page = 1; $page <= $extras->lastPage(); $page++)
                                        <li class="page-item {{ $page == $extras->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $extras->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $extras->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $extras->appends(request()->all())->nextPageUrl() }}">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>

                    {{-- MODAL DE CONFIRMACIÓN --}}
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Está seguro de agregar estos servicios adicionales a su reserva de viaje?
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Sí, agregar</button>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- ESTILOS --}}
    <style>
        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            margin: 0 2px;
        }
        .pagination .page-link:hover { background-color: #1e63b8; color: #fff; }
        .pagination .page-item.active .page-link { background-color: #1e63b8; border-color: #1e63b8; color: #fff; }
        .pagination .page-item.disabled .page-link { color: #9ca3af; background: #f3f4f6; border-color: #e5e7eb; }
    </style>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnGuardar = document.getElementById('btn-guardar');
            const reserva = document.getElementById('reserva_id');
            const checkboxes = document.querySelectorAll('.servicio-checkbox');

            function mostrarBoton() {
                const reservaSeleccionada = reserva.value !== "";
                const alMenosUnoSeleccionado = Array.from(checkboxes).some(cb => cb.checked);
                btnGuardar.style.display = (reservaSeleccionada && alMenosUnoSeleccionado) ? 'inline-block' : 'none';
            }

            mostrarBoton();

            reserva.addEventListener('change', mostrarBoton);
            checkboxes.forEach(cb => cb.addEventListener('change', mostrarBoton));
        });
    </script>
@endsection
