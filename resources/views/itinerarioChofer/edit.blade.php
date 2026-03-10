@extends('layouts.layoutadmin')

@section('title', 'Editar Itinerario')

@section('content')

    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-edit me-2"></i>Editar Itinerario
                </h2>

                <a href="{{ route('itinerarioChofer.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>

            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <strong>Corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                <form action="{{ route('itinerarioChofer.update',$itinerarioChofer->id) }}" method="POST">

                    @csrf
                    @method('PUT')


                    {{-- SECCIÓN ASIGNACIÓN --}}
                    <div class="card border-0 shadow-sm mb-4" style="background:#f8faff;">
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-user me-1"></i>Chofer
                                </label>

                                <select name="chofer_id" class="form-select" required>

                                    @foreach($choferes as $chofer)

                                        <option value="{{ $chofer->id }}"
                                            {{ $itinerarioChofer->chofer_id == $chofer->id ? 'selected' : '' }}>

                                            {{ $chofer->name }}

                                        </option>

                                    @endforeach

                                </select>
                            </div>



                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-route me-1"></i>Ruta
                                </label>

                                <select name="ruta_id" class="form-select" required>

                                    @foreach($rutas as $ruta)

                                        <option value="{{ $ruta->id }}"
                                            {{ $itinerarioChofer->ruta_id == $ruta->id ? 'selected' : '' }}>

                                            {{ $ruta->origen }} → {{ $ruta->destino }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>



                            <div class="mb-0">

                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-calendar-alt me-1"></i>Fecha y Hora
                                </label>

                                <input type="datetime-local"
                                       name="fecha"
                                       class="form-control"
                                       value="{{ \Carbon\Carbon::parse($itinerarioChofer->fecha)->format('Y-m-d\TH:i') }}"
                                       required>

                                <small class="text-muted">Selecciona el día y la hora de salida</small>

                            </div>

                        </div>
                    </div>



                    {{-- SECCIÓN PARADAS --}}
                    <div class="card border-0 shadow-sm mb-4" style="background:#f8faff;">
                        <div class="card-body">

                            <h6 class="fw-bold mb-3"
                                style="color:#0284c7;font-size:.75rem;text-transform:uppercase;letter-spacing:.07em;">

                                <i class="fas fa-map-marker-alt me-1"></i>Paradas intermedias
                                <span class="text-muted fw-normal ms-1"
                                      style="font-size:.7rem;text-transform:none;">(opcional)</span>

                            </h6>


                            <div id="frm-paradas-container" class="d-flex flex-column gap-2">


                                @if($itinerarioChofer->paradas->count() > 0)

                                    @foreach($itinerarioChofer->paradas as $parada)

                                        <div class="frm-parada-item d-flex align-items-center gap-2 p-2 rounded"
                                             style="background:#fff;border:1px solid #e2edf8;">

                                            <input type="text"
                                                   name="paradas[lugar][]"
                                                   value="{{ $parada->lugar_parada }}"
                                                   class="form-control form-control-sm">

                                            <input type="number"
                                                   name="paradas[tiempo][]"
                                                   value="{{ $parada->tiempo_parada }}"
                                                   class="form-control form-control-sm"
                                                   style="width:120px;flex-shrink:0;">

                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger frm-btn-remove"
                                                    style="width:34px;height:34px;flex-shrink:0;padding:0;">

                                                <i class="fas fa-times"></i>

                                            </button>

                                        </div>

                                    @endforeach

                                @else

                                    <div class="frm-parada-item d-flex align-items-center gap-2 p-2 rounded"
                                         style="background:#fff;border:1px solid #e2edf8;">

                                        <input type="text"
                                               name="paradas[lugar][]"
                                               placeholder="Ej: Terminal Norte"
                                               class="form-control form-control-sm">

                                        <input type="number"
                                               name="paradas[tiempo][]"
                                               placeholder="0"
                                               class="form-control form-control-sm"
                                               style="width:120px;flex-shrink:0;">

                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger frm-btn-remove"
                                                style="width:34px;height:34px;flex-shrink:0;padding:0;">

                                            <i class="fas fa-times"></i>

                                        </button>

                                    </div>

                                @endif

                            </div>



                            <button type="button"
                                    id="frm-btn-add"
                                    class="btn btn-sm mt-3"
                                    style="background:#e0f2fe;color:#0284c7;border:1px dashed #bae6fd;font-weight:600;">

                                <i class="fas fa-plus me-1"></i>Agregar parada

                            </button>

                        </div>
                    </div>



                    {{-- BOTONES --}}
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('itinerarioChofer.index') }}"
                           class="btn btn-outline-secondary">

                            <i class="fas fa-times me-1"></i>Cancelar

                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-save me-1"></i>Actualizar Itinerario

                        </button>

                    </div>


                </form>

            </div>
        </div>
    </div>



    <script>

        document.getElementById('frm-btn-add').addEventListener('click', function () {

            var container = document.getElementById('frm-paradas-container');

            var div = document.createElement('div');

            div.className = 'frm-parada-item d-flex align-items-center gap-2 p-2 rounded';

            div.style.cssText = 'background:#fff;border:1px solid #e2edf8;';

            div.innerHTML = `
<input type="text" name="paradas[lugar][]" placeholder="Ej: Terminal Norte" class="form-control form-control-sm">

<input type="number" name="paradas[tiempo][]" placeholder="0" class="form-control form-control-sm" style="width:120px;flex-shrink:0;">

<button type="button" class="btn btn-sm btn-outline-danger frm-btn-remove" style="width:34px;height:34px;flex-shrink:0;padding:0;">
<i class="fas fa-times"></i>
</button>
`;

            container.appendChild(div);

        });


        document.addEventListener('click', function (e) {

            if (e.target.closest('.frm-btn-remove')) {

                var items = document.querySelectorAll('.frm-parada-item');

                var item = e.target.closest('.frm-parada-item');

                if (items.length > 1) {

                    item.remove();

                } else {

                    item.querySelectorAll('input').forEach(function(i){ i.value = '' });

                }

            }

        });

    </script>


@endsection
