@extends('layouts.layoutuser')
@section('contenido')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Agregar servicios adicionales</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('servicios_reserva.store') }}" method="POST">
                @csrf
                <div class="alert alert-warning" role="alert">
                    ¡Atención! Solo podrás seleccionar servicios adicionales si tienes una reserva de viaje activa.
                    Si no tienes una reserva vigente, no podrás utilizar esta pantalla.
                </div>
                <div class="col-4 mb-3">
                    <label class="form-label">Seleccione código de reserva del viaje</label>
                    <select name="reserva_id" class="form-select @error('reserva_id') is-invalid @enderror" id="reserva_id">
                        <option value="">-- Seleccione --</option>
                        @foreach($reservas as $reserva)
                            @if(!$reserva->servicios_extras)
                                <option value="{{ $reserva->id }}" {{ old('reserva_id') == $reserva->id ? 'selected' : '' }}>
                                    {{ $reserva->codigo_reserva }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('reserva_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <div class="row g-3">
                    @forelse($extras as $extra)
                        <div class="col-md-4">
                            <div class="card h-100 text-center">
                                <img src="{{ asset('storage/' . $extra->imagen) }}" class="card-img-top p-3 img-fluid" alt="{{ $extra->nombre }}" style="max-height:150px; object-fit:contain;">
                                <div class="card-body d-flex flex-column align-items-center py-2"
                                     style="background-color: #d5d5d5; border-top: 1px solid #b5b0b0">
                                    <h5 class="card-title mb-1">{{ $extra->nombre }}</h5>
                                    <p class="mb-2 text-center">{{ $extra->descripcion }}</p>
                                    <div class="form-check form-switch w-50 d-flex justify-content-center">
                                        <input class="form-check-input servicio-checkbox w-100" type="checkbox" name="extras_seleccionados[]" value="{{ $extra->id }}" id="extra{{ $extra->id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                            No hay servicios adicionales disponibles.
                        </div>
                    @endforelse
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="button" id="btn-guardar" class="btn btn-primary" style="display:none;" data-bs-toggle="modal" data-bs-target="#confirmModal">Guardar selección</button>
                    <a href="{{ route('servicios_reserva.index') }}" class="btn btn-secondary">Regresar</a>
                </div>

                <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                ¿Está seguro de agregar estos servicios adicionales a su reserva de viaje?
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-primary btn-sm">Sí, agregar</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnGuardar = document.getElementById('btn-guardar');
            const reserva = document.getElementById('reserva_id');
            const checkboxes = document.querySelectorAll('.servicio-checkbox');

            function mostrarBoton() {
                const reservaSeleccionada = reserva.value !== "";
                const alMenosUnoSeleccionado = Array.from(checkboxes).some(cb => cb.checked);

                if (reservaSeleccionada && alMenosUnoSeleccionado) {
                    btnGuardar.style.display = 'block';
                } else {
                    btnGuardar.style.display = 'none';
                }
            }

            reserva.addEventListener('change', mostrarBoton);
            checkboxes.forEach(cb => cb.addEventListener('change', mostrarBoton));
        });
    </script>
@endsection
