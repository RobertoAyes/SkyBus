@extends('layouts.layoutadmin')

@section('title', 'Agregar Servicio')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600;">
                    <i class="fas fa-concierge-bell me-2"></i>Agregar Servicio Adicional
                </h2>
            </div>

            <div class="card-body">

                {{-- FORMULARIO --}}
                <form action="{{ route('servicios_adicionales.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        {{-- NOMBRE --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre</label>
                            <input type="text"
                                   name="nombre"
                                   maxlength="25"
                                   value="{{ old('nombre') }}"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   placeholder="Ej: snacks">

                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- IMAGEN --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Imagen</label>
                            <input type="file"
                                   name="imagen"
                                   id="imagen"
                                   accept="image/*"
                                   class="form-control @error('imagen') is-invalid @enderror">

                            @error('imagen')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DESCRIPCIÓN --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="descripcion"
                                      rows="3"
                                      maxlength="75"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      placeholder="Describa el servicio...">{{ old('descripcion') }}</textarea>

                            @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- VISTA PREVIA --}}
                        <div class="col-12 text-center">
                            <img id="vista_previa"
                                 src="#"
                                 alt="Vista previa"
                                 class="rounded"
                                 style="display:none; max-height:200px; object-fit:contain; border:1px solid #ddd; padding:5px;">
                        </div>

                        {{-- BOTONES --}}
                        <div class="col-12 d-flex gap-2 justify-content-end mt-3">
                            <a href="{{ route('servicios_adicionales.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar
                            </button>
                        </div>

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
