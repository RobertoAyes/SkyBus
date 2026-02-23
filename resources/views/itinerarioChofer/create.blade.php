@extends('layouts.layoutadmin')

@section('title', 'Asignar Itinerario')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

        :root {
            --bg-base:        #f0f7ff;
            --bg-card:        #ffffff;
            --bg-hover:       #f5faff;
            --bg-header:      #e8f3fd;
            --border:         #d0e8f8;
            --border-accent:  #a8d4f0;
            --celeste-1:      #3a9fd6;
            --celeste-2:      #5bb8e8;
            --celeste-light:  #e0f3fc;
            --celeste-soft:   #b8dff5;
            --text-primary:   #1a3a52;
            --text-secondary: #3a6a8a;
            --text-muted:     #7aaac8;
        }

        .create-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: var(--bg-base);
            padding: 2.5rem 2rem;
        }

        .page-inner {
            max-width: 660px;
            margin: 0 auto;
        }

        /* Breadcrumb */
        .breadcrumb-nav {
            display: flex; align-items: center; gap: 0.5rem;
            margin-bottom: 1.8rem; font-size: 0.8rem;
        }
        .breadcrumb-nav a {
            color: var(--celeste-1); text-decoration: none;
            font-weight: 600; transition: color 0.2s;
        }
        .breadcrumb-nav a:hover { color: var(--celeste-2); }
        .breadcrumb-nav .sep { color: var(--border-accent); }
        .breadcrumb-nav .current { color: var(--text-muted); }

        /* Title */
        .page-label {
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.16em; text-transform: uppercase;
            color: var(--celeste-1); margin-bottom: 0.3rem;
            display: flex; align-items: center; gap: 0.45rem;
        }
        .page-label::before {
            content: ''; display: inline-block;
            width: 18px; height: 2px;
            background: var(--celeste-1); border-radius: 2px;
        }
        .page-title {
            font-size: 1.95rem; font-weight: 800;
            color: var(--text-primary); line-height: 1.1;
            letter-spacing: -0.03em; margin-bottom: 0.4rem;
        }
        .page-title span { color: var(--celeste-1); }
        .page-subtitle {
            font-size: 0.86rem; color: var(--text-muted);
            margin-bottom: 2rem;
        }

        /* Card */
        .form-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 22px; padding: 2.4rem;
            box-shadow: 0 4px 28px rgba(58,159,214,0.09);
            animation: cardIn 0.4s ease both;
        }
        @keyframes cardIn {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* Steps */
        .step-indicators {
            display: flex; align-items: center;
            margin-bottom: 2.2rem;
        }
        .step { display:flex; align-items:center; gap:0.5rem; flex:1; }
        .step-dot {
            width: 30px; height: 30px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.76rem; font-weight: 700; flex-shrink: 0; transition: all 0.3s;
        }
        .step.active .step-dot {
            background: linear-gradient(135deg, var(--celeste-1), var(--celeste-2));
            color: #fff; box-shadow: 0 0 0 4px rgba(58,159,214,0.15);
        }
        .step.inactive .step-dot {
            background: var(--celeste-light);
            color: var(--text-muted);
            border: 1px solid var(--border-accent);
        }
        .step-text { font-size: 0.76rem; font-weight: 600; color: var(--text-muted); }
        .step.active .step-text { color: var(--celeste-1); }
        .step-line { flex:1; height:1px; background: var(--border); margin: 0 0.5rem; }

        /* Section divider */
        .section-divider {
            display: flex; align-items: center; gap: 0.8rem;
            margin: 1.7rem 0 1.4rem;
        }
        .section-divider-line { flex:1; height:1px; background: var(--border); }
        .section-divider-label {
            font-size: 0.7rem; font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap;
        }

        /* Fields */
        .field-group { margin-bottom: 1.4rem; }
        .field-label {
            display: flex; align-items: center; gap: 0.4rem;
            font-size: 0.81rem; font-weight: 600;
            color: var(--text-secondary); margin-bottom: 0.45rem;
            letter-spacing: 0.02em;
        }
        .field-label i { font-size: 0.76rem; color: var(--celeste-1); }

        .field-input, .field-select {
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
        .field-input::placeholder { color: var(--text-muted); }
        .field-input:focus, .field-select:focus {
            border-color: var(--celeste-2);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(58,159,214,0.12);
            color: var(--text-primary);
        }

        .select-wrapper { position: relative; }
        .select-wrapper::after {
            content: '\f078'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
            position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 0.7rem; pointer-events: none;
        }

        .field-input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            filter: invert(0.3) sepia(1) hue-rotate(180deg) saturate(1.5);
            cursor: pointer; opacity: 0.6;
        }

        .optional-badge {
            font-size: 0.67rem; font-weight: 600;
            background: var(--celeste-light);
            color: var(--celeste-1);
            padding: 0.12rem 0.5rem; border-radius: 4px;
            text-transform: uppercase; letter-spacing: 0.05em;
        }

        .field-error {
            font-size: 0.77rem; color: #c0392b;
            margin-top: 0.38rem;
            display: flex; align-items: center; gap: 0.3rem;
        }

        /* Footer */
        .form-footer {
            display: flex; justify-content: space-between;
            align-items: center; margin-top: 2.2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            gap: 1rem;
        }
        .btn-cancel {
            display: inline-flex; align-items: center; gap: 0.45rem;
            background: #fff;
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 0.72rem 1.35rem; border-radius: 11px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600; font-size: 0.86rem;
            text-decoration: none; transition: all 0.22s;
        }
        .btn-cancel:hover {
            background: var(--bg-hover);
            border-color: var(--border-accent);
            color: var(--text-secondary);
        }
        .btn-submit {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: linear-gradient(135deg, var(--celeste-1), var(--celeste-2));
            border: none; color: #fff;
            padding: 0.72rem 1.75rem; border-radius: 11px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700; font-size: 0.88rem;
            cursor: pointer; transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(58,159,214,0.28);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(58,159,214,0.4);
        }
        .btn-submit:active { transform: translateY(0); }
    </style>

    <div class="create-wrapper">
        <div class="page-inner">

            <nav class="breadcrumb-nav">
                <a href="{{ route('itinerarioChofer.index') }}"><i class="fas fa-calendar-alt me-1"></i>Itinerarios</a>
                <span class="sep">/</span>
                <span class="current">Asignar nuevo</span>
            </nav>

            <div class="page-label">Nuevo registro</div>
            <h1 class="page-title">Asignar <span>Itinerario</span></h1>
            <p class="page-subtitle">Vincula un chofer a una ruta con fecha y hora específicas.</p>

            <div class="form-card">

                <div class="step-indicators">
                    <div class="step active">
                        <div class="step-dot">1</div>
                        <span class="step-text">Chofer</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step inactive">
                        <div class="step-dot">2</div>
                        <span class="step-text">Ruta</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step inactive">
                        <div class="step-dot">3</div>
                        <span class="step-text">Horario</span>
                    </div>
                </div>

                <form action="{{ route('itinerarioChofer.store') }}" method="POST">
                    @csrf

                    <div class="field-group">
                        <label class="field-label" for="chofer_id">
                            <i class="fas fa-user-tie"></i> Chofer asignado
                        </label>
                        <div class="select-wrapper">
                            <select name="chofer_id" id="chofer_id" class="field-select" required>
                                <option value="">Seleccione un chofer...</option>
                                @foreach($choferes as $chofer)
                                    <option value="{{ $chofer->id }}" {{ old('chofer_id') == $chofer->id ? 'selected' : '' }}>
                                        {{ $chofer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('chofer_id')
                        <div class="field-error"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-label">Ruta</div>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="ruta_id">
                            <i class="fas fa-route"></i> Ruta de viaje
                        </label>
                        <div class="select-wrapper">
                            <select name="ruta_id" id="ruta_id" class="field-select" required>
                                <option value="">Seleccione una ruta...</option>
                                @foreach($rutas as $ruta)
                                    <option value="{{ $ruta->id }}" {{ old('ruta_id') == $ruta->id ? 'selected' : '' }}>
                                        {{ $ruta->origen }} → {{ $ruta->destino }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('ruta_id')
                        <div class="field-error"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-label">Horario</div>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="fecha">
                            <i class="fas fa-clock"></i> Fecha y hora
                            <span class="optional-badge">Opcional</span>
                        </label>
                        <input
                            type="datetime-local"
                            name="fecha" id="fecha"
                            class="field-input"
                            value="{{ old('fecha') ? \Carbon\Carbon::parse(old('fecha'))->format('Y-m-d\TH:i') : '' }}"
                        >
                        @error('fecha')
                        <div class="field-error"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <a href="{{ route('itinerarioChofer.index') }}" class="btn-cancel">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-check"></i> Asignar Itinerario
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection
