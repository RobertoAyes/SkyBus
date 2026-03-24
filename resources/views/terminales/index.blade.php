@extends('layouts.layoutadmin')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-lg border-0 rounded-0 w-100">

            {{-- Encabezado --}}
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#ffffff;">
                <h2 style="margin:0; color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-bus me-2"></i>Terminales
                </h2>
                <button class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#modalCrear">
                    <i class="fas fa-plus me-1"></i>Nueva Terminal
                </button>
            </div>

            <div class="card-body" style="min-height: 70vh;">

                {{-- Mensaje éxito --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Búsqueda --}}
                <form method="GET" action="{{ route('terminales.index') }}" class="mb-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Búsqueda General</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                        </div>
                        <div class="col-md-5 d-flex align-items-end gap-2">
                            <button class="btn btn-primary flex-fill" type="submit">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                            <button class="btn btn-outline-primary flex-fill" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>
                            @if(request()->hasAny(['nombre','contacto','ubicacion']))
                                <a href="{{ route('terminales.index') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="collapse" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary"><i class="fas fa-filter me-2"></i>Filtros Adicionales</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold"><i class="fas fa-phone-alt text-success me-2"></i>Contacto</label>
                                        <input type="text" name="contacto" class="form-control" placeholder="Teléfono o correo" value="{{ request('contacto') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold"><i class="fas fa-map-marker-alt text-primary me-2"></i>Ubicación</label>
                                        <input type="text" name="ubicacion" class="form-control" placeholder="Departamento" value="{{ request('ubicacion') }}">
                                    </div>
                                    {{-- Selector de registros por página --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold"><i class="fas fa-list-ol text-secondary me-2"></i>Registros por página</label>
                                        <select name="perPage" class="form-select" onchange="this.form.submit()">
                                            @foreach([5, 10, 25, 50] as $n)
                                                <option value="{{ $n }}" {{ request('perPage', 10) == $n ? 'selected' : '' }}>
                                                    {{ $n }} registros
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mantener perPage en búsqueda general --}}
                    <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                </form>

                {{-- Tabla --}}
                <div class="table-responsive w-100">
                    <table class="table table-hover table-bordered w-100 align-middle text-center">
                        <thead class="table-primary">
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Contacto</th>
                            <th>Horario</th>
                            <th>Servs. Disponibles</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($terminales as $key => $terminal)
                            <tr>
                                <td>{{ ($terminales->currentPage() - 1) * $terminales->perPage() + $key + 1 }}</td>
                                <td>{{ $terminal->codigo }}</td>
                                <td>{{ $terminal->nombre }}</td>
                                <td><strong>{{ $terminal->departamento }}</strong></td>
                                <td>
                                    {{ $terminal->telefono }}<br>

                                </td>
                                <td>
                                    @if($terminal->horario_apertura && $terminal->horario_cierre)
                                        {{ \Carbon\Carbon::parse($terminal->horario_apertura)->format('g:i A') }} -
                                        {{ \Carbon\Carbon::parse($terminal->horario_cierre)->format('g:i A') }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse($terminal->servicios as $servicio)
                                        {{ $servicio->nombre }}@if(!$loop->last), @endif
                                    @empty
                                        <span class="text-muted">N/A</span>
                                    @endforelse
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Botón Ver --}}
                                        <button class="btn btn-info btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalVer{{ $terminal->id }}">
                                            <i class="fas fa-eye me-1"></i>Ver
                                        </button>
                                        {{-- Botón Editar --}}
                                        <button type="button" class="btn btn-primary btn-sm btn-editar"
                                                data-id="{{ $terminal->id }}"
                                                data-nombre="{{ $terminal->nombre }}"
                                                data-departamento="{{ $terminal->departamento }}"
                                                data-municipio="{{ $terminal->municipio }}"
                                                data-codigo="{{ $terminal->codigo }}"
                                                data-direccion="{{ $terminal->direccion }}"
                                                data-latitud="{{ $terminal->latitud }}"
                                                data-longitud="{{ $terminal->longitud }}"
                                                data-telefono="{{ $terminal->telefono }}"
                                                data-correo="{{ $terminal->correo }}"
                                                data-horario-apertura="{{ $terminal->horario_apertura }}"
                                                data-horario-cierre="{{ $terminal->horario_cierre }}"
                                                data-descripcion="{{ $terminal->descripcion }}"
                                                data-servicios="{{ $terminal->servicios->pluck('nombre')->implode(',') }}">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- ================================================ --}}
                            {{-- MODAL VER TERMINAL                                 --}}
                            {{-- ================================================ --}}
                            <div class="modal fade" id="modalVer{{ $terminal->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3" style="overflow:hidden;">

                                        <div class="modal-header text-white border-0" style="background:#1e63b8; padding:1.25rem 1.5rem;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width:34px;height:34px;background:rgba(255,255,255,0.2);">
                                                    <i class="fas fa-bus" style="font-size:13px;"></i>
                                                </div>
                                                <span class="fw-500" style="font-size:15px;">Detalle de la terminal</span>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body" style="padding:1.5rem;">

                                            {{-- Cabecera nombre --}}
                                            <div class="d-flex align-items-center gap-3 pb-3 mb-3" style="border-bottom:0.5px solid #e5e7eb;">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-500"
                                                     style="width:48px;height:48px;background:#e6f1fb;color:#1e63b8;font-size:15px;flex-shrink:0;">
                                                    {{ strtoupper(substr($terminal->nombre, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-semibold" style="font-size:15px;">{{ $terminal->nombre }}</p>
                                                    <p class="mb-0 text-muted" style="font-size:12px;">{{ $terminal->codigo }}</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <span class="badge rounded-pill" style="background:#e6f1fb;color:#1e63b8;font-size:11px;padding:5px 12px;">
                                                        <i class="fas fa-bus me-1"></i>Terminal
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Datos principales --}}
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                        <p class="mb-1 text-uppercase text-muted" style="font-size:11px;letter-spacing:0.05em;">Departamento</p>
                                                        <p class="mb-0 fw-semibold" style="font-size:14px;">{{ $terminal->departamento }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                        <p class="mb-1 text-uppercase text-muted" style="font-size:11px;letter-spacing:0.05em;">Municipio</p>
                                                        <p class="mb-0 fw-semibold" style="font-size:14px;">{{ $terminal->municipio }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                        <p class="mb-1 text-uppercase text-muted" style="font-size:11px;letter-spacing:0.05em;">Teléfono</p>
                                                        <p class="mb-0 fw-semibold" style="font-size:14px;">
                                                            <i class="fas fa-phone-alt text-success me-1"></i>{{ $terminal->telefono }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                        <p class="mb-1 text-uppercase text-muted" style="font-size:11px;letter-spacing:0.05em;">Correo</p>
                                                        <p class="mb-0 fw-semibold" style="font-size:14px;">
                                                            <i class="fas fa-envelope text-secondary me-1"></i>{{ $terminal->correo }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                        <p class="mb-1 text-uppercase text-muted" style="font-size:11px;letter-spacing:0.05em;">Horario</p>
                                                        <p class="mb-0 fw-semibold" style="font-size:14px;">
                                                            @if($terminal->horario_apertura && $terminal->horario_cierre)
                                                                <i class="fas fa-clock text-primary me-1"></i>
                                                                {{ \Carbon\Carbon::parse($terminal->horario_apertura)->format('g:i A') }} –
                                                                {{ \Carbon\Carbon::parse($terminal->horario_cierre)->format('g:i A') }}
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rounded-3 p-3" style="background:#f8f9fa;">
                                                        <p class="mb-1 text-uppercase text-muted" style="font-size:11px;letter-spacing:0.05em;">Servicios</p>
                                                        <p class="mb-0 fw-semibold" style="font-size:14px;">
                                                            @forelse($terminal->servicios as $servicio)
                                                                {{ $servicio->nombre }}@if(!$loop->last), @endif
                                                            @empty
                                                                <span class="text-muted">N/A</span>
                                                            @endforelse
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Dirección --}}
                                            <div class="rounded-3 p-3 mb-3" style="background:#f8f9fa;">
                                                <p class="mb-1 text-uppercase text-muted" style="font-size:11px;letter-spacing:0.05em;">Dirección</p>
                                                <p class="mb-0" style="font-size:13px;line-height:1.6;">{{ $terminal->direccion ?? '—' }}</p>
                                            </div>

                                            {{-- Descripción --}}
                                            @if($terminal->descripcion)
                                                <div class="rounded-3 p-3" style="background:#e6f1fb;border-left:3px solid #1e63b8;">
                                                    <p class="mb-1 text-uppercase fw-semibold" style="font-size:11px;letter-spacing:0.05em;color:#1e63b8;">Descripción</p>
                                                    <p class="mb-0" style="font-size:13px;line-height:1.6;color:#0c2d5e;">{{ $terminal->descripcion }}</p>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="modal-footer border-top" style="border-color:#e5e7eb !important;padding:1rem 1.5rem;">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Cerrar
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- FIN MODAL VER --}}

                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                    No se encontraron terminales con los filtros aplicados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación estilizada igual a incidentes --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $terminales->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $terminales->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $terminales->total() }}</span>
                        terminales
                    </div>

                    @if($terminales->hasPages())
                        <nav aria-label="Paginación de terminales">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $terminales->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $terminales->previousPageUrl() }}">Anterior</a>
                                </li>

                                @for($page = 1; $page <= $terminales->lastPage(); $page++)
                                    <li class="page-item {{ $page == $terminales->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $terminales->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                <li class="page-item {{ $terminales->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $terminales->nextPageUrl() }}">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- MODAL CREAR TERMINAL                                               --}}
    {{-- ================================================================ --}}
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-3" style="overflow:hidden;">

                <div class="modal-header text-white border-0" style="background:#1e63b8; padding:1.25rem 1.5rem;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:34px;height:34px;background:rgba(255,255,255,0.2);">
                            <i class="fas fa-plus" style="font-size:13px;"></i>
                        </div>
                        <span style="font-size:15px;font-weight:500;">Nueva Terminal</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="padding:1.5rem;">
                    {{-- El form se inyecta via JS igual que antes --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- MODAL EDITAR TERMINAL                                              --}}
    {{-- ================================================================ --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-3" style="overflow:hidden;">

                <div class="modal-header text-white border-0" style="background:#1e63b8; padding:1.25rem 1.5rem;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:34px;height:34px;background:rgba(255,255,255,0.2);">
                            <i class="fas fa-edit" style="font-size:13px;"></i>
                        </div>
                        <span style="font-size:15px;font-weight:500;">Editar Terminal</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="padding:1.5rem;">
                    <form id="formEditar" action="" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- 1. UBICACIÓN --}}
                        <h5 class="mb-2 mt-1" style="color:#1e63b8; font-weight:600;">
                            <i class="fas fa-map-marker-alt me-2"></i>1. Datos de ubicación
                        </h5>
                        <hr class="mt-0 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" id="e_nombre" name="nombre" class="form-control" maxlength="100" required>
                                <div id="e_error-nombre" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Departamento <span class="text-danger">*</span></label>
                                <select id="e_departamento" name="departamento" class="form-select" required>
                                    <option value="">-- Seleccione un departamento --</option>
                                    @foreach($departamentos as $depto)
                                        <option value="{{ $depto }}">{{ $depto }}</option>
                                    @endforeach
                                </select>
                                <div id="e_error-departamento" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Municipio <span class="text-danger">*</span></label>
                                <select id="e_municipio" name="municipio" class="form-select" required disabled>
                                    <option value="">-- Seleccione primero un departamento --</option>
                                </select>
                                <div id="e_error-municipio" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Código</label>
                                <input type="text" id="e_codigo" name="codigo" class="form-control bg-light" maxlength="10" readonly>
                                <div id="e_error-codigo" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dirección <span class="text-danger">*</span></label>
                                <textarea id="e_direccion" name="direccion" class="form-control" maxlength="150" rows="2" required></textarea>
                                <div id="e_error-direccion" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                        </div>

                        {{-- 1.5 COORDENADAS --}}
                        <h5 class="mb-2 mt-4" style="color:#1e63b8; font-weight:600;">
                            <i class="fas fa-map-pin me-2"></i>1.5 Coordenadas <small class="text-muted fw-normal">(Opcional)</small>
                        </h5>
                        <hr class="mt-0 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Latitud</label>
                                <input type="text" id="e_latitud" name="latitud" class="form-control" placeholder="Ej: 14.0821">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Longitud</label>
                                <input type="text" id="e_longitud" name="longitud" class="form-control" placeholder="Ej: -87.2063">
                            </div>
                        </div>

                        {{-- 2. CONTACTO --}}
                        <h5 class="mb-2 mt-4" style="color:#1e63b8; font-weight:600;">
                            <i class="fas fa-address-book me-2"></i>2. Información de contacto
                        </h5>
                        <hr class="mt-0 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="text" id="e_telefono" name="telefono" class="form-control" maxlength="8" required>
                                <div id="e_error-telefono" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                                <input type="email" id="e_correo" name="correo" class="form-control" maxlength="50" required>
                                <div id="e_error-correo" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                        </div>

                        {{-- 3. HORARIOS --}}
                        <h5 class="mb-2 mt-4" style="color:#1e63b8; font-weight:600;">
                            <i class="fas fa-clock me-2"></i>3. Horarios y detalles
                        </h5>
                        <hr class="mt-0 mb-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Horario de apertura <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-sun text-warning"></i></span>
                                    <select id="e_ap_hora" class="form-select"><option value="">Hora</option></select>
                                    <span class="input-group-text">:</span>
                                    <select id="e_ap_min"  class="form-select"><option value="">Min</option></select>
                                </div>
                                <div id="e_error-horario_apertura" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Horario de cierre <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-moon text-secondary"></i></span>
                                    <select id="e_ci_hora" class="form-select"><option value="">Hora</option></select>
                                    <span class="input-group-text">:</span>
                                    <select id="e_ci_min"  class="form-select"><option value="">Min</option></select>
                                </div>
                                <div id="e_error-horario_cierre" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                        </div>
                        <input type="hidden" name="horario_apertura" id="e_ap_hidden">
                        <input type="hidden" name="horario_cierre"   id="e_ci_hidden">

                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label">Descripción <span class="text-danger">*</span></label>
                                <textarea id="e_descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                                <div id="e_error-descripcion" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                            </div>
                        </div>

                        {{-- 4. SERVICIOS --}}
                        <h5 class="mb-2 mt-4" style="color:#1e63b8; font-weight:600;">
                            <i class="fas fa-star me-2"></i>4. Servicios adicionales
                        </h5>
                        <hr class="mt-0 mb-3">
                        <div class="row g-2 mb-3">
                            <div class="col-md-3 col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="servicios[]" value="wifi" id="e_svc_wifi">
                                    <label class="form-check-label" for="e_svc_wifi"><i class="fas fa-wifi me-1 text-primary"></i>WiFi</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="servicios[]" value="banos" id="e_svc_banos">
                                    <label class="form-check-label" for="e_svc_banos"><i class="fas fa-restroom me-1 text-info"></i>Baños</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="servicios[]" value="cafeteria" id="e_svc_cafeteria">
                                    <label class="form-check-label" for="e_svc_cafeteria"><i class="fas fa-coffee me-1 text-warning"></i>Cafetería</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="servicios[]" value="parqueo" id="e_svc_parqueo">
                                    <label class="form-check-label" for="e_svc_parqueo"><i class="fas fa-parking me-1 text-success"></i>Parqueo</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top" style="border-color:#e5e7eb !important;">
                            <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-2" data-bs-dismiss="modal" style="min-width:100px;justify-content:center;">
                                <i class="fas fa-times" style="font-size:12px;"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-2" id="e_submit_btn" style="min-width:120px;justify-content:center;">
                                <i class="fas fa-save" style="font-size:12px;"></i>Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- ESTILOS PAGINACIÓN (idénticos a incidentes)                        --}}
    {{-- ================================================================ --}}
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

    {{-- ================================================================ --}}
    {{-- SCRIPTS (lógica original intacta)                                  --}}
    {{-- ================================================================ --}}
    <script>
        /* ================================================================
           DATOS COMPARTIDOS
           ================================================================ */
        const municipiosHonduras = @json($municipiosHonduras);

        function buildHours() {
            const r = [];
            for (let h = 0; h < 24; h++) {
                const v = String(h).padStart(2,'0');
                const h12 = h % 12 || 12;
                r.push({ value: v, text: String(h12).padStart(2,'0') + ' ' + (h < 12 ? 'AM' : 'PM') });
            }
            return r;
        }
        function buildMins() {
            const r = [];
            for (let m = 0; m < 60; m += 5) {
                const v = String(m).padStart(2,'0');
                r.push({ value: v, text: v });
            }
            return r;
        }
        function fillSelect(sel, opts, def, selected) {
            sel.innerHTML = '<option value="">' + def + '</option>';
            opts.forEach(o => {
                const opt = new Option(o.text, o.value, false, o.value === selected);
                sel.appendChild(opt);
            });
        }
        function normalize(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-zA-Z0-9]/g,'').toUpperCase();
        }
        function showAlertInForm(form, type, msg) {
            const id = form.id + '_alert';
            const old = document.getElementById(id);
            if (old) old.remove();
            const div = document.createElement('div');
            div.id = id;
            div.className = 'alert alert-' + type + ' alert-dismissible d-flex align-items-start mt-2';
            div.innerHTML = '<i class="fas fa-exclamation-circle me-2 mt-1"></i><div>' + msg + '</div>' +
                '<button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>';
            form.insertBefore(div, form.children[1]);
            div.scrollIntoView({ behavior:'smooth', block:'center' });
        }

        /* ================================================================
           MODAL EDITAR
           ================================================================ */
        (function () {
            const modal     = document.getElementById('modalEditar');
            const form      = document.getElementById('formEditar');
            const deptoSel  = document.getElementById('e_departamento');
            const muniSel   = document.getElementById('e_municipio');
            const codigoInput = document.getElementById('e_codigo');
            const apHora    = document.getElementById('e_ap_hora');
            const apMin     = document.getElementById('e_ap_min');
            const ciHora    = document.getElementById('e_ci_hora');
            const ciMin     = document.getElementById('e_ci_min');
            const apHidden  = document.getElementById('e_ap_hidden');
            const ciHidden  = document.getElementById('e_ci_hidden');

            function showErr(key, msg) { const el = document.getElementById('e_error-' + key); if (el) el.innerHTML = msg; }
            function clearAllErrors() {
                form.querySelectorAll('[id^="e_error-"]').forEach(el => el.textContent = '');
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                const a = document.getElementById('formEditar_alert'); if (a) a.remove();
            }
            function markInvalid(f) { f.classList.add('is-invalid'); }

            function buildTimeSelects(apVal, ciVal) {
                const h = buildHours(), m = buildMins();
                const apH = apVal ? apVal.substring(0,2) : '';
                const apM = apVal ? apVal.substring(3,5) : '';
                const ciH = ciVal ? ciVal.substring(0,2) : '';
                const ciM = ciVal ? ciVal.substring(3,5) : '';
                fillSelect(apHora, h, 'Hora', apH); fillSelect(apMin, m, 'Min', apM);
                fillSelect(ciHora, h, 'Hora', ciH); fillSelect(ciMin, m, 'Min', ciM);
                updateHidden();
            }
            function updateHidden() {
                apHidden.value = (apHora.value && apMin.value) ? apHora.value+':'+apMin.value : '';
                ciHidden.value = (ciHora.value && ciMin.value) ? ciHora.value+':'+ciMin.value : '';
            }
            function loadMunicipios(depto, selectedMuni) {
                muniSel.innerHTML = '';
                if (depto && municipiosHonduras[depto]) {
                    muniSel.disabled = false;
                    muniSel.appendChild(new Option('-- Seleccione un municipio --',''));
                    [...municipiosHonduras[depto]].sort().forEach(m => {
                        muniSel.appendChild(new Option(m, m, false, m === selectedMuni));
                    });
                } else {
                    muniSel.disabled = true;
                    muniSel.appendChild(new Option('-- Seleccione primero un departamento --',''));
                }
            }

            document.querySelectorAll('.btn-editar').forEach(btn => {
                btn.addEventListener('click', function () {
                    const d = this.dataset;
                    form.action = '/terminales/' + d.id;
                    document.getElementById('e_nombre').value      = d.nombre;
                    document.getElementById('e_codigo').value      = d.codigo;
                    document.getElementById('e_direccion').value   = d.direccion;
                    document.getElementById('e_latitud').value     = d.latitud  || '';
                    document.getElementById('e_longitud').value    = d.longitud || '';
                    document.getElementById('e_telefono').value    = d.telefono;
                    document.getElementById('e_correo').value      = d.correo;
                    document.getElementById('e_descripcion').value = d.descripcion;
                    deptoSel.value = d.departamento;
                    loadMunicipios(d.departamento, d.municipio);
                    buildTimeSelects(d.horarioApertura, d.horarioCierre);
                    const serviciosActivos = d.servicios ? d.servicios.split(',').map(s => s.trim()) : [];
                    ['wifi','banos','cafeteria','parqueo'].forEach(svc => {
                        document.getElementById('e_svc_' + svc).checked = serviciosActivos.includes(svc);
                    });
                    clearAllErrors();
                    bootstrap.Modal.getOrCreateInstance(modal).show();
                });
            });

            deptoSel.addEventListener('change', function () { loadMunicipios(this.value, ''); });
            [apHora, apMin, ciHora, ciMin].forEach(s => s.addEventListener('change', updateHidden));

            modal.addEventListener('hidden.bs.modal', function () {
                form.reset();
                muniSel.disabled = true;
                muniSel.innerHTML = '<option value="">-- Seleccione primero un departamento --</option>';
                apHidden.value = ''; ciHidden.value = '';
                clearAllErrors();
            });

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                updateHidden();
                clearAllErrors();

                let valid = true, firstInvalid = null;
                function fail(el, key, msg) {
                    valid = false; markInvalid(el); showErr(key, msg);
                    if (!firstInvalid) firstInvalid = el;
                }

                const nombre   = document.getElementById('e_nombre');
                const dir      = document.getElementById('e_direccion');
                const tel      = document.getElementById('e_telefono');
                const correo   = document.getElementById('e_correo');
                const desc     = document.getElementById('e_descripcion');

                if (!nombre.value.trim()) fail(nombre,'nombre','El nombre es <strong>obligatorio</strong>.');
                if (!deptoSel.value) fail(deptoSel,'departamento','Seleccione un <strong>departamento</strong>.');
                if (!muniSel.value) fail(muniSel,'municipio','Seleccione un <strong>municipio</strong>.');
                if (!dir.value.trim()) fail(dir,'direccion','La dirección es <strong>obligatoria</strong>.');
                if (!tel.value.trim()) fail(tel,'telefono','El teléfono es <strong>obligatorio</strong>.');
                else if (!/^[983]\d{7}$/.test(tel.value.trim())) fail(tel,'telefono','Debe iniciar en 9, 8 o 3 y tener <strong>8 dígitos</strong>.');
                if (!correo.value.trim()) fail(correo,'correo','El correo es <strong>obligatorio</strong>.');
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value.trim())) fail(correo,'correo','Ingrese un <strong>correo válido</strong>.');
                if (!apHora.value || !apMin.value) fail(apHora,'horario_apertura','Seleccione <strong>hora y minuto</strong> de apertura.');
                if (!ciHora.value || !ciMin.value) fail(ciHora,'horario_cierre','Seleccione <strong>hora y minuto</strong> de cierre.');
                else if (apHidden.value && ciHidden.value && ciHidden.value <= apHidden.value)
                    fail(ciHora,'horario_cierre','El cierre debe ser <strong>posterior</strong> a la apertura.');
                if (!desc.value.trim()) fail(desc,'descripcion','La descripción es <strong>obligatoria</strong>.');

                if (!valid) { if (firstInvalid) firstInvalid.focus(); return; }

                const btn = document.getElementById('e_submit_btn');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

                try {
                    const formData = new FormData(form);
                    const resp = await fetch(form.action, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: formData,
                    });
                    const raw = await resp.text();
                    let data;
                    try { data = JSON.parse(raw); }
                    catch (_) { console.error('No-JSON:', raw.substring(0,600)); showAlertInForm(form,'danger','Error del servidor (HTTP '+resp.status+'). Revisa la consola F12.'); return; }

                    if (resp.ok && data.success) {
                        bootstrap.Modal.getInstance(modal).hide();
                        window.location.reload();
                    } else if (resp.status === 422 && data.errors) {
                        const map = { nombre:nombre, departamento:deptoSel, municipio:muniSel, codigo:codigoInput,
                            direccion:dir, telefono:tel, correo:correo, horario_apertura:apHora, horario_cierre:ciHora, descripcion:desc };
                        const lbls = { nombre:'Nombre', departamento:'Departamento', municipio:'Municipio', codigo:'Código',
                            direccion:'Dirección', telefono:'Teléfono', correo:'Correo',
                            horario_apertura:'Horario apertura', horario_cierre:'Horario cierre', descripcion:'Descripción' };
                        let lines = [], fd = false;
                        Object.entries(data.errors).forEach(([f, msgs]) => {
                            lines.push('<strong>'+(lbls[f]||f)+':</strong> '+msgs[0]);
                            const el = map[f]; if (el) { markInvalid(el); showErr(f, msgs[0]); if (!fd) { el.focus(); fd=true; } }
                        });
                        showAlertInForm(form,'warning','Corrige los siguientes errores:<br>'+lines.join('<br>'));
                    } else {
                        showAlertInForm(form,'danger','Error: '+(data.message||'Respuesta inesperada.'));
                    }
                } catch (err) { console.error(err); showAlertInForm(form,'danger','Error de red: '+err.message); }
                finally { btn.disabled=false; btn.innerHTML='<i class="fas fa-save me-2"></i>Guardar cambios'; }
            });
        })();
    </script>

    {{-- MODAL CREAR — inyección dinámica del form --}}
    <script>
        (function() {
            const body = document.querySelector('#modalCrear .modal-body');
            if (body && !document.getElementById('m_nombre')) {
                body.innerHTML = `
                <form id="formCrear" action="{{ route('terminales.store') }}" method="POST" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <h5 class="mb-2 mt-1" style="color:#1e63b8;font-weight:600;"><i class="fas fa-map-marker-alt me-2"></i>1. Datos de ubicación</h5>
                    <hr class="mt-0 mb-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="m_nombre" name="nombre" class="form-control" maxlength="100" required>
                            <div id="m_error-nombre" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Departamento <span class="text-danger">*</span></label>
                            <select id="m_departamento" name="departamento" class="form-select" required>
                                <option value="">-- Seleccione un departamento --</option>
                                ${Object.keys(municipiosHonduras).sort().map(d=>`<option value="${d}">${d}</option>`).join('')}
                            </select>
                            <div id="m_error-departamento" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Municipio <span class="text-danger">*</span></label>
                            <select id="m_municipio" name="municipio" class="form-select" required disabled>
                                <option value="">-- Seleccione primero un departamento --</option>
                            </select>
                            <div id="m_error-municipio" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Código <small class="text-muted">(automático)</small></label>
                            <input type="text" id="m_codigo" name="codigo" class="form-control bg-light" maxlength="10" readonly>
                            <div id="m_error-codigo" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección <span class="text-danger">*</span></label>
                            <textarea id="m_direccion" name="direccion" class="form-control" maxlength="150" rows="2" required></textarea>
                            <div id="m_error-direccion" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                    </div>

                    <h5 class="mb-2 mt-4" style="color:#1e63b8;font-weight:600;"><i class="fas fa-map-pin me-2"></i>1.5 Coordenadas <small class="text-muted fw-normal">(Opcional)</small></h5>
                    <hr class="mt-0 mb-3">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Latitud</label><input type="text" id="m_latitud" name="latitud" class="form-control" placeholder="Ej: 14.0821"></div>
                        <div class="col-md-6"><label class="form-label">Longitud</label><input type="text" id="m_longitud" name="longitud" class="form-control" placeholder="Ej: -87.2063"></div>
                    </div>

                    <h5 class="mb-2 mt-4" style="color:#1e63b8;font-weight:600;"><i class="fas fa-address-book me-2"></i>2. Contacto</h5>
                    <hr class="mt-0 mb-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" id="m_telefono" name="telefono" class="form-control" maxlength="8" required>
                            <div id="m_error-telefono" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo <span class="text-danger">*</span></label>
                            <input type="email" id="m_correo" name="correo" class="form-control" maxlength="50" required>
                            <div id="m_error-correo" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                    </div>

                    <h5 class="mb-2 mt-4" style="color:#1e63b8;font-weight:600;"><i class="fas fa-clock me-2"></i>3. Horarios</h5>
                    <hr class="mt-0 mb-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Apertura <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-sun text-warning"></i></span>
                                <select id="m_ap_hora" class="form-select"><option value="">Hora</option></select>
                                <span class="input-group-text">:</span>
                                <select id="m_ap_min" class="form-select"><option value="">Min</option></select>
                            </div>
                            <div id="m_error-horario_apertura" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cierre <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-moon text-secondary"></i></span>
                                <select id="m_ci_hora" class="form-select"><option value="">Hora</option></select>
                                <span class="input-group-text">:</span>
                                <select id="m_ci_min" class="form-select"><option value="">Min</option></select>
                            </div>
                            <div id="m_error-horario_cierre" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                    </div>
                    <input type="hidden" name="horario_apertura" id="m_ap_hidden">
                    <input type="hidden" name="horario_cierre"   id="m_ci_hidden">

                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Descripción <span class="text-danger">*</span></label>
                            <textarea id="m_descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                            <div id="m_error-descripcion" class="invalid-feedback d-block" style="min-height:1.2rem;"></div>
                        </div>
                    </div>

                    <h5 class="mb-2 mt-4" style="color:#1e63b8;font-weight:600;"><i class="fas fa-star me-2"></i>4. Servicios adicionales</h5>
                    <hr class="mt-0 mb-3">
                    <div class="row g-2 mb-3">
                        <div class="col-md-3 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="servicios[]" value="wifi" id="m_svc_wifi"><label class="form-check-label" for="m_svc_wifi"><i class="fas fa-wifi me-1 text-primary"></i>WiFi</label></div></div>
                        <div class="col-md-3 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="servicios[]" value="banos" id="m_svc_banos"><label class="form-check-label" for="m_svc_banos"><i class="fas fa-restroom me-1 text-info"></i>Baños</label></div></div>
                        <div class="col-md-3 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="servicios[]" value="cafeteria" id="m_svc_cafeteria"><label class="form-check-label" for="m_svc_cafeteria"><i class="fas fa-coffee me-1 text-warning"></i>Cafetería</label></div></div>
                        <div class="col-md-3 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="servicios[]" value="parqueo" id="m_svc_parqueo"><label class="form-check-label" for="m_svc_parqueo"><i class="fas fa-parking me-1 text-success"></i>Parqueo</label></div></div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top" style="border-color:#e5e7eb !important;">
                        <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-2" data-bs-dismiss="modal" style="min-width:100px;justify-content:center;">
                            <i class="fas fa-times" style="font-size:12px;"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-2" id="c_submit_btn" style="min-width:100px;justify-content:center;">
                            <i class="fas fa-save" style="font-size:12px;"></i>Guardar
                        </button>
                    </div>
                </form>`;
                initModalCrear();
            }
        })();

        function initModalCrear() {
            const form       = document.getElementById('formCrear');
            const deptoSel   = document.getElementById('m_departamento');
            const muniSel    = document.getElementById('m_municipio');
            const codigoInput= document.getElementById('m_codigo');
            const nombreInput= document.getElementById('m_nombre');
            const apHora     = document.getElementById('m_ap_hora');
            const apMin      = document.getElementById('m_ap_min');
            const ciHora     = document.getElementById('m_ci_hora');
            const ciMin      = document.getElementById('m_ci_min');
            const apHidden   = document.getElementById('m_ap_hidden');
            const ciHidden   = document.getElementById('m_ci_hidden');

            function showErr(key, msg) { const el = document.getElementById('m_error-' + key); if (el) el.innerHTML = msg; }
            function clearAllErrors() {
                form.querySelectorAll('[id^="m_error-"]').forEach(el => el.textContent = '');
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                const a = document.getElementById('formCrear_alert'); if (a) a.remove();
            }
            function markInvalid(f) { f.classList.add('is-invalid'); }
            function loadMunicipios() {
                const d = deptoSel.value;
                muniSel.innerHTML = '';
                muniSel.classList.remove('is-invalid');
                showErr('municipio','');
                if (d && municipiosHonduras[d]) {
                    muniSel.disabled = false;
                    muniSel.appendChild(new Option('-- Seleccione un municipio --',''));
                    [...municipiosHonduras[d]].sort().forEach(m => muniSel.appendChild(new Option(m,m)));
                } else {
                    muniSel.disabled = true;
                    muniSel.appendChild(new Option('-- Seleccione primero un departamento --',''));
                }
                updateCodigo();
            }
            function updateCodigo() {
                const d = deptoSel.value, m = muniSel.value, n = nombreInput.value;
                codigoInput.value = (d && m) ? normalize(d).substring(0,3)+'-'+normalize(m).substring(0,3)+'-'+(normalize(n.replace(/\s/g,'')).substring(0,2)||'XX') : '';
            }
            function buildTimeSelects() {
                const h = buildHours(), m = buildMins();
                fillSelect(apHora,h,'Hora',''); fillSelect(apMin,m,'Min','');
                fillSelect(ciHora,h,'Hora',''); fillSelect(ciMin,m,'Min','');
            }
            function updateHidden() {
                apHidden.value = (apHora.value && apMin.value) ? apHora.value+':'+apMin.value : '';
                ciHidden.value = (ciHora.value && ciMin.value) ? ciHora.value+':'+ciMin.value : '';
            }

            document.getElementById('modalCrear').addEventListener('hidden.bs.modal', function () {
                form.reset();
                muniSel.disabled = true;
                muniSel.innerHTML = '<option value="">-- Seleccione primero un departamento --</option>';
                codigoInput.value = ''; apHidden.value = ''; ciHidden.value = '';
                clearAllErrors(); buildTimeSelects();
            });

            deptoSel.addEventListener('change', loadMunicipios);
            muniSel.addEventListener('change', updateCodigo);
            nombreInput.addEventListener('input', updateCodigo);
            [apHora, apMin, ciHora, ciMin].forEach(s => s.addEventListener('change', updateHidden));

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                updateHidden(); updateCodigo(); clearAllErrors();
                let valid=true, firstInvalid=null;
                function fail(el,key,msg){valid=false;markInvalid(el);showErr(key,msg);if(!firstInvalid)firstInvalid=el;}
                const dir=document.getElementById('m_direccion'),tel=document.getElementById('m_telefono'),
                    correo=document.getElementById('m_correo'),desc=document.getElementById('m_descripcion');
                if (!nombreInput.value.trim()) fail(nombreInput,'nombre','El nombre es <strong>obligatorio</strong>.');
                if (!deptoSel.value) fail(deptoSel,'departamento','Seleccione un <strong>departamento</strong>.');
                if (!muniSel.value) fail(muniSel,'municipio','Seleccione un <strong>municipio</strong>.');
                if (!codigoInput.value.trim()) fail(codigoInput,'codigo','Complete nombre, departamento y municipio para generar el código.');
                if (!dir.value.trim()) fail(dir,'direccion','La dirección es <strong>obligatoria</strong>.');
                if (!tel.value.trim()) fail(tel,'telefono','El teléfono es <strong>obligatorio</strong>.');
                else if (!/^[983]\d{7}$/.test(tel.value.trim())) fail(tel,'telefono','Debe iniciar en 9, 8 o 3 y tener <strong>8 dígitos</strong>.');
                if (!correo.value.trim()) fail(correo,'correo','El correo es <strong>obligatorio</strong>.');
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value.trim())) fail(correo,'correo','Ingrese un <strong>correo válido</strong>.');
                if (!apHora.value||!apMin.value) fail(apHora,'horario_apertura','Seleccione <strong>hora y minuto</strong> de apertura.');
                if (!ciHora.value||!ciMin.value) fail(ciHora,'horario_cierre','Seleccione <strong>hora y minuto</strong> de cierre.');
                else if (apHidden.value&&ciHidden.value&&ciHidden.value<=apHidden.value) fail(ciHora,'horario_cierre','El cierre debe ser <strong>posterior</strong> a la apertura.');
                if (!desc.value.trim()) fail(desc,'descripcion','La descripción es <strong>obligatoria</strong>.');
                if (!valid){if(firstInvalid)firstInvalid.focus();return;}

                const btn=document.getElementById('c_submit_btn');
                btn.disabled=true; btn.innerHTML='<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';
                try {
                    const resp=await fetch(form.action,{method:'POST',headers:{'X-CSRF-TOKEN':form.querySelector('input[name="_token"]').value,'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},body:new FormData(form)});
                    const raw=await resp.text(); let data;
                    try{data=JSON.parse(raw);}catch(_){console.error(raw.substring(0,600));showAlertInForm(form,'danger','Error servidor HTTP '+resp.status+'. Revisa F12.');return;}
                    if(resp.ok&&data.success){bootstrap.Modal.getInstance(document.getElementById('modalCrear')).hide();window.location.reload();}
                    else if(resp.status===422&&data.errors){
                        const map={nombre:nombreInput,departamento:deptoSel,municipio:muniSel,codigo:codigoInput,direccion:dir,telefono:tel,correo:correo,horario_apertura:apHora,horario_cierre:ciHora,descripcion:desc};
                        const lbls={nombre:'Nombre',departamento:'Departamento',municipio:'Municipio',codigo:'Código',direccion:'Dirección',telefono:'Teléfono',correo:'Correo',horario_apertura:'Horario apertura',horario_cierre:'Horario cierre',descripcion:'Descripción'};
                        let lines=[],fd=false;
                        Object.entries(data.errors).forEach(([f,msgs])=>{lines.push('<strong>'+(lbls[f]||f)+':</strong> '+msgs[0]);const el=map[f];if(el){markInvalid(el);showErr(f,msgs[0]);if(!fd){el.focus();fd=true;}}});
                        showAlertInForm(form,'warning','Corrige los siguientes errores:<br>'+lines.join('<br>'));
                    }else{showAlertInForm(form,'danger','Error: '+(data.message||'Respuesta inesperada.'));}
                }catch(err){console.error(err);showAlertInForm(form,'danger','Error de red: '+err.message);}
                finally{btn.disabled=false;btn.innerHTML='<i class="fas fa-save me-2"></i>Guardar';}
            });
            buildTimeSelects();
        }
        initModalCrear();
    </script>

@endsection
