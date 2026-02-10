@extends('layouts.layoutuser')
@section('title', 'Calificar Chofer')
@section('contenido')
    <style>
        /* Estrellas mejoradas con efecto de brillo */
        .rating-css input {
            display: none;
        }
        .rating-css input + label {
            font-size: 36px;
            cursor: pointer;
            color: #e5e7eb;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.08));
            position: relative;
        }
        .rating-css {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 16px;
            padding: 24px 0;
        }
        .rating-css input + label:hover,
        .rating-css input + label:hover ~ label {
            color: #fbbf24;
            transform: translateY(-3px) scale(1.1);
            filter: drop-shadow(0 4px 12px rgba(251, 191, 36, 0.4));
        }
        .rating-css input:checked + label,
        .rating-css input:checked + label ~ label {
            color: #fbbf24;
            animation: starPulse 0.4s ease-out;
        }
        @keyframes starPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        /* Inputs con mejor diseño */
        .form-select, .form-control {
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }
        .form-select:focus, .form-control:focus {
            border-color: #3b82f6;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        /* Header con degradado dinámico */
        .card-header-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            border: none;
            position: relative;
            overflow: hidden;
        }
        .card-header-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        /* Botón con efecto de onda */
        .btn-submit-elegant {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-submit-elegant::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .btn-submit-elegant:hover::before {
            width: 300px;
            height: 300px;
        }
        .btn-submit-elegant:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.4);
        }
        .btn-submit-elegant:active {
            transform: translateY(-1px);
        }

        /* Card con sombra flotante */
        .card-main {
            animation: fadeInUp 0.7s ease-out;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: box-shadow 0.3s ease;
        }
        .card-main:hover {
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Iconos animados */
        .icon-bounce {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* Mensaje de éxito mejorado */
        .alert-success-custom {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid #10b981;
            animation: slideInDown 0.5s ease-out;
        }
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Etiquetas con mejor tipografía */
        .label-modern {
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Decoración de fondo */
        .bg-decoration {
            background-image:
                radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
        }

        /* Textarea con contador */
        .form-control:focus::placeholder {
            opacity: 0.4;
        }
    </style>

    <div class="text-center mb-5">
        <!-- Contenedor de la estrella y el título en la misma línea -->
        <div class="d-inline-flex align-items-center gap-2 mb-3">
            <i class="fas fa-star text-warning" style="font-size: 2.5rem;"></i>
            <h1 class="fw-bold mb-0" style="font-size: 2.25rem; color: #1e293b; letter-spacing: -1px;">
                Tu opinión nos importa
            </h1>
        </div>

        <p class="text-muted mb-0" style="font-size: 1.1rem; font-weight: 400; max-width: 600px; margin: 0 auto;">
            Comparte tu experiencia y ayúdanos a mejorar cada día.
            <p> Tu feedback es fundamental para nosotros.</p>
        </p>
    </div>


    <!-- Card principal -->
        <div class="card card-main border-0 mx-auto" style="max-width: 900px;">

            <!-- Header elegante -->
            <div class="card-header-gradient text-white text-center" style="padding: 1.5rem;">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.95rem; letter-spacing: 2px; text-transform: uppercase; position: relative; z-index: 1;">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Evaluación de Servicio
                </h6>
            </div>

            <!-- Body espacioso -->
            <div class="card-body p-5" style="background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);">
                @if(session('success'))
                    <div class="alert alert-success-custom d-flex align-items-center border-0 mb-4" style="border-radius: 12px; padding: 1.25rem;">
                        <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: #10b981;"></i>
                        <div style="font-weight: 600; color: #065f46;">{{ session('success') }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('calificar.chofer.guardar') }}">
                    @csrf

                    <!-- Selección de conductor -->
                    <div class="mb-5">
                        <label class="label-modern">
                            <i class="fas fa-id-card text-primary"></i>
                            Conductor
                        </label>

                        <div class="d-flex align-items-center" style="border: 2px solid #e5e7eb; border-radius: 12px; overflow: hidden; max-width: 100%;">
                            <!-- Icono dentro del mismo borde -->
                            <div style="padding: 0 12px; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-right: 2px solid #e5e7eb;">
                                <i class="fas fa-steering-wheel text-primary"></i>
                            </div>

                            <!-- Select moderno -->
                            <select name="chofer_id" class="form-select border-0" required style="padding: 1rem 1.25rem; font-size: 1rem; flex: 1; border-radius: 0;">
                                <option value="" disabled selected>¿Quién condujo tu viaje hoy?</option>
                                @foreach($choferes as $chofer)
                                    <option value="{{ $chofer->id }}">{{ $chofer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Calificación con estrellas -->
                    <div class="mb-5" style="background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <label class="label-modern justify-content-center">
                            <i class="fas fa-star text-warning"></i>
                            ¿Cómo calificarías tu experiencia?
                        </label>
                        <div class="rating-css">
                            <input type="radio" id="rating5" name="estrellas" value="5" required>
                            <label for="rating5" title="Excelente"><i class="fas fa-star"></i></label>
                            <input type="radio" id="rating4" name="estrellas" value="4">
                            <label for="rating4" title="Muy bueno"><i class="fas fa-star"></i></label>
                            <input type="radio" id="rating3" name="estrellas" value="3">
                            <label for="rating3" title="Bueno"><i class="fas fa-star"></i></label>
                            <input type="radio" id="rating2" name="estrellas" value="2">
                            <label for="rating2" title="Regular"><i class="fas fa-star"></i></label>
                            <input type="radio" id="rating1" name="estrellas" value="1">
                            <label for="rating1" title="Necesita mejorar"><i class="fas fa-star"></i></label>
                        </div>
                        <p class="text-center text-muted mb-0" style="font-size: 0.9rem; font-weight: 400;">
                            Haz clic en las estrellas para calificar tu experiencia
                        </p>
                    </div>

                    <!-- Comentario opcional -->
                    <div class="mb-5">
                        <label class="label-modern">
                            <i class="fas fa-comment-dots text-success"></i>
                            Cuéntanos más
                            <span class="text-muted fw-normal ms-2" style="font-size: 0.8rem; text-transform: none;">(Opcional)</span>
                        </label>
                        <textarea
                            name="comentario"
                            rows="5"
                            class="form-control"
                            placeholder=" Comparte los detalles de tu viaje: ¿El vehículo estaba limpio? ¿El conductor fue puntual y amable? ¿Conducción segura? ¿Algo que destacar o mejorar?"
                            style="resize: none; padding: 1.25rem; font-size: 1rem; border-radius: 12px; line-height: 1.7; border-width: 2px;"></textarea>
                        <small class="text-muted" style="font-size: 0.85rem; display: block; margin-top: 0.5rem;">
                            <i class="fas fa-info-circle me-1"></i>
                            Tu feedback nos ayuda a mejorar el servicio para todos
                        </small>
                    </div>

                    <!-- Botón de envío -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-submit-elegant text-white py-3" style="font-size: 1.1rem; font-weight: 600; letter-spacing: 0.5px; border-radius: 12px; position: relative;">
                            <span style="position: relative; z-index: 1;">
                                <i class="fas fa-paper-plane me-2"></i>
                                Enviar Evaluación
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Mensaje de confianza -->
                <div class="text-center mt-4 pt-3" style="border-top: 1px solid #e5e7eb;">
                    <small class="text-muted" style="font-size: 0.85rem;">
                        <i class="fas fa-lock me-1"></i>
                        Tus datos están protegidos y tu evaluación es confidencial
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
