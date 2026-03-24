@extends('layouts.layoutadmin')

@section('title', 'Listado de Rentas de Viaje Express')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-bus me-2"></i>Listado de Rentas de Viaje Express
                </h2>

                {{-- Botón Registrar --}}
                {{-- Botón Registrar que abre el Modal --}}
                <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevaRenta">
                    <i class="fas fa-plus me-1"></i> Registrar Nueva Renta
                </button>
            </div>

            <div class="card-body">

                {{-- Mensajes --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <strong class="me-2">¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong class="me-2">Error:</strong> {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                {{-- Formulario de búsqueda y filtros --}}
                <form method="GET" action="{{ route('rentas.index') }}" id="formFiltros">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Búsqueda General</label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <input type="text" name="buscar" class="form-control" placeholder="Buscar por cliente o destino..." value="{{ request('buscar') }}">
                            </div>
                            <div class="col-md-6 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-search me-2"></i>Buscar
                                </button>
                                <button class="btn btn-outline-primary flex-fill" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados">
                                    <i class="fas fa-sliders-h me-2"></i>Filtros
                                </button>
                                @if(request()->hasAny(['buscar','estado','tipo_evento','fecha_inicio','fecha_fin','cliente','destino']))
                                    <a href="{{ route('rentas.index') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="fas fa-times me-2"></i>Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Filtros avanzados colapsables --}}
                    <div class="collapse" id="filtrosAvanzados">
                        <div class="card mb-3 bg-light border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">Filtros Adicionales</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Fecha inicio</label>
                                        <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Fecha fin</label>
                                        <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Cliente</label>
                                        <input type="text" name="cliente" class="form-control" placeholder="Nombre del cliente..." value="{{ request('cliente') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Destino</label>
                                        <input type="text" name="destino" class="form-control" placeholder="Destino..." value="{{ request('destino') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Selector de cantidad de registros --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold">Mostrar:</label>
                            <select name="per_page" class="form-select form-select-sm border-primary" style="width:90px;" onchange="this.form.submit()">
                                <option value="5"  {{ request('per_page') == 5  ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <span>registros</span>
                        </div>
                    </div>
                </form>

                {{-- Tabla de Rentas --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Destino</th>
                            <th>Fechas</th>
                            <th>Evento</th>
                            <th>Pasajeros</th>
                            <th>Total (Lps)</th>
                            <th>Anticipo (Lps)</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rentas as $key => $renta)
                            <tr>
                                <td>{{ ($rentas->currentPage()-1)*$rentas->perPage()+$key+1 }}</td>
                                <td>
                                    <div class="fw-500">{{ $renta->nombre_completo }}</div>
                                    @if(isset($renta->cliente->dni))
                                        <div class="text-muted" style="font-size:0.85em;">({{ $renta->cliente->dni }})</div>
                                    @endif
                                </td>
                                <td>{{ $renta->destino }}</td>
                                <td>
                                    Inicio: {{ \Carbon\Carbon::parse($renta->fecha_inicio)->format('d/m/Y') }}<br>
                                    Fin: {{ \Carbon\Carbon::parse($renta->fecha_fin)->format('d/m/Y') }}
                                </td>
                                <td>{{ $renta->tipo_evento }}</td>
                                <td>{{ $renta->num_pasajeros_confirmados ?? $renta->num_pasajeros_estimados ?? 'N/A' }}</td>
                                <td><strong>{{ number_format($renta->total_tarifa,2) }}</strong></td>
                                <td>{{ number_format($renta->anticipo,2) }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('rentas.edit', $renta->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="fas fa-exclamation-circle fa-2x mb-2 d-block"></i>
                                    No hay rentas registradas
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Mostrando
                        <span class="fw-semibold text-dark">{{ $rentas->firstItem() ?? 0 }}</span>
                        –
                        <span class="fw-semibold text-dark">{{ $rentas->lastItem() ?? 0 }}</span>
                        de
                        <span class="fw-semibold text-dark">{{ $rentas->total() }}</span>
                        rentas
                    </div>
                    @if($rentas->hasPages())
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $rentas->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $rentas->appends(request()->all())->previousPageUrl() }}">Anterior</a>
                                </li>
                                @for($page=1; $page<=$rentas->lastPage(); $page++)
                                    <li class="page-item {{ $page==$rentas->currentPage() ? 'active':'' }}">
                                        <a class="page-link" href="{{ $rentas->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $rentas->hasMorePages()?'':'disabled' }}">
                                    <a class="page-link" href="{{ $rentas->appends(request()->all())->nextPageUrl() }}">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Estilos de paginación --}}
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

    {{-- Select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.select2').select2({
                theme:'bootstrap-5',
                width:'100%',
                placeholder:function(){ return $(this).data('placeholder') || 'Seleccionar...'; },
                allowClear:true
            });
        });
    </script>
    {{-- Modal Crear Nueva Renta --}}
    <div class="modal fade" id="modalNuevaRenta" tabindex="-1" aria-labelledby="modalNuevaRentaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 rounded-3" style="overflow:hidden;">

                <!-- Header -->
                <div class="modal-header text-white border-0" style="background:#1e63b8; padding:1.25rem 1.5rem;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:34px;height:34px;background:rgba(255,255,255,0.2);">
                            <i class="fas fa-bus" style="font-size:13px;"></i>
                        </div>
                        <span style="font-size:15px;font-weight:500;">Registro de Renta de Viaje Express</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Formulario -->
                <form action="{{ route('rentas.store') }}" method="POST" id="registroRentaForm" class="p-3">
                    @csrf
                    <div class="modal-body" style="padding:1.5rem;">

                        <!-- Sección 1: Datos del Cliente y Partida -->
                        <h5 class="text-primary border-bottom pb-2">Datos del cliente y partida</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Nombre del cliente</label>
                                <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" placeholder="Escriba el nombre" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Correo electrónico</label>
                                <input type="email" name="email_cliente" id="email_cliente" class="form-control" placeholder="Escriba el correo">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">DNI / Identificación</label>
                                <input type="text" name="dni_cliente" id="dni_cliente_select" class="form-control" required list="clientes_disponibles">
                                <datalist id="clientes_disponibles">
                                    @isset($clientes)
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->dni }}" data-nombre="{{ $cliente->nombre }}" data-email="{{ $cliente->email }}">
                                        @endforeach
                                    @endisset
                                </datalist>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Origen</label>
                                <select name="punto_partida" class="form-select" required>
                                    <option value="">Seleccione origen...</option>
                                    @foreach ($departamentos as $depto)
                                        <option value="{{ $depto }}">{{ $depto }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Destino</label>
                                <select name="destino" class="form-select" required>
                                    <option value="">Seleccione destino...</option>
                                    @foreach ($departamentos as $depto)
                                        <option value="{{ $depto }}">{{ $depto }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Sección 2: Detalles del Viaje -->
                        <h5 class="text-primary border-bottom pb-2">Detalles del viaje</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Fecha de inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Fecha de fin</label>
                                <input type="date" name="fecha_fin" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Tipo de evento</label>
                                <select name="tipo_evento" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Familiar">Familiar</option>
                                    <option value="Campamento">Campamento</option>
                                    <option value="Excursión">Excursión</option>
                                    <option value="Educativo">Educativo</option>
                                    <option value="Empresarial">Empresarial</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Pasajeros Confirmados</label>
                                <input type="number" name="num_pasajeros_confirmados" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Horario Salida</label>
                                <div class="input-group">
                                    <select id="hora_salida_select" class="form-select" required>
                                        @for ($h = 1; $h <= 12; $h++) <option value="{{ $h }}">{{ $h }} AM</option> @endfor
                                        @for ($h = 1; $h <= 11; $h++) <option value="{{ $h + 12 }}">{{ $h }} PM</option> @endfor
                                    </select>
                                    <select id="minuto_salida_select" class="form-select" required>
                                        @for ($m = 0; $m < 60; $m += 5) <option value="{{ sprintf('%02d', $m) }}">{{ sprintf('%02d', $m) }}</option> @endfor
                                    </select>
                                </div>
                                <input type="hidden" name="hora_salida" id="hora_salida_final">
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Tarifa Base (Lps)</label>
                                    <input type="number" step="0.01" name="tarifa" id="tarifa" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Anticipo (Lps)</label>
                                    <input type="number" step="0.01" name="anticipo" id="anticipo" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Total (Lps)</label>
                                    <input type="number" id="total" class="form-control bg-light" readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-top d-flex justify-content-end gap-2"
                         style="border-color:#e5e7eb !important;padding:1rem 1.5rem;">
                        <button type="button" class="btn btn-secondary d-flex align-items-center gap-2"
                                data-bs-dismiss="modal">
                            <i class="fas fa-times" style="font-size:12px;"></i> Cancelar
                        </button>

                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="fas fa-save" style="font-size:12px;"></i> Reservar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        const tarifaInput = document.getElementById('tarifa');
        const anticipoInput = document.getElementById('anticipo');
        const totalInput = document.getElementById('total');

        function calcularTotal() {
            const tarifa = parseFloat(tarifaInput.value) || 0;
            const anticipo = parseFloat(anticipoInput.value) || 0;
            const totalCalculado = tarifa - anticipo;
            totalInput.value = totalCalculado.toFixed(2);
        }

        tarifaInput.addEventListener('input', calcularTotal);
        anticipoInput.addEventListener('input', calcularTotal);
    </script>
@endsection
