@extends('layouts.layoutuser')
@section('contenido')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Agregar servicios adicionales</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('servicios_adicionales.store') }}" method="POST">
                @csrf
                <div class="alert alert-warning" role="alert">
                    ¡Atención! Solo podrás seleccionar servicios adicionales si tienes una reserva de viaje activa. Si no tienes una reserva vigente, no podrás utilizar esta pantalla.
                </div>
                <div class="col-4 mb-3">
                    <label class="form-label">Seleccione código de reserva del viaje</label>
                    <select name="reserva_id" class="form-select @error('reserva_id') is-invalid @enderror">
                        <option value="">-- Seleccione --</option>
                        @foreach($reservas as $reserva)
                            @if(!$reserva->extras)
                                <option value="{{ $reserva->id }}" {{ (old('reserva_id') == $reserva->id) ? 'selected' : '' }}>
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
                    <div class="col-md-4">
                        <div class="card h-100 text-center">
                            <img src="{{ asset('imagenes/extras/manta.jpg') }}" class="card-img-top p-3" alt="Manta" style="height:150px; object-fit:contain;">
                            <div class="card-body d-flex flex-column align-items-center py-2" style="background-color: #d5d5d5; border-top: 1px solid #b5b0b0">
                                <h5 class="card-title mb-1">Manta</h5>
                                <div class="form-check form-switch w-50 d-flex justify-content-center">
                                    <input class="form-check-input w-100" type="checkbox" name="manta" id="manta">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center">
                            <img src="{{ asset('imagenes/extras/orejeras.jpg') }}" class="card-img-top p-3" alt="Orejeras" style="height:150px; object-fit:contain;">
                            <div class="card-body d-flex flex-column align-items-center py-2" style="background-color: #d5d5d5; border-top: 1px solid #b5b0b0">
                                <h5 class="card-title mb-1">Orejeras</h5>
                                <div class="form-check form-switch w-50 d-flex justify-content-center">
                                    <input class="form-check-input w-100" type="checkbox" name="orejeras" id="orejeras">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center">
                            <img src="{{ asset('imagenes/extras/almohada.jpg') }}" class="card-img-top p-3" alt="Almohada" style="height:150px; object-fit:contain;">
                            <div class="card-body d-flex flex-column align-items-center py-2" style="background-color: #d5d5d5; border-top: 1px solid #b5b0b0">
                                <h5 class="card-title mb-1">Almohada</h5>
                                <div class="form-check form-switch w-50 d-flex justify-content-center">
                                    <input class="form-check-input w-100" type="checkbox" name="almohada" id="almohada">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center">
                            <img src="{{ asset('imagenes/extras/snack.jpg') }}" class="card-img-top p-3" alt="Snack" style="height:150px; object-fit:contain;">
                            <div class="card-body d-flex flex-column align-items-center py-2" style="background-color: #d5d5d5; border-top: 1px solid #b5b0b0">
                                <h5 class="card-title mb-1">Snack</h5>
                                <div class="form-check form-switch w-50 d-flex justify-content-center">
                                    <input class="form-check-input w-100" type="checkbox" name="snack" id="snack">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center">
                            <img src="{{ asset('imagenes/extras/fresco.jpg') }}" class="card-img-top p-3" alt="Refrescos" style="height:150px; object-fit:contain;">
                            <div class="card-body d-flex flex-column align-items-center py-2" style="background-color: #d5d5d5; border-top: 1px solid #b5b0b0">
                                <h5 class="card-title mb-1">Refrescos</h5>
                                <div class="form-check form-switch w-50 d-flex justify-content-center">
                                    <input class="form-check-input w-100" type="checkbox" name="refrescos" id="refrescos">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center">
                            <img src="{{ asset('imagenes/extras/cafe.jpg') }}" class="card-img-top p-3" alt="Cafe" style="height:150px; object-fit:contain;">
                            <div class="card-body d-flex flex-column align-items-center py-2" style="background-color: #d5d5d5; border-top: 1px solid #b5b0b0">
                                <h5 class="card-title mb-1">Café</h5>
                                <div class="form-check form-switch w-50 d-flex justify-content-center">
                                    <input class="form-check-input w-100" type="checkbox" name="cafe" id="cafe">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="button" id="btn-guardar" class="btn btn-primary" style="display:none;" data-bs-toggle="modal" data-bs-target="#confirmModal">
                        Guardar
                    </button>
                    <a href="{{ route('servicios_adicionales.index') }}" class="btn btn-secondary">Regresar</a>
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
            const reserva = document.querySelector('select[name="reserva_id"]');

            const manta = document.getElementById('manta');
            const orejeras = document.getElementById('orejeras');
            const almohada = document.getElementById('almohada');
            const snack = document.getElementById('snack');
            const refrescos = document.getElementById('refrescos');
            const cafe = document.getElementById('cafe');

            function mostrarBoton() {
                if (
                    reserva.value !== "" &&
                    (manta.checked || orejeras.checked || almohada.checked || snack.checked || refrescos.checked || cafe.checked)
                ) {
                    btnGuardar.style.display = 'block';
                } else {
                    btnGuardar.style.display = 'none';
                }
            }

            reserva.addEventListener('change', mostrarBoton);
            manta.addEventListener('change', mostrarBoton);
            orejeras.addEventListener('change', mostrarBoton);
            almohada.addEventListener('change', mostrarBoton);
            snack.addEventListener('change', mostrarBoton);
            refrescos.addEventListener('change', mostrarBoton);
            cafe.addEventListener('change', mostrarBoton);
        });
    </script>
@endsection
