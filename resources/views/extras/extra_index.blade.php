@extends('layouts.layoutuser')

@section('title', 'Lista de Servicios Adicionales')

@section('contenido')
    <div class="d-flex justify-content-center">
        <div style="width: 100%; max-width: 900px;">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-list me-2"></i>Historial de Servicios Adicionales
                    </h4>
                    <a href="{{ route('servicios_reserva.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Agregar servicio
                    </a>
                </div>

                <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Selector de registros por página --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <form method="GET" action="{{ route('servicios_reserva.index') }}" id="perPageForm">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0 fw-bold">Mostrar:</label>
                                <select name="perPage" class="form-select form-select-sm" style="width: auto;"
                                        onchange="document.getElementById('perPageForm').submit()">
                                    @foreach([5, 10, 25, 50] as $option)
                                        <option value="{{ $option }}" {{ request('perPage', 5) == $option ? 'selected' : '' }}>
                                            {{ $option }} registros
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <small class="text-muted">
                            Total: {{ $extras->total() }} registros
                        </small>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($extras as $servicio)
                                <tr>
                                    <!-- Numeración -->
                                    <td>{{ $extras->firstItem() + $loop->index }}</td>

                                    <!-- Código de reserva -->
                                    <td>{{ $servicio->reserva->codigo_reserva ?? 'Sin reserva' }}</td>

                                    <!-- Extras asociados -->
                                    <td>
                                        @forelse($servicio->extras ?? [] as $extra)
                                            <span class="badge bg-primary me-1 mb-1">{{ $extra->nombre }}</span>
                                        @empty
                                            <span class="text-muted">No hay extras asociados</span>
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        No hay servicios adicionales registrados.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($extras->hasPages())
                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Mostrando {{ $extras->firstItem() }} - {{ $extras->lastItem() }}
                                de {{ $extras->total() }} registros
                            </small>
                            {{ $extras->appends(request()->only('perPage'))->links('pagination.numeros') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <style>
        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #1e63b8;
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
    </style>
@endsection
