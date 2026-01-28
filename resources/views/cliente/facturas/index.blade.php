@extends('layouts.layoutuser')

@section('title', 'Mis Facturas')

@section('contenido')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i>Mis Facturas</h4>
            <a href="{{ route('cliente.historial') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Volver
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('error'))
                <div class="alert alert-danger m-2">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filtros -->
            <div style="padding: 20px;">
                <h5 style="margin-bottom: 15px; color: #1f2937; font-weight: 600;">
                    <i class="fas fa-filter me-2"></i>Filtrar Facturas
                </h5>
                <form method="GET" action="{{ route('cliente.facturas') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Número de Factura</label>
                            <input type="text" name="numero" class="form-control"
                                   placeholder="Ej: FAC-2024-001"
                                   value="{{ request('numero') }}"
                                   data-validation="alphanumeric">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Desde</label>
                            <input type="date" name="fecha_desde" class="form-control"
                                   value="{{ request('fecha_desde') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Hasta</label>
                            <input type="date" name="fecha_hasta" class="form-control"
                                   value="{{ request('fecha_hasta') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="emitida" {{ request('estado') == 'emitida' ? 'selected' : '' }}>Emitida</option>
                                <option value="anulada" {{ request('estado') == 'anulada' ? 'selected' : '' }}>Anulada</option>
                                <option value="duplicada" {{ request('estado') == 'duplicada' ? 'selected' : '' }}>Duplicada</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>Buscar
                            </button>
                            <a href="{{ route('cliente.facturas') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabla de Facturas -->
            @if($facturas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">Número</th>
                            <th class="text-center">Fecha Emisión</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th class="text-center">Fecha Viaje</th>
                            <th class="text-center">Asiento</th>
                            <th class="text-center">Monto</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($facturas as $factura)
                            <tr>
                                <td class="text-center">
                                    <span style="font-weight: 700; color: #1976d2;">{{ $factura->numero_factura }}</span>
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
                                </td>
                                <td>{{ $factura->reserva->viaje->origen->nombre ?? '-' }}</td>
                                <td>{{ $factura->reserva->viaje->destino->nombre ?? '-' }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($factura->reserva->viaje->fecha_hora_salida)->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">#{{ $factura->reserva->asiento->numero_asiento ?? '-' }}</td>
                                <td class="text-center">
                                    <strong style="color: #1976d2;">L. {{ number_format($factura->monto_total, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge
                                        {{ $factura->estado === 'emitida' ? 'bg-success' :
                                           ($factura->estado === 'anulada' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($factura->estado) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('cliente.facturas.pdf', $factura->id) }}"
                                       class="btn btn-sm btn-primary me-1"
                                       target="_blank"
                                       title="Descargar PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button onclick="enviarPorCorreo({{ $factura->id }})"
                                            class="btn btn-sm btn-success me-1"
                                            title="Enviar por Email"
                                            type="button">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                    <a href="{{ route('cliente.facturas.ver', $factura->id) }}"
                                       class="btn btn-sm btn-secondary"
                                       title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($facturas->hasPages())
                    <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Mostrando {{ $facturas->firstItem() }} - {{ $facturas->lastItem() }} de {{ $facturas->total() }} facturas
                        </small>
                    </div>
                @endif
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                    <p>No tienes facturas disponibles.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Validación de campos
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('[data-validation]');

            inputs.forEach(function(input) {
                input.addEventListener('input', function(e) {
                    const validationType = this.getAttribute('data-validation');

                    if (validationType === 'alphanumeric') {
                        this.value = this.value.replace(/[^a-zA-Z0-9\s\-]/g, '');
                    }
                });
            });
        });

        // Función para enviar factura por correo
        function enviarPorCorreo(facturaId) {
            if (confirm('¿Deseas enviar esta factura a tu correo electrónico?')) {
                fetch(`/cliente/facturas/${facturaId}/enviar-email`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('¡Factura enviada correctamente a tu correo!');
                        } else {
                            alert('Error al enviar la factura. Intenta nuevamente.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al enviar la factura. Intenta nuevamente.');
                    });
            }
        }
    </script>
@endsection
