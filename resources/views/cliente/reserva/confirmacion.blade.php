@extends('layouts.layoutuser')

@section('title', 'Reserva Confirmada')

@section('contenido')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="card shadow border-0">
                    <!-- Header -->
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0">
                            <i class="fas fa-check-circle fa-lg me-2"></i>
                            ¡Reserva Confirmada!
                        </h4>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">
                        <!-- Mensaje de éxito -->
                        <div class="alert alert-success text-center mb-3 py-2" role="alert">
                            <strong>¡Listo!</strong> Tu reserva ha sido guardada.
                        </div>

                        <!-- Alerta de puntualidad -->
                        <div class="alert alert-warning text-center mb-4 py-2" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Recuerda:</strong> Llega antes de la hora de salida.
                        </div>

                        <!-- Detalles compactos -->
                        <div class="row g-3 mb-4 text-center">
                            <div class="col-12">
                                <small class="text-muted d-block">Código de Reserva</small>
                                <h5 class="fw-bold text-primary">{{ $reserva->codigo_reserva }}</h5>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Origen</small>
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <span class="fw-semibold">{{ $reserva->viaje->origen->nombre }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Destino</small>
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-map-marker-check text-success me-2"></i>
                                    <span class="fw-semibold">{{ $reserva->viaje->destino->nombre }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Salida</small>
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-clock text-info me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($reserva->viaje->fecha_hora_salida)->format('d/m H:i') }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Asiento</small>
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-chair text-secondary me-2"></i>
                                    <span class="fw-bold">#{{ $reserva->asiento->numero_asiento }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- QR Code MUY GRANDE -->
                        <div class="text-center mb-4">
                            <div class="bg-white p-3 d-inline-block rounded shadow-sm border">
                                {!! $qrCode !!}
                            </div>
                            <p class="text-muted mt-2 mb-0">
                                <small>Escanea en la terminal</small>
                            </p>
                        </div>

                        <!-- Botones -->
                        <div class="d-grid d-md-flex justify-content-center gap-2">
                            <a href="{{ route('cliente.historial') }}" class="btn btn-primary px-4">
                                <i class="fas fa-history me-1"></i> Historial
                            </a>
                            <a href="{{ route('cliente.reserva.create') }}" class="btn btn-outline-success px-4">
                                <i class="fas fa-plus me-1"></i> Nueva
                            </a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer bg-light text-center py-2">
                        <small class="text-muted">
                            <i class="fas fa-camera me-1"></i>
                            Toma una captura del código QR
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR MÁS GRANDE (350px) -->
    <style>
        .barcode svg {
            width: 350px !important;
            height: 350px !important;
        }
        @media (max-width: 576px) {
            .barcode svg {
                width: 280px !important;
                height: 280px !important;
            }
        }
    </style>
@endsection
