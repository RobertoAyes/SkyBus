@extends('layouts.layoutuser')

@section('contenido')
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4>Reserva Confirmada</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-success">
                Su reserva ha sido guardada exitosamente.
            </div>
            <div class="alert alert-warning">
                Si no llega antes de la hora establecida, su boleto será cancelado.
            </div>
            <p>Detalles del Viaje:</p>
            <ul>
                <li>Origen: {{ $reserva->viaje->origen->nombre }}</li>
                <li>Destino: {{ $reserva->viaje->destino->nombre }}</li>
                <li>Hora Salida: {{ $reserva->viaje->fecha_hora_salida }}</li>
                <li>Asiento: #{{ $reserva->asiento->numero_asiento }}</li>
                <li>Código Reserva: {{ $reserva->codigo_reserva }}</li>
            </ul>
            {!! $qrCode !!}
        </div>
    </div>

    <!-- Modal para QR (se muestra automáticamente via JS si quieres, o solo en página) -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Código QR de Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! $qrCode !!}
                    <p>Detalles: {{ $reserva->codigo_reserva }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar modal automáticamente
        var myModal = new bootstrap.Modal(document.getElementById('qrModal'));
        myModal.show();
    </script>
@endsection
