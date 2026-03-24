@extends('layouts.layoutuser')

@section('title', 'Mis Facturas')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-file-invoice-dollar me-2"></i> Mis Facturas
                </h2>
                <a href="{{ route('cliente.historial') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>

            <div class="card-body">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        <strong class="me-2">Error:</strong> {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- FILTROS --}}
                <form method="GET" action="{{ route('cliente.facturas') }}" class="mb-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Número de Factura</label>
                            <input type="text" name="numero" class="form-control" placeholder="Ej: FAC-2024-001"
                                   value="{{ request('numero') }}" data-validation="alphanumeric">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Fecha Desde</label>
                            <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Fecha Hasta</label>
                            <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="emitida" {{ request('estado') == 'emitida' ? 'selected' : '' }}>Emitida</option>
                                <option value="anulada" {{ request('estado') == 'anulada' ? 'selected' : '' }}>Anulada</option>
                                <option value="duplicada" {{ request('estado') == 'duplicada' ? 'selected' : '' }}>Duplicada</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                            <a href="{{ route('cliente.facturas') }}" class="btn btn-outline-secondary flex-fill">
                                <i class="fas fa-times me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>

                {{-- TABLA DE FACTURAS --}}
                @if($facturas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary">
                            <tr>
                                <th class="text-center" style="width:60px;">#</th>
                                <th>Número</th>
                                <th>Fecha Emisión</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Fecha Viaje</th>
                                <th>Asiento</th>
                                <th>Monto</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($facturas as $key => $factura)
                                <tr>
                                    <td class="text-center">{{ ($facturas->currentPage()-1)*$facturas->perPage() + $key + 1 }}</td>
                                    <td>{{ $factura->numero_factura }}</td>
                                    <td>{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</td>
                                    <td>{{ $factura->reserva->viaje->origen->nombre ?? '-' }}</td>
                                    <td>{{ $factura->reserva->viaje->destino->nombre ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($factura->reserva->viaje->fecha_hora_salida)->format('d/m/Y H:i') }}</td>
                                    <td>#{{ $factura->reserva->asiento->numero_asiento ?? '-' }}</td>
                                    <td>L. {{ number_format($factura->monto_total,2) }}</td>
                                    <td class="text-center">
                                        <span class="badge
                                            {{ $factura->estado === 'emitida' ? 'bg-success' :
                                               ($factura->estado === 'anulada' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ ucfirst($factura->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('cliente.facturas.pdf', $factura->id) }}" target="_blank" class="btn btn-sm btn-info me-1">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button onclick="enviarPorCorreo({{ $factura->id }})" class="btn btn-sm btn-success me-1">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <a href="{{ route('cliente.facturas.ver', $factura->id) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Mostrando {{ $facturas->firstItem() ?? 0 }} – {{ $facturas->lastItem() ?? 0 }} de {{ $facturas->total() }} facturas
                        </div>
                        @if($facturas->hasPages())
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item {{ $facturas->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $facturas->previousPageUrl() }}">Anterior</a>
                                    </li>
                                    @for($page = 1; $page <= $facturas->lastPage(); $page++)
                                        <li class="page-item {{ $page == $facturas->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $facturas->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $facturas->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $facturas->nextPageUrl() }}">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>

                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                        <p>No tienes facturas disponibles.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Validación alfanumérica
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-validation]').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^a-zA-Z0-9\s\-]/g,'');
                });
            });
        });

        // Enviar factura por correo
        function enviarPorCorreo(facturaId) {
            if(confirm('¿Deseas enviar esta factura a tu correo electrónico?')) {
                fetch(`/cliente/facturas/${facturaId}/enviar-email`, {
                    method:'POST',
                    headers: {
                        'Content-Type':'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(res => res.json()).then(data => {
                    alert(data.success ? '¡Factura enviada correctamente!' : 'Error al enviar factura.');
                });
            }
        }
    </script>

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
        .table { table-layout: fixed; width: 100%; }
        .table-responsive { min-height: 320px; }
        tbody { min-height: 300px; display: table-row-group; }
    </style>
@endsection
