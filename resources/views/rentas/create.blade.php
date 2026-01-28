@extends('layouts.layoutadmin')

@section('title', 'Registro de Renta de Viaje Express')

@section('content')
    {{-- Definición de los Departamentos de Honduras para los selectores --}}
    @php
        $departamentos = [
            'Atlántida', 'Colón', 'Comayagua', 'Copán', 'Cortés',
            'Choluteca', 'El Paraíso', 'Francisco Morazán', 'Gracias a Dios',
            'Intibucá', 'Islas de la Bahía', 'La Paz', 'Lempira',
            'Ocotepeque', 'Olancho', 'Santa Bárbara', 'Valle', 'Yoro'
        ];
    @endphp

    <div class="container mt-4">
        {{-- Encabezado y título principal --}}
        <h2 class="mb-4 text-center">Registro de renta de viaje express </h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>¡Ups! Algo salió mal.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario de Registro --}}
        <form action="{{ route('rentas.store') }}" method="POST" id="registroRentaForm" class="card p-4 shadow-sm rounded-3">
            @csrf

            {{-- Sección 1: Datos del Cliente y Partida --}}
            <h3>Datos del cliente y partida</h3>
            <hr>

            {{-- Fila 1: Cliente (Nombre, Correo, DNI) --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nombre_cliente" class="form-label">Nombre del cliente</label>
                    <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" placeholder="Escriba el nombre" required value="{{ old('nombre_cliente') }}">
                </div>
                <div class="col-md-4">
                    <label for="email_cliente" class="form-label">Correo electrónico</label>
                    <input type="email" name="email_cliente" id="email_cliente" class="form-control" placeholder="Escriba el correo" value="{{ old('email_cliente') }}">
                </div>
                <div class="col-md-4">
                    <label for="dni_cliente_select" class="form-label">DNI / identificación del Cliente</label>
                    <input type="text" name="dni_cliente" id="dni_cliente_select" class="form-control" required
                           maxlength="20"
                           placeholder="Escriba o seleccione la identificación"
                           list="clientes_disponibles"
                           value="{{ old('dni_cliente') }}">
                    <datalist id="clientes_disponibles">
                        @if (isset($clientes))
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->dni }}" data-nombre="{{ $cliente->nombre }}" data-email="{{ $cliente->email }}">
                                    {{ $cliente->nombre }} ({{ $cliente->dni }})
                                </option>
                            @endforeach
                        @endif
                    </datalist>
                </div>
            </div>

            {{-- 🔑 Fila 2: Punto de Partida (Origen) y Destino (MÁXIMA SEPARACIÓN) --}}
            <div class="row mb-4">
                {{-- Origen: Usamos col-md-4 y me-5 (margin-end máxima) --}}
                <div class="col-md-4 me-5">
                    <label for="punto_partida" class="form-label">Origen</label>
                    <select name="punto_partida" id="punto_partida" class="form-select" required>
                        <option value="">Seleccione un Departamento...</option>
                        @foreach ($departamentos as $depto)
                            <option value="{{ $depto }}" {{ old('punto_partida') == $depto ? 'selected' : '' }}>{{ $depto }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Destino: Usamos col-md-4, dejando un gran espacio central --}}
                <div class="col-md-4">
                    <label for="destino" class="form-label">Destino</label>
                    <select name="destino" id="destino" class="form-select" required>
                        <option value="">Seleccione un Departamento...</option>
                        @foreach ($departamentos as $depto)
                            <option value="{{ $depto }}" {{ old('destino') == $depto ? 'selected' : '' }}>{{ $depto }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Sección 2: Detalles del Viaje --}}
            <h3>Detalles del viaje</h3>
            <hr>

            {{-- 🔑 Fila 3: Fechas y Tipo de Evento (ACOMETIDOS) --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required value="{{ old('fecha_inicio') }}">
                </div>
                <div class="col-md-3">
                    <label for="fecha_fin" class="form-label">Fecha de fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required value="{{ old('fecha_fin') }}">
                </div>
                <div class="col-md-3">
                    <label for="tipo_evento" class="form-label">Tipo de evento</label>
                    <select name="tipo_evento" id="tipo_evento" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option value="Familiar" {{ old('tipo_evento') == 'Familiar' ? 'selected' : '' }}>Familiar</option>
                        <option value="Campamento" {{ old('tipo_evento') == 'Campamento' ? 'selected' : '' }}>Campamento</option>
                        <option value="Excursión" {{ old('tipo_evento') == 'Excursión' ? 'selected' : '' }}>Excursión</option>
                        <option value="Educativo" {{ old('tipo_evento') == 'Educativo' ? 'selected' : '' }}>Educativo</option>
                        <option value="Empresarial" {{ old('tipo_evento') == 'Empresarial' ? 'selected' : '' }}>Empresarial</option>
                    </select>
                </div>
            </div>

            {{-- 🔑 Fila 4: Pasajeros y Horarios (ACOMETIDOS) --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="num_pasajeros_confirmados" class="form-label">Pasajeros confirmados</label>
                    <input type="number" name="num_pasajeros_confirmados" id="num_pasajeros_confirmados" class="form-control" value="{{ old('num_pasajeros_confirmados') }}">
                </div>
                <div class="col-md-3">
                    <label for="num_pasajeros_estimados" class="form-label">Pasajeros estimados</label>
                    <input type="number" name="num_pasajeros_estimados" id="num_pasajeros_estimados" class="form-control" value="{{ old('num_pasajeros_estimados') }}">
                </div>

                {{-- HORA DE SALIDA: Horario de apertura --}}
                <div class="col-md-3">
                    <label class="form-label">Horario de apertura</label>
                    <div class="input-group">
                        <select name="hora_salida_select" id="hora_salida_select" class="form-select" required>
                            <option value="">Hora</option>
                            @for ($h = 1; $h <= 12; $h++)
                                <option value="{{ $h }}" data-hora24="{{ $h == 12 ? 12 : $h }}" {{ old('hora_salida_select') == $h ? 'selected' : '' }}>{{ $h }} AM</option>
                            @endfor
                            @for ($h = 1; $h <= 11; $h++)
                                <option value="{{ $h + 12 }}" data-hora24="{{ $h + 12 }}" {{ old('hora_salida_select') == $h + 12 ? 'selected' : '' }}>{{ $h }} PM</option>
                            @endfor
                            <option value="0" data-hora24="0" {{ old('hora_salida_select') == '0' ? 'selected' : '' }}>12 AM</option>
                        </select>
                        <span class="input-group-text px-2 border-start-0 border-end-0">:</span>
                        <select name="minuto_salida_select" id="minuto_salida_select" class="form-select" required>
                            <option value="">Min</option>
                            @for ($m = 0; $m < 60; $m += 5)
                                @php $min_str = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $min_str }}" {{ old('minuto_salida_select') == $min_str ? 'selected' : '' }}>{{ $min_str }}</option>
                            @endfor
                        </select>
                    </div>
                    <input type="hidden" name="hora_salida" id="hora_salida_final" value="{{ old('hora_salida') }}">
                </div>

                {{-- HORA DE RETORNO: Horario de cierre --}}
                <div class="col-md-3">
                    <label class="form-label">Horario de cierre</label>
                    <div class="input-group">
                        <select name="hora_retorno_select" id="hora_retorno_select" class="form-select" required>
                            <option value="">Hora</option>
                            @for ($h = 1; $h <= 12; $h++)
                                <option value="{{ $h }}" data-hora24="{{ $h == 12 ? 12 : $h }}" {{ old('hora_retorno_select') == $h ? 'selected' : '' }}>{{ $h }} AM</option>
                            @endfor
                            @for ($h = 1; $h <= 11; $h++)
                                <option value="{{ $h + 12 }}" data-hora24="{{ $h + 12 }}" {{ old('hora_retorno_select') == $h + 12 ? 'selected' : '' }}>{{ $h }} PM</option>
                            @endfor
                            <option value="0" data-hora24="0" {{ old('hora_retorno_select') == '0' ? 'selected' : '' }}>12 AM</option>
                        </select>
                        <span class="input-group-text px-2 border-start-0 border-end-0">:</span>
                        <select name="minuto_retorno_select" id="minuto_retorno_select" class="form-select" required>
                            <option value="">Min</option>
                            @for ($m = 0; $m < 60; $m += 5)
                                @php $min_str = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $min_str }}" {{ old('minuto_retorno_select') == $min_str ? 'selected' : '' }}>{{ $min_str }}</option>
                            @endfor
                        </select>
                    </div>
                    <input type="hidden" name="hora_retorno" id="hora_retorno_final" value="{{ old('hora_retorno') }}">
                </div>
            </div>

            {{-- Sección 3: Finanzas --}}
            <h3>Información financiera</h3>
            <hr>
            {{-- Fila 5: Tarifa, Descuento, Total y Anticipo --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="tarifa" class="form-label">Tarifa base (Lps)</label>
                    <input type="number" step="0.01" name="tarifa" id="tarifa" class="form-control" required value="{{ old('tarifa') }}">
                </div>
                <div class="col-md-3">
                    <label for="descuento" class="form-label">Descuento (%) aplicado</label>
                    <select id="descuento_display" class="form-select" disabled>
                        <option value="0">0% (Ninguno)</option>
                        <option value="5">Familiar 5%</option>
                        <option value="8">Campamento 8%</option>
                        <option value="10">Excursión 10%</option>
                        <option value="15">Educativo 15%</option>
                        <option value="12">Empresarial 12%</option>
                    </select>
                    <input type="hidden" name="descuento_valor" id="descuento_valor" value="{{ old('descuento_valor') ?? '0' }}">
                </div>
                <div class="col-md-3">
                    <label for="total" class="form-label">Total a pagar (Lps)</label>
                    <input type="number" step="0.01" name="total" id="total" class="form-control" readonly value="{{ old('total') ?? '0.00' }}">
                </div>
                <div class="col-md-3">
                    <label for="anticipo" class="form-label">Anticipo (Lps)</label>
                    <input type="number" step="0.01" name="anticipo" id="anticipo" class="form-control" value="{{ old('anticipo') }}">
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-4">Reservar renta </button>
                <button type="button" class="btn btn-warning px-4" id="limpiarFormulario">Limpiar</button>
                <a href="{{ route('rentas.index') }}" class="btn btn-secondary px-4">Cancelar</a>
            </div>
        </form>
    </div>

    {{-- Script para la lógica (Se mantiene igual, solo se actualizan los ID's de fila/columna) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... (Variables) ...
            const tipoEvento = document.getElementById('tipo_evento');
            const descuentoValorInput = document.getElementById('descuento_valor');
            const tarifaInput = document.getElementById('tarifa');
            const totalInput = document.getElementById('total');
            const limpiarBoton = document.getElementById('limpiarFormulario');
            const formulario = document.getElementById('registroRentaForm');
            const descuentos = {
                'Familiar': 5,
                'Campamento': 8,
                'Excursión': 10,
                'Educativo': 15,
                'Empresarial': 12
            };
            const dniClienteSelect = document.getElementById('dni_cliente_select');
            const nombreClienteInput = document.getElementById('nombre_cliente');
            const emailClienteInput = document.getElementById('email_cliente');
            const datalist = document.getElementById('clientes_disponibles');
            const horaSalidaSelect = document.getElementById('hora_salida_select');
            const minutoSalidaSelect = document.getElementById('minuto_salida_select');
            const horaSalidaFinalInput = document.getElementById('hora_salida_final');
            const horaRetornoSelect = document.getElementById('hora_retorno_select');
            const minutoRetornoSelect = document.getElementById('minuto_retorno_select');
            const horaRetornoFinalInput = document.getElementById('hora_retorno_final');


            // --- FUNCIONES DE HORA ---
            function updateFinalTimeInput(horaSelect, minutoSelect, finalInput) {
                const hora24 = horaSelect.value;
                const minutos = minutoSelect.value;
                if (hora24 && minutos) {
                    let hourValue = parseInt(hora24);
                    const hora24Str = String(hourValue).padStart(2, '0');
                    finalInput.value = `${hora24Str}:${minutos}`;
                } else {
                    finalInput.value = '';
                }
            }

            // --- Lógica del Cliente con Datalist ---
            dniClienteSelect.addEventListener('input', function() {
                const selectedDNI = this.value;
                const option = datalist.querySelector(`option[value="${selectedDNI}"]`);

                if (option) {
                    nombreClienteInput.value = option.getAttribute('data-nombre');
                    emailClienteInput.value = option.getAttribute('data-email');
                } else {
                    if (selectedDNI === '') {
                        nombreClienteInput.value = '';
                        emailClienteInput.value = '';
                    }
                }
            });

            // --- Event Listeners y Inicialización ---
            horaSalidaSelect.addEventListener('change', () => updateFinalTimeInput(horaSalidaSelect, minutoSalidaSelect, horaSalidaFinalInput));
            minutoSalidaSelect.addEventListener('change', () => updateFinalTimeInput(horaSalidaSelect, minutoSalidaSelect, horaSalidaFinalInput));
            horaRetornoSelect.addEventListener('change', () => updateFinalTimeInput(horaRetornoSelect, minutoRetornoSelect, horaRetornoFinalInput));
            minutoRetornoSelect.addEventListener('change', () => updateFinalTimeInput(horaRetornoSelect, minutoRetornoSelect, horaRetornoFinalInput));
            tipoEvento.addEventListener('change', establecerDescuento);
            tarifaInput.addEventListener('input', calcularTotal);

            // Inicialización al cargar la página
            establecerDescuento();
            calcularTotal();
            updateFinalTimeInput(horaSalidaSelect, minutoSalidaSelect, horaSalidaFinalInput);
            updateFinalTimeInput(horaRetornoSelect, minutoRetornoSelect, horaRetornoFinalInput);
            dniClienteSelect.dispatchEvent(new Event('input'));

            // Limpiar Formulario
            limpiarBoton.addEventListener('click', function() {
                formulario.reset();
                descuentoValorInput.value = '0';
                totalInput.value = '0.00';
                horaSalidaFinalInput.value = '';
                horaRetornoFinalInput.value = '';
                nombreClienteInput.value = '';
                emailClienteInput.value = '';
            });

            // --- Funciones de Cálculo ---
            function calcularTotal() {
                const tarifa = parseFloat(tarifaInput.value) || 0;
                const descuentoPorcentaje = parseFloat(descuentoValorInput.value) || 0;

                if (tarifa > 0) {
                    const descuentoMonto = tarifa * (descuentoPorcentaje / 100);
                    const totalCalculado = tarifa - descuentoMonto;
                    totalInput.value = totalCalculado.toFixed(2);
                } else {
                    totalInput.value = '0.00';
                }
            }

            function establecerDescuento() {
                const evento = tipoEvento.value;
                const porcentaje = descuentos[evento] || 0;
                descuentoValorInput.value = porcentaje;
                const descuentoDisplay = document.getElementById('descuento_display');
                let encontrado = false;
                for (let i = 0; i < descuentoDisplay.options.length; i++) {
                    if (descuentoDisplay.options[i].value == porcentaje) {
                        descuentoDisplay.selectedIndex = i;
                        encontrado = true;
                        break;
                    }
                }
                if (!encontrado) {
                    descuentoDisplay.selectedIndex = 0;
                }
                calcularTotal();
            }
        });
    </script>
@endsection
