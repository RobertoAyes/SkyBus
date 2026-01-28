@extends('layouts.layoutadmin')

@section('title', 'Escanear Código QR - Abordaje')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:1.8rem;">
                    <i class="fas fa-qrcode me-2"></i>Check-in con Código QR
                </h2>
                <p class="mt-2 mb-0">Escanea el código QR del pasajero para confirmar su abordaje</p>
            </div>

            <div class="card-body">
                <!-- Área de escaneo -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-camera me-2"></i>Escanear Código QR</h5>
                            </div>
                            <div class="card-body text-center">
                                <div id="reader" style="width: 100%;"></div>

                                <!-- Opción manual -->
                                <div class="mt-3">
                                    <p class="text-muted">O ingresa el código manualmente:</p>
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                        <input
                                            type="text"
                                            id="codigoManual"
                                            class="form-control"
                                            placeholder="Ingrese código QR"
                                        >
                                        <button class="btn btn-primary" onclick="validarCodigoManual()">
                                            <i class="fas fa-check me-1"></i>Validar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Área de información del pasajero -->
                    <div class="col-md-6">
                        <div id="areaDatos" style="display:none;">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-user-check me-2"></i>Datos del Pasajero</h5>
                                </div>
                                <div class="card-body">
                                    <div id="datosPasajero"></div>

                                    <!-- Observaciones -->
                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Observaciones (Opcional)</label>
                                        <textarea
                                            id="observaciones"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Agregar observaciones..."
                                            maxlength="500"
                                        ></textarea>
                                    </div>

                                    <!-- Botones de acción -->
                                    <div class="d-grid gap-2 mt-4">
                                        <button class="btn btn-success btn-lg" onclick="confirmarAbordaje()">
                                            <i class="fas fa-check-circle me-2"></i>Confirmar Abordaje
                                        </button>
                                        <button class="btn btn-outline-secondary" onclick="cancelarValidacion()">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Área de alertas -->
                        <div id="areaAlertas"></div>
                    </div>
                </div>

                <!-- Historial reciente -->
                <div class="mt-4">
                    <a href="{{ route('abordajes.historial') }}" class="btn btn-outline-primary">
                        <i class="fas fa-history me-2"></i>Ver Historial de Abordajes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Librería Html5-QRCode -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        let reservaActual = null;
        let html5QrCode = null;

        // Inicializar escáner QR
        document.addEventListener('DOMContentLoaded', function() {
            html5QrCode = new Html5Qrcode("reader");

            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanError
            ).catch(err => {
                console.error("Error al iniciar la cámara:", err);
                mostrarAlerta('No se pudo acceder a la cámara. Use el ingreso manual.', 'warning');
            });
        });

        // Cuando se escanea exitosamente
        function onScanSuccess(decodedText, decodedResult) {
            html5QrCode.pause();
            validarCodigo(decodedText);
        }

        function onScanError(errorMessage) {
            // Ignorar errores continuos de escaneo
        }

        // Validar código manual
        function validarCodigoManual() {
            const codigo = document.getElementById('codigoManual').value.trim();
            if (!codigo) {
                mostrarAlerta('Por favor ingrese un código QR', 'warning');
                return;
            }
            validarCodigo(codigo);
        }

        // Validar código QR con el servidor
        function validarCodigo(codigoQR) {
            mostrarAlerta('Validando código...', 'info');

            fetch('{{ route("abordajes.validar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ codigo_qr: codigoQR })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        reservaActual = data.datos;
                        mostrarDatosPasajero(data.datos);
                        mostrarAlerta(data.message, data.tipo_alerta);
                    } else {
                        mostrarAlerta(data.message, data.tipo_alerta);
                        if (html5QrCode) {
                            setTimeout(() => html5QrCode.resume(), 2000);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarAlerta('Error al validar el código QR', 'error');
                    if (html5QrCode) {
                        setTimeout(() => html5QrCode.resume(), 2000);
                    }
                });
        }

        // Mostrar datos del pasajero
        function mostrarDatosPasajero(datos) {
            const html = `
        <div class="mb-3">
            <h6 class="text-primary"><i class="fas fa-user me-2"></i>Información del Pasajero</h6>
            <p class="mb-1"><strong>Nombre:</strong> ${datos.pasajero.nombre_completo}</p>
            <p class="mb-1"><strong>DNI:</strong> ${datos.pasajero.dni}</p>
            <p class="mb-1"><strong>Email:</strong> ${datos.pasajero.email}</p>
            <p class="mb-1"><strong>Teléfono:</strong> ${datos.pasajero.telefono}</p>
        </div>
        <hr>
        <div class="mb-3">
            <h6 class="text-primary"><i class="fas fa-bus me-2"></i>Información del Viaje</h6>
            <p class="mb-1"><strong>Ruta:</strong> ${datos.viaje.ruta}</p>
            <p class="mb-1"><strong>Origen:</strong> ${datos.viaje.origen}</p>
            <p class="mb-1"><strong>Destino:</strong> ${datos.viaje.destino}</p>
            <p class="mb-1"><strong>Fecha/Hora:</strong> ${datos.viaje.fecha_salida}</p>
            <p class="mb-1"><strong>Asiento:</strong> ${datos.viaje.asiento}</p>
        </div>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Código QR:</strong> ${datos.codigo_qr}
        </div>
    `;

            document.getElementById('datosPasajero').innerHTML = html;
            document.getElementById('areaDatos').style.display = 'block';
        }

        // Confirmar abordajes
        function confirmarAbordaje() {
            if (!reservaActual) {
                mostrarAlerta('No hay datos de reserva para confirmar', 'error');
                return;
            }

            const observaciones = document.getElementById('observaciones').value;

            mostrarAlerta('Confirmando abordajes...', 'info');

            fetch('{{ route("abordajes.confirmar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    reserva_id: reservaActual.reserva_id,
                    codigo_qr: reservaActual.codigo_qr,
                    observaciones: observaciones
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarAlerta(data.message, data.tipo_alerta);
                        setTimeout(() => {
                            cancelarValidacion();
                            if (html5QrCode) {
                                html5QrCode.resume();
                            }
                        }, 3000);
                    } else {
                        mostrarAlerta(data.message, data.tipo_alerta);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarAlerta('Error al confirmar el abordajes', 'error');
                });
        }

        // Cancelar validación
        function cancelarValidacion() {
            reservaActual = null;
            document.getElementById('areaDatos').style.display = 'none';
            document.getElementById('codigoManual').value = '';
            document.getElementById('observaciones').value = '';
            document.getElementById('areaAlertas').innerHTML = '';
            if (html5QrCode) {
                html5QrCode.resume();
            }
        }

        // Mostrar alertas
        function mostrarAlerta(mensaje, tipo) {
            const iconos = {
                'success': 'check-circle',
                'error': 'exclamation-circle',
                'warning': 'exclamation-triangle',
                'info': 'info-circle'
            };

            const colores = {
                'success': 'success',
                'error': 'danger',
                'warning': 'warning',
                'info': 'info'
            };

            const html = `
        <div class="alert alert-${colores[tipo]} alert-dismissible fade show" role="alert">
            <i class="fas fa-${iconos[tipo]} me-2"></i>${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

            document.getElementById('areaAlertas').innerHTML = html;
        }

        // Limpiar al salir
        window.addEventListener('beforeunload', function() {
            if (html5QrCode) {
                html5QrCode.stop();
            }
        });
    </script>
@endsection
