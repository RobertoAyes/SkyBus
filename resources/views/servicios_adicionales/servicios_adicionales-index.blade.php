@extends('layouts.layoutadmin')

@section('title', 'Servicios Adicionales')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600;">
                    <i class="fas fa-concierge-bell me-2"></i>Servicios Adicionales
                </h2>

                <a href="{{ route('servicios_adicionales.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Agregar
                </a>
            </div>

            <div class="card-body">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        <strong class="me-2">Error:</strong> {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- FILTROS --}}
                <form method="GET" action="{{ route('servicios_adicionales.index') }}">
                    <div class="row g-3 mb-3">

                        {{-- BUSCAR --}}
                        <div class="col-md-6">
                            <input type="text" name="buscar" class="form-control"
                                   placeholder="Buscar servicio..."
                                   value="{{ request('buscar') }}">
                        </div>

                        {{-- ESTADO --}}
                        <div class="col-md-3">
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activos</option>
                                <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivos</option>
                            </select>
                        </div>

                        {{-- BOTONES --}}
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>

                            @if(request()->hasAny(['buscar','estado']))
                                <a href="{{ route('servicios_adicionales.index') }}" class="btn btn-outline-secondary w-100">
                                    Limpiar
                                </a>
                            @endif
                        </div>

                    </div>
                </form>

                {{-- TABLA --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:20%">Nombre</th>
                            <th style="width:35%">Descripción</th>
                            <th style="width:15%" class="text-center">Imagen</th>
                            <th style="width:25%" class="text-center">Estado</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($extras as $extra)
                            <tr>
                                <td>{{ $extras->firstItem() + $loop->index }}</td>

                                <td>{{ $extra->nombre }}</td>

                                <td>{{ $extra->descripcion }}</td>

                                <td class="text-center">
                                    @if($extra->imagen)
                                        <img src="{{ asset('storage/' . $extra->imagen) }}"
                                             class="rounded"
                                             style="height:60px; width:80px; object-fit:cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <button class="btn btn-sm {{ $extra->estado ? 'btn-danger' : 'btn-success' }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEstado{{ $extra->id }}">
                                        {{ $extra->estado ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </td>
                            </tr>

                            {{-- MODAL --}}
                            <div class="modal fade" id="modalEstado{{ $extra->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-3">

                                        <div class="modal-header text-white" style="background:#1e63b8;">
                                            <h5 class="mb-0">
                                                {{ $extra->estado ? 'Desactivar' : 'Activar' }} servicio
                                            </h5>
                                            <button class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body text-center">
                                            ¿Seguro que deseas
                                            <strong>{{ $extra->estado ? 'desactivar' : 'activar' }}</strong>
                                            "{{ $extra->nombre }}"?
                                        </div>

                                        <div class="modal-footer justify-content-center">
                                            <form action="{{ route('servicios_adicionales.update', $extra->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button class="btn btn-sm {{ $extra->estado ? 'btn-danger' : 'btn-success' }}">
                                                    Confirmar
                                                </button>
                                            </form>

                                            <button class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No hay servicios registrados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                @if($extras->hasPages())
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Mostrando {{ $extras->firstItem() }} - {{ $extras->lastItem() }}
                            de {{ $extras->total() }} registros
                        </small>
                        {{ $extras->appends(request()->all())->links('pagination.numeros') }}
                    </div>
                @endif

            </div>
        </div>
    </div>

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
    </style>

@endsection
