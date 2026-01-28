@extends('layouts.app')

@section('title', 'Compartir Itinerario')

@section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-share-alt me-2"></i>Compartir Itinerario</h3>
            </div>
            <div class="card-body text-center">
                <h5 class="mb-4">Reserva: {{ $reserva->codigo_reserva }}</h5>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Comparte este enlace para que otros puedan ver tu itinerario
                </div>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="urlCompartir" value="{{ $url }}" readonly>
                    <button class="btn btn-primary" onclick="copiarEnlace()">
                        <i class="fas fa-copy me-1"></i>Copiar
                    </button>
                </div>

                <a href="{{ $url }}" class="btn btn-success me-2" target="_blank">
                    <i class="fas fa-file-pdf me-2"></i>Ver PDF
                </a>

                <a href="{{ route('itinerario.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Toast de notificación -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="toastCopiar" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">¡Éxito!</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Enlace copiado al portapapeles correctamente
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
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
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">¡Enlace Copiado!</h5>
                    <p class="text-muted">
                        El enlace ha sido copiado al portapapeles. Ahora puedes compartirlo con quien desees.
                    </p>
                    <div class="alert alert-info d-flex align-items-start" role="alert">
                        <i class="fas fa-info-circle me-2 mt-1"></i>
                        <small class="text-start">
                            Cualquier persona con este enlace podrá ver el itinerario de esta reserva.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        <i class="fas fa-check me-2"></i>Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .toast {
            min-width: 300px;
        }

        .toast-header {
            border-bottom: none;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
        }

        .input-group {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .alert-info {
            border-radius: 10px;
            border-left: 4px solid #0dcaf0;
        }
    </style>

    <script>
        function copiarEnlace() {
            const input = document.getElementById('urlCompartir');
            input.select();
            input.setSelectionRange(0, 99999); // Para móviles

            // Intentar copiar con la API moderna
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(input.value).then(function() {
                    mostrarNotificacion();
                }).catch(function(err) {
                    // Fallback al método antiguo
                    copiarFallback();
                });
            } else {
                copiarFallback();
            }
        }

        function copiarFallback() {
            try {
                document.execCommand('copy');
                mostrarNotificacion();
            } catch (err) {
                console.error('Error al copiar:', err);
            }
        }

        function mostrarNotificacion() {
            // Mostrar el toast
            const toastElement = document.getElementById('toastCopiar');
            const toast = new bootstrap.Toast(toastElement, {
                delay: 3000
            });
            toast.show();

            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modalCompartir'));
            modal.show();
        }
    </script>
@endsection
