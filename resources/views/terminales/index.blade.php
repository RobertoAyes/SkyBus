@extends('layouts.layoutadmin')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-lg border-0 rounded-0 w-100">
            {{-- Encabezado --}}
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#ffffff;">
                <h2 style="margin:0; color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-bus me-2"></i>Terminales
                </h2>
                <a href="{{ route('terminales.create') }}" class="btn btn-light fw-semibold">
                    <i class="fas fa-plus me-1"></i>Nueva Terminal
                </a>
            </div>

            {{-- Cuerpo de la card --}}
            <div class="card-body" style="min-height: 70vh;">

                {{-- Mensajes de éxito --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                {{-- Formulario de búsqueda --}}
                <form method="GET" action="{{ route('terminales.index') }}" class="mb-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold"><i class="fas fa-search text-primary me-2"></i>Búsqueda General</label>
                            <div class="input-group">
                                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-end gap-2">
                            <button class="btn btn-primary flex-fill" type="submit">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                            <button class="btn btn-outline-primary flex-fill" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados" aria-expanded="false">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>
                            @if(request()->hasAny(['nombre','contacto','ubicacion']))
                                <a href="{{ route('terminales.index') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Filtros avanzados colapsables --}}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Tabla de terminales --}}
                <div class="table-responsive w-100">
                    <table class="table table-hover table-bordered w-100 align-middle text-center">
                        <thead class="table-primary">
                        <tr>
                            <th><i class="fas fa-barcode me-1"></i>Código</th>
                            <th><i class="fas fa-bus me-1"></i>Nombre</th>
                            <th><i class="fas fa-map-marker-alt me-1"></i>Ubicación</th>
                            <th><i class="fas fa-phone-alt me-1"></i>Contacto</th>
                            <th><i class="fas fa-clock me-1"></i>Horario</th>
                            <th class="text-center"><i class="fas fa-cog me-1"></i>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($terminales as $terminal)
                            <tr>
                                <td>{{ $terminal->codigo }}</td>
                                <td>{{ $terminal->nombre }}</td>
                                <td><strong>{{ $terminal->departamento }}</strong></td>
                                <td>
                                    <i class="fas fa-phone-alt text-success me-1"></i>{{ $terminal->telefono }}<br>
                                    <small><i class="fas fa-envelope text-secondary me-1"></i>{{ $terminal->correo }}</small>
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
                                    <a href="{{ route('terminales.edit', $terminal) }}" class="btn btn-primary btn-sm">Editar</a>

                                </td>

                                <td>
                                    @forelse($terminal->servicios as $servicio)
                                        {{$servicio->nombre}}@if(!$loop->last), @endif <br>
                                    @empty
                                        <span class="text-muted">N/A</span>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('terminales.edit', $terminal) }}" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="{{ route('servicios.edit', $terminal) }}" class="btn btn-success btn-sm">Servicios</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                    No se encontraron terminales con los filtros aplicados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-4">
                    {{ $terminales->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>

            </div> {{-- Fin card-body --}}
        </div> {{-- Fin card --}}
    </div> {{-- Fin container-fluid --}}
@endsection
