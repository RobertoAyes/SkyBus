@extends('layouts.layoutuser')

@section('title', 'Itinerario de Viajes')

@section('contenido')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8;">
                    <i class="fas fa-route me-2"></i>Itinerario de Viajes
                </h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDescargaPDF">
                    <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                </button>
            </div>
            <div class="card-body">
                <h5 class="mb-4"><i class="fas fa-user me-2"></i>Pasajero: {{ $usuario->name }}</h5>

                @forelse($reservas as $reserva)
                    {{-- Bloque de detalle de cada Reserva --}}
                    <div class="border-start border-4 border-primary p-3 mb-4 rounded shadow-sm">

                        {{-- Título y Estado --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">
                                <i class="fas fa-bus me-2 text-primary"></i>
                                {{ $reserva->viaje->origen->nombre ?? 'Origen' }} a {{ $reserva->viaje->destino->nombre ?? 'Destino' }}
                            </h5>
                            <span class="badge {{ $reserva->estado == 'confirmado' ? 'bg-success' : ($reserva->estado == 'pendiente' ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ strtoupper($reserva->estado) }}
                    </span>
                        </div>
                        <hr class="mt-1 mb-3">

                        {{-- Detalles del Viaje --}}
                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Origen:</strong> {{ $reserva->viaje->origen->nombre ?? 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-flag-checkered me-2 text-primary"></i><strong>Destino:</strong> {{ $reserva->viaje->destino->nombre ?? 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-calendar-alt me-2 text-primary"></i><strong>Fecha:</strong> {{ $reserva->viaje->fecha_hora_salida ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('d/m/Y') : 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-clock me-2 text-primary"></i><strong>Hora:</strong> {{ $reserva->viaje->fecha_hora_salida ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('H:i') : 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-chair me-2 text-primary"></i><strong>Asiento:</strong> {{ $reserva->asiento->numero_asiento ?? 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-ticket-alt me-2 text-primary"></i><strong>Código de Reserva:</strong> <span class="badge bg-info text-dark">{{ $reserva->codigo_reserva ?? 'N/A' }}</span></p>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            {{-- Compartir --}}
                            <button type="button"
                                    class="btn btn-outline-primary btn-sm btn-compartir"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalCompartir"
                                    data-reserva-id="{{ $reserva->id }}">
                                <i class="fas fa-share-alt me-1"></i>Compartir
                            </button>

                            {{-- Editar --}}
                            <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $reserva->id }}">
                                <i class="fas fa-edit me-1"></i>Editar
                            </button>
                        </div>
                    </div>

                    {{-- MODAL DE EDICIÓN (COLOR AZUL Y BOTÓN GUARDAR CENTRADO) --}}
                    <div class="modal fade" id="modalEditar{{ $reserva->id }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $reserva->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white"> {{-- CAMBIO AQUÍ: bg-primary text-white --}}
                                    <h5 class="modal-title" id="modalEditarLabel{{ $reserva->id }}">
                                        <i class="fas fa-edit me-2"></i>Editar Detalles de la Reserva
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('reserva.update', $reserva->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">

                                        {{-- Origen --}}
                                        <div class="mb-3">
                                            <label for="ciudad_origen_id{{ $reserva->id }}" class="form-label">
                                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Origen
                                            </label>
                                            <select name="ciudad_origen_id" id="ciudad_origen_id{{ $reserva->id }}" class="form-select">
                                                @foreach($ciudades as $ciudad)
                                                    <option value="{{ $ciudad->id }}" {{ $reserva->viaje->ciudad_origen_id == $ciudad->id ? 'selected' : '' }}>
                                                        {{ $ciudad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Destino --}}
                                        <div class="mb-3">
                                            <label for="ciudad_destino_id{{ $reserva->id }}" class="form-label">
                                                <i class="fas fa-flag-checkered me-2 text-primary"></i>Destino
                                            </label>
                                            <select name="ciudad_destino_id" id="ciudad_destino_id{{ $reserva->id }}" class="form-select">
                                                @foreach($ciudades as $ciudad)
                                                    <option value="{{ $ciudad->id }}" {{ $reserva->viaje->ciudad_destino_id == $ciudad->id ? 'selected' : '' }}>
                                                        {{ $ciudad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Fecha y Hora --}}
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="fecha_salida{{ $reserva->id }}" class="form-label">
                                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Fecha
                                                </label>
                                                @php
                                                    $fecha = $reserva->viaje->fecha_hora_salida ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('Y-m-d') : '';
                                                @endphp
                                                <input type="date" name="fecha_salida" id="fecha_salida{{ $reserva->id }}" class="form-control" value="{{ $fecha }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="hora_salida{{ $reserva->id }}" class="form-label">
                                                    <i class="fas fa-clock me-2 text-primary"></i>Hora
                                                </label>
                                                @php
                                                    $hora = $reserva->viaje->fecha_hora_salida ? \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('H:i') : '';
                                                @endphp
                                                <input type="time" name="hora_salida" id="hora_salida{{ $reserva->id }}" class="form-control" value="{{ $hora }}" required>
                                            </div>
                                        </div>

                                        {{-- Asiento --}}
                                        <div class="mb-3">
                                            <label for="asiento_id{{ $reserva->id }}" class="form-label">
                                                <i class="fas fa-chair me-2 text-primary"></i>Asiento
                                            </label>
                                            <select name="asiento_id" id="asiento_id{{ $reserva->id }}" class="form-select">
                                                @foreach($asientos as $asiento)
                                                    <option value="{{ $asiento->id }}" {{ $reserva->asiento_id == $asiento->id ? 'selected' : '' }}>
                                                        {{ $asiento->numero_asiento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Botón Guardar Cambios Centrado --}}
                                    <div class="modal-footer d-flex justify-content-center"> {{-- CAMBIO AQUÍ: justify-content-center --}}
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-1"></i>Guardar Cambios
                                        </button>
                                    </div>
                                </form>
                                {{-- Botón Cerrar fuera del formulario --}}
                                <div class="p-3 text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>No tienes reservas registradas aún.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- MODAL DESCARGA PDF --}}
    <div class="modal fade" id="modalDescargaPDF" tabindex="-1" aria-labelledby="modalDescargaPDFLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalDescargaPDFLabel">
                        <i class="fas fa-shield-alt me-2"></i>Descarga Segura de Itinerario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-check-circle fa-2x me-3"></i>
                        <div>
                            <h6 class="alert-heading mb-1">✓ Documento Seguro</h6>
                            <small>Este PDF es generado de forma segura por BUSTRAK y contiene tu información de viaje protegida.</small>
                        </div>
                    </div>
                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body">
                            <h6 class="card-title text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>El PDF incluye:
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Tu información personal</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Detalles completos de tus reservas</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Códigos QR para abordar</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Información de contacto de soporte</li>
                            </ul>
                        </div>
                    </div>
                    <div class="alert alert-warning d-flex align-items-start mb-0" role="alert">
                        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                        <div>
                            <small><strong>Nota de privacidad:</strong> Este documento contiene información personal. Guárdalo en un lugar seguro y no lo compartas con terceros no autorizados.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <a href="{{ route('itinerario.pdf') }}" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Confirmar y Descargar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL COMPARTIR ITINERARIO --}}
    <div class="modal fade" id="modalCompartir" tabindex="-1" aria-labelledby="modalCompartirLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalCompartirLabel">
                        <i class="fas fa-share-alt me-2"></i>Compartir Itinerario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="text-muted">Selecciona cómo deseas compartir el enlace:</p>
                    <div class="d-grid gap-2 mb-3">
                        <a id="btnCompartirWhatsapp" href="#" target="_blank" class="btn btn-success btn-lg">
                            <i class="fab fa-whatsapp me-2"></i> Por WhatsApp
                        </a>
                        <a id="btnCompartirEmail" href="#" class="btn btn-danger btn-lg">
                            <i class="fas fa-envelope me-2"></i> Por Correo
                        </a>
                        <a id="btnCompartirFacebook" href="#" target="_blank" class="btn btn-primary btn-lg">
                            <i class="fab fa-facebook me-2"></i> Por Facebook
                        </a>
                        <a id="btnCompartirMessenger" href="#" target="_blank" class="btn btn-info btn-lg text-white" style="background-color: #0078FF; border-color: #0078FF;">
                            <i class="fab fa-facebook-messenger me-2"></i> Por Messenger
                        </a>
                    </div>
                    <div class="input-group mt-4">
                        <input type="text" id="enlaceCompartir" class="form-control" readonly placeholder="Enlace de la reserva">
                        <button class="btn btn-outline-secondary" type="button" id="btnCopiarEnlace">
                            <i class="fas fa-copy"></i> Copiar
                        </button>
                    </div>
                    <small class="text-success visually-hidden" id="mensajeCopiado">¡Enlace copiado al portapapeles!</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT COMPARTIR --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalCompartir = document.getElementById('modalCompartir');
            modalCompartir.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const reservaId = button.getAttribute('data-reserva-id');
                const baseUrl = '{{ url('/') }}';
                const rutaCompartir = `${baseUrl}/itinerario/compartir/${reservaId}`;
                const codigoReservaElement = button.closest('.shadow-sm').querySelector('.badge.bg-info');
                const codigoReserva = codigoReservaElement ? codigoReservaElement.textContent : 'N/A';
                const mensaje = encodeURIComponent(`¡Revisa mi itinerario de viaje en BUSTRAK! Código: ${codigoReserva}. Enlace: `);
                const urlCodificada = encodeURIComponent(rutaCompartir);

                document.getElementById('enlaceCompartir').value = rutaCompartir;
                document.getElementById('btnCompartirWhatsapp').href = `https://wa.me/?text=${mensaje}${urlCodificada}`;
                document.getElementById('btnCompartirEmail').href = `mailto:?subject=Mi Itinerario de Viaje BUSTRAK&body=${mensaje}${rutaCompartir}`;
                document.getElementById('btnCompartirFacebook').href = `https://www.facebook.com/sharer/sharer.php?u=${urlCodificada}&quote=${mensaje}`;
                document.getElementById('btnCompartirMessenger').href = `https://www.facebook.com/dialog/send?link=${urlCodificada}&app_id=YOUR_APP_ID&redirect_uri=${urlCodificada}`;
            });

            document.getElementById('btnCopiarEnlace').addEventListener('click', function() {
                const enlaceInput = document.getElementById('enlaceCompartir');
                const mensajeCopiado = document.getElementById('mensajeCopiado');
                enlaceInput.select();
                enlaceInput.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(enlaceInput.value).then(() => {
                    mensajeCopiado.classList.remove('visually-hidden');
                    setTimeout(() => mensajeCopiado.classList.add('visually-hidden'), 2000);
                }).catch(err => alert('Error al copiar. Por favor, cópielo manualmente.'));
            });
        });
    </script>

    <style>
        .modal-content { border-radius: 15px; overflow: hidden; }
        .modal-header { border-bottom: none; padding: 1.5rem; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { border-top: none; padding: 1rem 1.5rem; }
        .alert { border-radius: 10px; }
        .card { border-radius: 10px; }
        .modal.fade .modal-dialog { transform: scale(0.8); opacity: 0; transition: all 0.3s; }
        .modal.show .modal-dialog { transform: scale(1); opacity: 1; }
    </style>
@endsection
