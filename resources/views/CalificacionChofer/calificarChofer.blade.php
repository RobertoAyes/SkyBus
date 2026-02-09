@extends('layouts.layoutuser')

@section('title', 'Calificar Chofer')

@section('contenido')
    <div class="container-fluid py-5 px-0">

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success text-center fw-bold shadow-sm" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Banner de aviso general -->
        <div id="alert-required" class="alert alert-danger text-center fw-bold shadow-sm d-none">
            Por favor, completa todos los campos obligatorios antes de enviar.
        </div>

        <!-- Card ajustada al ancho del content-area -->
        <div class="card shadow-sm mx-auto w-100"
             style="border-radius: 8px; background-color: #ffffff; border: 1px solid #e3e6f0;">
            <div class="card-header text-center py-3" style="background-color: #0d6efd; color: #fff; font-size: 1.4rem; font-weight: 600;">
                Califica al Conductor
            </div>

            <div class="card-body p-4">
                <p class="text-center text-muted mb-4">Tu opinión nos ayuda a mejorar la experiencia de viaje.</p>

                <form input type="hidden" name="chofer_id" value="{{ $chofer->id }}">
                >
                    @csrf

                    <div class="text-center mb-4">
                        <div class="rating-stars">
                            @for($i=5; $i>=1; $i--)
                                <input type="radio" name="calificacion" id="star{{$i}}" value="{{$i}}">
                                <label for="star{{$i}}" title="{{$i}} estrellas">★</label>
                            @endfor
                        </div>
                    </div>

                    @php
                        $fieldStyle = 'width: 100%; border: 1px solid #d1d3e2; border-radius: 4px; transition: all 0.3s;';
                    @endphp

                    @php
                        $textFields = [
                            ['label' => 'Comentario general', 'name' => 'comentario', 'placeholder' => 'Escribe tu opinión general...'],
                            ['label' => '¿Qué debería mejorar el conductor?', 'name' => 'mejoras', 'placeholder' => 'Sugerencias concretas...'],
                            ['label' => '¿Qué te gustó más del viaje?', 'name' => 'positivo', 'placeholder' => 'Aspectos positivos...'],
                            ['label' => '¿Viste comportamientos no adecuados por parte del conductor?', 'name' => 'comportamientos', 'placeholder' => 'Describe si notaste algo...'],
                        ];
                    @endphp

                    @foreach($textFields as $field)
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ $field['label'] }}</label>
                            <textarea name="{{ $field['name'] }}" class="form-control form-control-uniform required-field" rows="2" placeholder="{{ $field['placeholder'] }}" style="{{ $fieldStyle }}">{{ old($field['name']) }}</textarea>
                            <small class="text-danger d-none">Este campo es obligatorio</small>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label fw-bold">¿Crees que el conductor rebasaba los límites de velocidad?</label>
                        <select name="velocidad" class="form-select form-control-uniform required-field" style="{{ $fieldStyle }}">
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="si" {{ old('velocidad')=='si' ? 'selected' : '' }}>Sí</option>
                            <option value="no" {{ old('velocidad')=='no' ? 'selected' : '' }}>No</option>
                        </select>
                        <small class="text-danger d-none">Este campo es obligatorio</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">¿Te sentiste protegido durante el viaje?</label>
                        <select name="seguridad" class="form-select form-control-uniform required-field" style="{{ $fieldStyle }}">
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="si" {{ old('seguridad')=='si' ? 'selected' : '' }}>Sí</option>
                            <option value="no" {{ old('seguridad')=='no' ? 'selected' : '' }}>No</option>
                        </select>
                        <small class="text-danger d-none">Este campo es obligatorio</small>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-gradient fw-bold px-5 py-2 shadow-sm">
                            Enviar Calificación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .rating-stars {
            display: flex;
            justify-content: center;
            flex-direction: row-reverse;
            gap: 8px;
        }
        .rating-stars input { display: none; }
        .rating-stars label {
            font-size: 2.8rem;
            color: #ccc;
            cursor: pointer;
            transition: transform 0.2s, color 0.2s;
        }
        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label { color: #ffc107; transform: scale(1.2); }

        .btn-gradient {
            background: linear-gradient(90deg, #0d6efd, #3b82f6);
            color: #fff;
            border: none;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover { background: linear-gradient(90deg, #3b82f6, #0d6efd); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }

        textarea:focus, select:focus {
            outline: none;
            box-shadow: 0 0 6px rgba(13, 110, 253, 0.4);
            border-color: #0d6efd;
        }

        .form-control-uniform { width: 100%; }

        .alert-success, .alert-danger { font-size: 1rem; transition: all 0.3s ease; }
    </style>

    <script>
        // Validación de campos obligatorios
        const form = document.getElementById('formCalificacion');
        form.addEventListener('submit', function(e){
            let valid = true;
            const fields = form.querySelectorAll('.required-field');
            fields.forEach(field => {
                const error = field.nextElementSibling;
                if(!field.value){
                    valid = false;
                    field.style.borderColor = '#dc3545';
                    error.classList.remove('d-none');
                } else {
                    field.style.borderColor = '#d1d3e2';
                    error.classList.add('d-none');
                }
            });
            if(!valid){
                e.preventDefault();
                document.getElementById('alert-required').classList.remove('d-none');
                setTimeout(() => {
                    document.getElementById('alert-required').classList.add('d-none');
                }, 4000);
            }
        });

        // Desaparecer alert de éxito automáticamente
        const successAlert = document.getElementById('success-alert');
        if(successAlert){
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 4000);
        }
    </script>
@endsection
