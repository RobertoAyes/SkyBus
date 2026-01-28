@extends('layouts.layoutadmin')

@section('title', 'Gestión de Documentación de Buses')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Alertas de éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tarjeta Principal (Dashboard, Filtros y Tabla Consolidados) -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h2 class="h4 m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-alt"></i> Gestión de Documentación de Buses
                </h2>
                <a href="{{ route('documentos-buses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Documento
                </a>
            </div>

            <div class="card-body">

                <!-- 1. Tarjetas de Estadísticas -->
                <div class="row mb-4">
                    <!-- Total Documentos -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col me-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Documentos
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['total'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vigentes -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col me-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Vigentes
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['vigentes'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Por Vencer -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col me-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Por Vencer
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['por_vencer'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vencidos -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col me-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Vencidos
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['vencidos'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- 2. Filtros y Búsqueda -->
                <div class="mb-4 p-3 bg-light rounded shadow-sm">
                    <h5 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-filter"></i> Opciones de Filtrado
                    </h5>
                    <form method="GET" action="{{ route('documentos-buses.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4 col-lg-3">
                                <label for="search" class="form-label">Buscar:</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       placeholder="Placa o N de documento..."
                                       value="{{ request('search') }}">
                            </div>

                            <div class="col-md-4 col-lg-2">
                                <label for="estado" class="form-label">Estado:</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="vigente" {{ request('estado') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                                    <option value="por_vencer" {{ request('estado') == 'por_vencer' ? 'selected' : '' }}>Por Vencer</option>
                                    <option value="vencido" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-3">
                                <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
                                <select name="tipo_documento" id="tipo_documento" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="permiso_operacion" {{ request('tipo_documento') == 'permiso_operacion' ? 'selected' : '' }}>Permiso de Operación</option>
                                    <option value="revision_tecnica" {{ request('tipo_documento') == 'revision_tecnica' ? 'selected' : '' }}>Revisión Técnica</option>
                                    <option value="seguro_vehicular" {{ request('tipo_documento') == 'seguro_vehicular' ? 'selected' : '' }}>Seguro Vehicular</option>
                                    <option value="matricula" {{ request('tipo_documento') == 'matricula' ? 'selected' : '' }}>Matrícula</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-lg-2">
                                <label for="bus_id" class="form-label">Bus:</label>
                                <select name="bus_id" id="bus_id" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($buses as $bus)
                                        <option value="{{ $bus->id }}" {{ request('bus_id') == $bus->id ? 'selected' : '' }}>
                                            {{ $bus->numero_bus }} - {{ $bus->placa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Botón de Búsqueda a ancho completo -->
                            <div class="col-md-4 col-lg-2 d-flex align-items-end pt-3 pt-md-0">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                {{-- El botón de Limpiar fue eliminado a petición del usuario. --}}
                            </div>
                        </div>
                    </form>
                </div>

                <hr class="mt-4 mb-4">

                <!-- 3. Tabla de Documentos -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark m-0">
                        <i class="fas fa-list"></i> Listado de Documentos
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <!-- CAMBIO: table-dark se reemplaza por table-primary (azul del sistema) -->
                        <thead class="table-primary text-white">
                        <tr>
                            <th>Bus / Placa</th>
                            <th>Tipo Documento</th>
                            <th>N° Documento</th>
                            <th>Emisión</th>
                            <th>Vencimiento</th>
                            <th>Días Restantes</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($documentos as $documento)
                            <tr class="{{ $documento->estado === 'vencido' ? 'table-danger' : ($documento->estado === 'por_vencer' ? 'table-warning' : '') }}">
                                <td>
                                    <small class="text-muted">{{ $documento->bus->placa ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $documento->tipo_documento_nombre }}</td>
                                <td>{{ $documento->numero_documento }}</td>
                                <td>{{ $documento->fecha_emision->format('d/m/Y') }}</td>
                                <td>{{ $documento->fecha_vencimiento->format('d/m/Y') }}</td>
                                <td>
                                    @if($documento->dias_hasta_vencimiento < 0)
                                        <span class="badge bg-danger">
                                            Vencido ({{ abs($documento->dias_hasta_vencimiento) }} días)
                                        </span>
                                    @else
                                        <span class="badge {{ $documento->dias_hasta_vencimiento <= 30 ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ $documento->dias_hasta_vencimiento }} días
                                        </span>
                                    @endif
                                </td>
                                <td>{!! $documento->estado_badge !!}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('documentos-buses.show', $documento->id) }}"
                                           class="btn btn-sm primary" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('documentos-buses.edit', $documento->id) }}"
                                           class="btn btn-sm primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($documento->archivo_url)
                                            <a href="{{ route('documentos-buses.descargar', $documento->id) }}"
                                               class="btn btn-sm btn-success" title="Descargar archivo">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        <button type="button"
                                                class="btn btn-sm primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmationModal"
                                                data-id="{{ $documento->id }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <!-- Formulario de eliminación oculto (se usa en el modal) -->
                                        <form id="delete-form-{{ $documento->id }}"
                                              action="{{ route('documentos-buses.destroy', $documento->id) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                    <p class="text-muted h5">No se encontraron documentos que coincidan con los criterios de búsqueda.</p>
                                    <a href="{{ route('documentos-buses.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i> Registrar documento
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Mostrando {{ $documentos->firstItem() ?? 0 }} a {{ $documentos->lastItem() ?? 0 }}
                        de {{ $documentos->total() }} documentos
                    </div>
                    <div>
                        {{ $documentos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="h6">¿Está seguro que desea eliminar este documento?</p>
                    <small class="text-muted">Esta acción no se puede deshacer.</small>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos Adicionales (Mejorados) -->
    <style>
        /* Estilos de Card para las estadísticas */
        .card.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
        .card.border-left-success { border-left: 0.25rem solid #4e73df !important; }
        .card.border-left-warning { border-left: 0.25rem solid #4e73df !important; }
        .card.border-left-danger { border-left: 0.25rem solid #4e73df !important; }

        /* Mejora visual de la tabla en pantallas pequeñas */
        @media (max-width: 768px) {s
            .table-responsive .table td:nth-child(5),
            .table-responsive .table th:nth-child(5),
            .table-responsive .table td:nth-child(6),
            .table-responsive .table th:nth-child(6) {
                /* Ocultar columnas menos importantes para móviles */
                display: none;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            let formToSubmit = null;

            // 1. Manejar clic en el botón de eliminar de la tabla
            document.querySelectorAll('.btn-eliminar').forEach(button => {
                button.addEventListener('click', function() {
                    const documentoId = this.getAttribute('data-id');
                    formToSubmit = document.getElementById(`delete-form-${documentoId}`);
                });
            });

            // 2. Manejar clic en el botón 'Eliminar' dentro del modal
            confirmDeleteButton.addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });

            // 3. Limpiar la referencia del formulario al cerrar el modal (Buena práctica)
            deleteConfirmationModal.addEventListener('hidden.bs.modal', function () {
                formToSubmit = null;
            });
        });
    </script>
@endsection
