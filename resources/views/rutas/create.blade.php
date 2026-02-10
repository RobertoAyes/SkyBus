@extends('layouts.layoutadmin')

@section('title', 'Registrar Ruta')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:1.8rem;">
                    <i class="fas fa-road me-2"></i>Registrar Ruta
                </h2>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('rutas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="origen" class="form-label"><i class="fas fa-location-arrow me-1"></i>Origen</label>
                        <input type="text" name="origen" id="origen" class="form-control"
                               value="{{ old('origen') }}"
                               onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                               required>
                        @error('origen')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="destino" class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Destino</label>
                        <input type="text" name="destino" id="destino" class="form-control"
                               value="{{ old('destino') }}"
                               onkeypress="return /[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(String.fromCharCode(event.keyCode || event.which))"
                               required>
                        @error('destino')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="distancia" class="form-label"><i class="fas fa-road me-1"></i>Distancia (km)</label>
                        <input type="number" step="0.01" name="distancia" id="distancia" class="form-control" value="{{ old('distancia') }}" required>
                        @error('distancia')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="duracion_estimada" class="form-label"><i class="fas fa-clock me-1"></i>Duración estimada (minutos)</label>
                        <input type="number" name="duracion_estimada" id="duracion_estimada" class="form-control" value="{{ old('duracion_estimada') }}" required>
                        @error('duracion_estimada')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('rutas.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Guardar Ruta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

