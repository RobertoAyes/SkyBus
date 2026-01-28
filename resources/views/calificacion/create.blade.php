@extends('layouts.layoutuser')

@section('contenido')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
            gap: 0.3rem;
            font-size: 2rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            color: #dee2e6;
            transition: all 0.3s ease;
            margin: 0;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffc107;
            transform: scale(1.1);
        }
    </style>
    <div class="container mt-4">
        <h2 class="mb-3" style="color:#1e63b8;">
            Cuéntanos tu experiencia
        </h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('calificacion.store', $reserva->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <div class="star-rating">
                            <input type="radio" id="star5" name="estrellas" value="5" {{ old('estrellas') == 5 ? 'checked' : '' }} required />
                            <label for="star5" title="5 estrellas"><i class="bi bi-star-fill"></i></label>


                            <input type="radio" id="star4" name="estrellas" value="4" {{ old('estrellas') == 4 ? 'checked' : '' }} />
                            <label for="star4" title="4 estrellas"><i class="bi bi-star-fill"></i></label>

                            <input type="radio" id="star3" name="estrellas" value="3" {{ old('estrellas') == 3 ? 'checked' : '' }} />
                            <label for="star3" title="3 estrellas"><i class="bi bi-star-fill"></i></label>

                            <input type="radio" id="star2" name="estrellas" value="2" {{ old('estrellas') == 2 ? 'checked' : '' }} />
                            <label for="star2" title="2 estrellas"><i class="bi bi-star-fill"></i></label>

                            <input type="radio" id="star1" name="estrellas" value="1" {{ old('estrellas') == 1 ? 'checked' : '' }} />
                            <label for="star1" title="1 estrella"><i class="bi bi-star-fill"></i></label>
                        </div>
                        @error('estrellas')
                        <small class="text-danger d-block text-center mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="comentario" class="form-label">Comentario</label>
                        <textarea name="comentario" id="comentario" class="form-control" rows="4">{{ old('comentario') }}</textarea>
                        @error('comentario')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar calificación</button>
                </form>
            </div>
        </div>
    </div>
@endsection
