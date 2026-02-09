@extends('layouts.layoutchofer')

@section('title', 'Calificar Chofer')

@section('contenido')
    <div class="container-fluid">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-star me-2"></i> Calificar al Conductor
                </h5>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('calificar.chofer.guardar') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Chofer</label>
                        <select name="chofer_id" class="form-select" required>
                            <option value="">Seleccione un chofer</option>
                            @foreach($choferes as $chofer)
                                <option value="{{ $chofer->id }}">
                                    {{ $chofer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Calificación</label>
                        <div class="d-flex gap-2 fs-4 text-warning">
                            @for($i=1;$i<=5;$i++)
                                <input type="radio" name="estrellas" value="{{ $i }}" required>
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Comentario</label>
                        <textarea name="comentario" rows="3" class="form-control"
                                  placeholder="Describe tu experiencia (opcional)"></textarea>
                    </div>

                    <button class="btn btn-success px-4 rounded-pill">
                        <i class="fas fa-paper-plane me-1"></i> Enviar Calificación
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
