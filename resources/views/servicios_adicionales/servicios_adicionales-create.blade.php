@extends('layouts.layoutuser')

@section('contenido')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Agregar Servicio Adicional</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('servicios_adicionales.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" maxlength="25">
                    @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" rows="3" maxlength="75" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*">
                    @error('imagen')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 text-center">
                    <img id="vista_previa" src="#" alt="Vista previa"
                         style="display:none; max-height:200px; object-fit:contain; border:1px solid #ddd; padding:5px;">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('servicios_adicionales.index') }}" class="btn btn-secondary">Regresar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('imagen').addEventListener('change', function(evento) {
            const imagenVista = document.getElementById('vista_previa');
            const archivoSeleccionado = evento.target.files[0];

            if (archivoSeleccionado) {
                const lector = new FileReader();

                lector.onload = function(e) {
                    imagenVista.src = e.target.result;
                    imagenVista.style.display = 'block';
                }

                lector.readAsDataURL(archivoSeleccionado);
            } else {
                imagenVista.style.display = 'none';
            }
        });
    </script>
@endsection
