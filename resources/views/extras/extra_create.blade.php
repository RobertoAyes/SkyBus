@extends('layouts.layoutuser')

@section('title', 'Agregar Servicios Adicionales')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-concierge-bell me-2"></i> Servicios Adicionales
                </h2>
                <span class="text-muted small">Seleccione los servicios para su reserva activa</span>
            </div>

            <div class="card-body">

                {{-- BUSCADOR --}}
                <form method="GET" action="{{ route('servicios_reserva.create') }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda General</label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <input type="text" name="buscar" class="form-control"
                                       placeholder="Buscar servicio..."
                                       value="{{ request('buscar') }}">
                            </div>
                            <div class="col-md-5 d-flex align-items-end gap-2">
                                <button class="btn btn-primary flex-fill" type="submit">
                                    <i class="fas fa-search me-2"></i>Buscar
                                </button>

                                @if(request('buscar'))
                                    <a href="{{ route('servicios_reserva.create') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="fas fa-times me-2"></i>Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>

                {{-- ALERTA DE RESERVA --}}
                <div class="alert alert-warning d-flex align-items-center">
                    <i class="fas fa-circle-exclamation me-2"></i>
                    Solo puedes seleccionar servicios si tienes una reserva activa.
                </div>

                {{-- MENSAJE SOBRE MÁXIMO 3 SERVICIOS --}}
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Recuerde: solo puede seleccionar hasta <strong>3 servicios adicionales</strong> por reserva.
                </div>

                {{-- FORM --}}
                <form action="{{ route('servicios_reserva.store') }}" method="POST">
                    @csrf

                    {{-- SELECT RESERVA --}}
                    <div class="col-4 mb-3">
                        <label class="form-label fw-bold">Seleccione código de reserva</label>
                        <select name="reserva_id" id="reserva_id"
                                class="form-select @error('reserva_id') is-invalid @enderror">
                            <option value="">-- Seleccione --</option>
                            @foreach($reservas as $reserva)
                                @if(!$reserva->servicios_extras)
                                    <option value="{{ $reserva->id }}">
                                        {{ $reserva->codigo_reserva }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- MOSTRAR + BOTÓN --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="fw-semibold">Mostrar:</label>
                            <select name="perPage" class="form-select form-select-sm border-primary"
                                    style="width:90px;" onchange="this.form.submit()">
                                @foreach([5,10,25,50] as $n)
                                    <option value="{{ $n }}" {{ request('perPage') == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" id="btn-guardar"
                                class="btn btn-primary btn-sm"
                                style="display:none;"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmModal">
                            <i class="fas fa-save me-1"></i> Guardar
                        </button>
                    </div>

                    {{-- TABLA --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary">
                            <tr>
                                <th style="width:60px;" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th class="text-center">Imagen</th>
                                <th class="text-center">Seleccionar</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($extras as $key => $extra)
                                <tr>
                                    <td class="text-center">
                                        {{ ($extras->currentPage()-1)*$extras->perPage()+$key+1 }}
                                    </td>

                                    <td>{{ $extra->nombre }}</td>
                                    <td>{{ $extra->descripcion }}</td>

                                    <td class="text-center">
                                        @if($extra->imagen)
                                            <img src="{{ asset('storage/'.$extra->imagen) }}"
                                                 style="height:60px; width:80px; object-fit:cover;">
                                        @else
                                            —
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <input type="checkbox"
                                               class="form-check-input servicio-checkbox"
                                               name="extras_seleccionados[]"
                                               value="{{ $extra->id }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fas fa-concierge-bell fa-2x mb-2 d-block"></i>
                                        No hay servicios disponibles
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINACIÓN CORREGIDA --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Mostrando
                            <span class="fw-semibold text-dark">{{ $extras->firstItem() ?? 0 }}</span>
                            –
                            <span class="fw-semibold text-dark">{{ $extras->lastItem() ?? 0 }}</span>
                            de
                            <span class="fw-semibold text-dark">{{ $extras->total() }}</span>
                            registros
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
                    <div class="modal fade" id="confirmModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5>Confirmación</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    ¿Desea agregar estos servicios?
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Sí</button>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL ALERTA MÁXIMO 3 --}}
                    <div class="modal fade" id="max3Modal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title">Límite alcanzado</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    Solo puedes seleccionar un máximo de <strong>3 servicios adicionales</strong>.
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btn-guardar');
            const reserva = document.getElementById('reserva_id');
            const checks = document.querySelectorAll('.servicio-checkbox');

            const max3Modal = new bootstrap.Modal(document.getElementById('max3Modal'));

            function toggleBtn() {
                const okReserva = reserva.value !== "";
                const seleccionados = Array.from(checks).filter(c => c.checked);
                const alguno = seleccionados.length > 0;

                // Limitar máximo 3 servicios y mostrar modal
                if (seleccionados.length > 3) {
                    seleccionados[seleccionados.length - 1].checked = false;
                    max3Modal.show();
                }

                btn.style.display = (okReserva && alguno) ? 'inline-block' : 'none';
            }

            reserva.addEventListener('change', toggleBtn);
            checks.forEach(c => c.addEventListener('change', toggleBtn));
        });
    </script>

    {{-- ESTILOS DE PAGINACIÓN --}}
    <style>
        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            margin: 0 2px;
        }
        .pagination .page-link:hover {
            background-color: #1e63b8;
            color: #fff;
        }
        .pagination .page-item.active .page-link {
            background-color: #1e63b8;
            border-color: #1e63b8;
            color: #fff;
        }
        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
            background: #f3f4f6;
            border-color: #e5e7eb;
        }

        .table {
            table-layout: fixed;
            width: 100%;
        }
    </style>

@endsection
