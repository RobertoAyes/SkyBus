@extends('layouts.layoutadmin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Crear servicios disponibles de terminal</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('servicios.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Seleccione la terminal</label>
                        <select name="terminal_id" class="form-select @error('terminal_id') is-invalid @enderror">
                            <option value="">-- Seleccione --</option>
                            @foreach($terminales as $terminal)
                                <option value="{{ $terminal->id }}"
                                    {{ old('terminal_id') == $terminal->id ? 'selected' : '' }}>
                                    {{ $terminal->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('terminal_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nombre del servicio</label>
                        <input type="text" name="nombre"
                               class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre') }}" maxlength="25">
                        @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 col-md-8">
                    <label class="form-label">Descripción del servicio</label>
                    <textarea name="descripcion" maxlength="200" rows="3"
                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('terminales.index') }}" class="btn btn-secondary">Regresar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
