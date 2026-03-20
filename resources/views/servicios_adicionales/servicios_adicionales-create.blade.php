@extends('layouts.layoutadmin')

@section('title', 'Agregar Servicio Adicional')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:1.8rem;">
                    <i class="fas fa-concierge-bell me-2"></i>Agregar Servicio Adicional
                </h2>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('servicios_adicionales.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- NOMBRE --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label"><i class="fas fa-tag me-1"></i>Nombre</label>
                        <input type="text" name="nombre" id="nombre" maxlength="25"
                               class="form-control" value="{{ old('nombre') }}" required>
                        @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- IMAGEN --}}
                    <div class="mb-3">
                        <label for="imagen" class="form-label"><i class="fas fa-image me-1"></i>Imagen</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*" class="form-control">
                        @error('imagen')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="mb-3">
                        <label for="descripcion" class="form-label"><i class="fas fa-align-left me-1"></i>Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" maxlength="75"
                                  class="form-control" placeholder="Describa el servicio..." required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- VISTA PREVIA --}}
                    <div class="mb-3 text-center">
                        <img id="vista_previa" src="#" alt="Vista previa"
                             class="rounded" style="display:none; max-height:200px; object-fit:contain; border:1px solid #ddd; padding:5px;">
                    </div>

                    {{-- BOTONES --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('servicios_adicionales.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Guardar Servicio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT VISTA PREVIA --}}
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
