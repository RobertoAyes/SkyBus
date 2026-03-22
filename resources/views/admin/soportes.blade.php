@extends('layouts.layoutadmin')

@section('title', 'Consultas de Choferes')

@section('content')
    <div class="container">
        <<div class="card">
            <div class="card-header">
                <h2 class="mb-0 fw-bold" style="font-size: 2rem;">
                    <i class="fas fa-envelope me-2 text-primary"></i>Solicitudes soporte chofer
                </h2>
            </div>

            <div class="card-body">
                {{-- Mensajes de éxito --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                {{-- Formulario de búsqueda y filtros --}}
                <form action="{{ route('admin.soportes') }}" method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">
                                <i class="fas fa-search text-primary me-2"></i>Búsqueda General
                            </label>
                            <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por título o descripción">
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                            <button class="btn btn-outline-primary flex-fill" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados" aria-expanded="false">
                                <i class="fas fa-sliders-h me-2"></i>Filtros
                            </button>
                            @if(request()->hasAny(['buscar', 'estado']))
                                <a href="{{ route('admin.soportes') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Filtros Avanzados (colapsable) --}}
                    <div class="collapse mt-3" id="filtrosAvanzados">
                        <div class="card bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary"><i class="fas fa-filter me-2"></i>Filtros Adicionales</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-success me-2"></i>Estado
                                        </label>
                                        <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-toggle-on"></i>
                                        </span>
                                            <select name="estado" class="form-select">
                                                <option value="">Todos los estados</option>
                                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                                <option value="resuelto" {{ request('estado') == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Tabla de Solicitudes --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th><i class="fas fa-heading me-2"></i>Título</th>
                            <th><i class="fas fa-align-left me-2"></i>Descripción</th>
                            <th><i class="fas fa-user me-2"></i>Chofer</th>
                            <th><i class="fas fa-calendar-alt me-2"></i>Fecha</th>
                            <th><i class="fas fa-toggle-on me-2"></i>Estado</th>
                            <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($solicitudes as $solicitud)
                            <tr>
                                {{-- Título ahora solo texto plano --}}
                                <td>{{ $solicitud->titulo }}</td>

                                <td class="descripcion">{{ $solicitud->descripcion }}</td>
                                <td>{{ $solicitud->chofer->name ?? 'Sin chofer' }}</td>
                                <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($solicitud->estado == 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($solicitud->estado == 'en_proceso')
                                        <span class="badge bg-info text-dark">En Proceso</span>
                                    @elseif($solicitud->estado == 'resuelto')
                                        <span class="badge bg-success">Resuelto</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#soporteModal{{ $solicitud->id }}">
                                        <i class="fas fa-eye me-1"></i>Ver
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                    No se encontraron solicitudes de soporte
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-4 d-flex justify-content-end">
                    {{ $solicitudes->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Estilos --}}
    <style>
        td.descripcion {
            max-width: 300px;
            word-wrap: break-word;
            white-space: normal;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endsection
