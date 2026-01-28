@extends('layouts.layoutuser')
@section('contenido')
    <div class="card">
        <div class="card-header bg-primary text-white"><h4>Reservar Viaje</h4></div>
        <div class="card-body">
            <form id="buscarForm" action="{{ route('cliente.reserva.buscar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Ciudad de Origen</label>
                    <select name="ciudad_origen_id" id="ciudad_origen_id" class="form-select" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($ciudades as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ciudad de Destino</label>
                    <select name="ciudad_destino_id" id="ciudad_destino_id" class="form-select" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($ciudades as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Buscar Viajes</button>
            </form>
        </div>
    </div>

    {{-- Modal de error --}}
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Error</h5>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('buscarForm').addEventListener('submit', function (e) {
            const origen = document.getElementById('ciudad_origen_id').value;
            const destino = document.getElementById('ciudad_destino_id').value;

            if (origen && destino && origen === destino) {
                e.preventDefault();
                document.getElementById('errorMessage').textContent = 'La ciudad de origen y destino deben ser diferentes.';
                new bootstrap.Modal(document.getElementById('errorModal')).show();
            }
        });
    </script>
@endsection
