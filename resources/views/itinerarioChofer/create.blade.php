@extends('layouts.layoutadmin')

@section('title', 'Asignar Itinerario')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:1.8rem;">
                    <i class="fas fa-calendar-alt me-2"></i>Asignar Itinerario a Chofer
                </h2>
            </div>
            <div class="card-body">
                <form action="{{ route('itinerarioChofer.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="chofer_id" class="form-label">Chofer</label>
                        <select name="chofer_id" id="chofer_id" class="form-select" required>
                            <option value="">Seleccione un chofer</option>
                            @foreach($choferes as $chofer)
                                <option value="{{ $chofer->id }}">{{ $chofer->name }}</option>
                            @endforeach
                        </select>
                        @error('chofer_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ruta_id" class="form-label">Ruta</label>
                        <select name="ruta_id" id="ruta_id" class="form-select" required>
                            <option value="">Seleccione una ruta</option>
                            @foreach($rutas as $ruta)
                                <option value="{{ $ruta->id }}">{{ $ruta->origen }} - {{ $ruta->destino }}</option>
                            @endforeach
                        </select>
                        @error('ruta_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha y Hora (Opcional)</label>
                        <input type="datetime-local" name="fecha" id="fecha" class="form-control"
                               value="{{ old('fecha') ? \Carbon\Carbon::parse(old('fecha'))->format('Y-m-d\TH:i') : '' }}">
                        @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('itinerarioChofer.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Asignar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
