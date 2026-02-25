@extends('layouts.layoutchofer')

@section('contenido')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

        :root {
            --bg-base:       #f0f7ff;
            --bg-card:       #ffffff;
            --bg-hover:      #f5faff;
            --bg-header:     #e8f3fd;
            --border:        #d0e8f8;
            --border-accent: #a8d4f0;
            --celeste-1:     #3a9fd6;
            --celeste-2:     #5bb8e8;
            --celeste-light: #e0f3fc;
            --celeste-soft:  #b8dff5;
            --celeste-1:     #3a9fd6;
            --celeste-2:     #5bb8e8;
            --celeste-light: #e0f3fc;
            --celeste-soft:  #b8dff5;
            --text-primary:  #1a3a52;
            --text-secondary:#3a6a8a;
            --text-muted:    #7aaac8;
        }

        .form-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: var(--bg-base);
            padding: 2.5rem 2rem;
        }

        .page-inner {
            max-width: 680px;
            margin: 0 auto;
        }

        /* ── Banner ── */
        .greeting-banner {
            background: linear-gradient(135deg, var(--celeste-1) 0%, var(--celeste-2) 100%);
            border-radius: 20px;
            padding: 2rem 2.2rem;
            margin-bottom: 1.8rem;
            display: flex; align-items: center;
            justify-content: space-between;
            gap: 1.5rem; flex-wrap: wrap;
            box-shadow: 0 8px 28px rgba(224,90,43,0.22);
            position: relative; overflow: hidden;
        }
        .greeting-banner::before {
            content: '';
            position: absolute; top: -40px; right: -40px;
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%; pointer-events: none;
        }
        .greeting-banner::after {
            content: '';
            position: absolute; bottom: -50px; right: 80px;
            width: 120px; height: 120px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%; pointer-events: none;
        }
        .greeting-text { position: relative; z-index: 1; }
        .greeting-label {
            font-size: 0.78rem; font-weight: 700;
            letter-spacing: 0.14em; text-transform: uppercase;
            color: rgba(255,255,255,0.75); margin-bottom: 0.3rem;
        }
        .greeting-title {
            font-size: 1.7rem; font-weight: 800;
            color: #fff; line-height: 1.15; letter-spacing: -0.02em;
        }
        .greeting-sub {
            font-size: 0.85rem; color: rgba(255,255,255,0.75); margin-top: 0.3rem;
        }
        .greeting-icon-wrap {
            position: relative; z-index: 1;
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.18);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #fff; flex-shrink: 0;
        }

        /* ── Alerts ── */
        .alert-success-custom {
            background: #eafaf3;
            border: 1px solid #a7e8cc;
            color: #1a7a4a;
            border-radius: 12px; padding: 0.9rem 1.2rem;
            margin-bottom: 1.4rem;
            display: flex; align-items: flex-start; gap: 0.6rem;
            font-size: 0.88rem; font-weight: 500;
            animation: slideDown 0.35s ease;
        }
        .alert-error-custom {
            background: #fff0f0;
            border: 1px solid #fcc;
            color: #c0392b;
            border-radius: 12px; padding: 0.9rem 1.2rem;
            margin-bottom: 1.4rem;
            font-size: 0.88rem; font-weight: 500;
            animation: slideDown 0.35s ease;
        }
        .alert-error-custom ul { margin: 0.4rem 0 0 1rem; padding: 0; }
        .alert-error-custom li { margin-bottom: 0.2rem; }
        .alert-error-title {
            display: flex; align-items: center; gap: 0.5rem;
            font-weight: 700; margin-bottom: 0.2rem;
        }
        @keyframes slideDown {
            from { opacity:0; transform:translateY(-8px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* ── Form card ── */
        .form-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 22px; padding: 2.4rem;
            box-shadow: 0 4px 28px rgba(58,159,214,0.08);
            animation: cardIn 0.4s ease both;
        }
        @keyframes cardIn {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* Section divider */
        .section-divider {
            display: flex; align-items: center; gap: 0.8rem;
            margin: 1.7rem 0 1.5rem;
        }
        .section-divider-line { flex:1; height:1px; background: var(--border); }
        .section-divider-label {
            font-size: 0.7rem; font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap;
        }

        /* ── Fields ── */
        .field-group { margin-bottom: 1.4rem; }
        .field-label {
            display: flex; align-items: center; gap: 0.4rem;
            font-size: 0.81rem; font-weight: 600;
            color: var(--text-secondary); margin-bottom: 0.45rem;
        }
        .field-label i { font-size: 0.76rem; color: var(--celeste-1); }
        .field-label .readonly-badge {
            font-size: 0.65rem; font-weight: 600;
            background: var(--bg-header);
            color: var(--text-muted);
            padding: 0.1rem 0.45rem; border-radius: 4px;
            text-transform: uppercase; letter-spacing: 0.05em;
        }

        .field-input, .field-select, .field-textarea {
            width: 100%; box-sizing: border-box;
            background: var(--bg-hover);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 0.82rem 1.05rem;
            color: var(--text-primary);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.88rem; font-weight: 500;
            transition: all 0.22s; outline: none;
            appearance: none; -webkit-appearance: none;
        }
        .field-input::placeholder,
        .field-textarea::placeholder { color: var(--text-muted); }

        .field-input:focus, .field-select:focus, .field-textarea:focus {
            border-color: var(--celeste-2);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(58,159,214,0.12);
            color: var(--text-primary);
        }
        .field-input[readonly] {
            background: var(--bg-header);
            color: var(--text-muted);
            cursor: not-allowed;
            border-color: var(--border);
        }

        .select-wrapper { position: relative; }
        .select-wrapper::after {
            content: '\f078'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
            position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 0.7rem; pointer-events: none;
        }

        .field-textarea { resize: vertical; min-height: 110px; line-height: 1.55; }

        /* Tipo de incidente visual selector */
        .tipo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 0.65rem;
            margin-bottom: 0.3rem;
        }
        .tipo-option { display: none; }
        .tipo-option + label {
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 0.4rem;
            padding: 0.85rem 0.5rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            background: var(--bg-hover);
            cursor: pointer; transition: all 0.2s;
            font-size: 0.8rem; font-weight: 600;
            color: var(--text-muted); text-align: center; line-height: 1.2;
        }
        .tipo-option + label i { font-size: 1.25rem; }
        .tipo-option + label:hover {
            border-color: var(--border-accent);
            background: var(--celeste-light);
            color: var(--celeste-1);
        }
        .tipo-option:checked + label {
            border-color: var(--celeste-1);
            background: var(--celeste-light);
            color: var(--celeste-1);
            box-shadow: 0 0 0 3px rgba(224,90,43,0.1);
        }

        /* Hidden real select (fallback) */
        .tipo-select-hidden { display: none; }

        /* ── Footer ── */
        .form-footer {
            display: flex; justify-content: flex-end;
            align-items: center; margin-top: 2.2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            gap: 1rem;
        }

        .btn-submit {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: linear-gradient(135deg, var(--celeste-1), var(--celeste-2));
            border: none; color: #fff;
            padding: 0.72rem 1.75rem; border-radius: 11px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700; font-size: 0.88rem;
            cursor: pointer; transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(224,90,43,0.28);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(224,90,43,0.4);
        }
        .btn-submit:active { transform: translateY(0); }

        @media (max-width: 540px) {
            .tipo-grid { grid-template-columns: repeat(2, 1fr); }
            .form-footer { justify-content: flex-end; }
            .btn-submit { width: 100%; justify-content: center; }
        }
    </style>

    <div class="form-wrapper">
        <div class="page-inner">

            <!-- Banner -->
            <div class="greeting-banner">
                <div class="greeting-text">
                    <div class="greeting-title">Registrar Incidente</div>
                    <div class="greeting-sub">Completa el formulario con los detalles del incidente ocurrido en ruta.</div>
                </div>
                <div class="greeting-icon-wrap">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>

            <!-- Success -->
            @if(session('success'))
                <div class="alert-success-custom">
                    <i class="fas fa-circle-check" style="margin-top:2px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Errors -->
            @if($errors->any())
                <div class="alert-error-custom">
                    <div class="alert-error-title">
                        <i class="fas fa-circle-exclamation"></i> Corrige los siguientes errores:
                    </div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form card -->
            <div class="form-card">
                <form method="POST" action="{{ route('empleado.incidentes.store') }}">
                    @csrf

                    <!-- Conductor -->
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-user-tie"></i>
                            Conductor
                            <span class="readonly-badge">Automático</span>
                        </label>
                        <input type="text"
                               name="conductor_nombre"
                               class="field-input"
                               value="{{ old('conductor_nombre', $conductorNombre ?? '') }}"
                               readonly>
                    </div>

                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-label">Datos del vehículo y ruta</div>
                        <div class="section-divider-line"></div>
                    </div>

                    <!-- Bus -->
                    <div class="field-group">
                        <label class="field-label" for="bus_numero">
                            <i class="fas fa-bus"></i> Número de bus
                        </label>
                        <input type="text"
                               name="bus_numero"
                               id="bus_numero"
                               class="field-input"
                               placeholder="Ej: 042"
                               value="{{ old('bus_numero') }}">
                    </div>

                    <!-- Ruta -->
                    <div class="field-group">
                        <label class="field-label" for="ruta">
                            <i class="fas fa-route"></i> Ruta
                        </label>
                        <input type="text"
                               name="ruta"
                               id="ruta"
                               class="field-input"
                               placeholder="Ej: San Pedro Sula → Tegucigalpa"
                               value="{{ old('ruta') }}">
                    </div>

                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-label">Detalle del incidente</div>
                        <div class="section-divider-line"></div>
                    </div>

                    <!-- Tipo de incidente — visual grid -->
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-tag"></i> Tipo de incidente
                        </label>

                        <div class="tipo-grid">
                            @php
                                $iconos = [
                                    'Accidente'         => ['icon' => 'fa-car-crash',         'color' => '#c0392b'],
                                    'Falla mecánica'    => ['icon' => 'fa-wrench',             'color' => '#b34700'],
                                    'Tráfico'           => ['icon' => 'fa-traffic-light',      'color' => '#8a6d00'],
                                    'Incidente médico'  => ['icon' => 'fa-kit-medical',        'color' => '#1a7a4a'],
                                    'Otro'              => ['icon' => 'fa-circle-exclamation',  'color' => '#3a9fd6'],
                                ];
                            @endphp

                            @foreach($tipos as $tipo)
                                @php $info = $iconos[$tipo] ?? ['icon' => 'fa-circle-dot', 'color' => '#7aaac8']; @endphp
                                <div>
                                    <input
                                        class="tipo-option"
                                        type="radio"
                                        name="tipo_incidente"
                                        id="tipo_{{ $loop->index }}"
                                        value="{{ $tipo }}"
                                        {{ old('tipo_incidente') == $tipo ? 'checked' : '' }}
                                    >
                                    <label for="tipo_{{ $loop->index }}">
                                        <i class="fas {{ $info['icon'] }}" style="color:inherit;"></i>
                                        {{ $tipo }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="field-group">
                        <label class="field-label" for="descripcion">
                            <i class="fas fa-align-left"></i> Descripción
                        </label>
                        <textarea
                            name="descripcion"
                            id="descripcion"
                            class="field-textarea"
                            placeholder="Describe con detalle lo que ocurrió: lugar, circunstancias, personas involucradas...">{{ old('descripcion') }}</textarea>
                    </div>

                    <!-- Footer -->
                    <div class="form-footer">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-floppy-disk"></i> Guardar incidente
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection
