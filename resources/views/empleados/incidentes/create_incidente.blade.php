@extends('layouts.layoutchofer')

@section('contenido')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .frm-wrap { font-family: 'DM Sans', sans-serif; background: #f0f9ff; min-height: 100vh; padding: 1.75rem 1.5rem; }
        .frm-inner { max-width: 860px; margin: 0 auto; }

        .frm-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .frm-title { font-size: 1.3rem; font-weight: 700; color: #0c1a2e; letter-spacing: -.02em; margin: 0; }

        .frm-flash-ok { display: flex; align-items: center; gap: .5rem; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: .65rem 1rem; border-radius: 8px; font-size: .83rem; font-weight: 500; margin-bottom: 1rem; }
        .frm-err { background: #fff1f0; border: 1px solid #fecaca; border-radius: 9px; padding: .7rem 1rem; margin-bottom: 1.1rem; font-size: .82rem; color: #dc2626; }
        .frm-err ul { padding-left: 1.1rem; }
        .frm-err li { margin-top: .2rem; }

        .frm-card { background: #fff; border: 1px solid #e2edf8; border-radius: 12px; padding: 2rem 2.25rem; box-shadow: 0 1px 10px rgba(14,165,233,.05); margin-bottom: 1.25rem; }

        .frm-section-title { font-size: .72rem; font-weight: 700; color: #0284c7; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 1rem; display: flex; align-items: center; gap: .4rem; }
        .frm-section-title i { font-size: .75rem; }
        .frm-section-line { flex: 1; height: 1px; background: #e2edf8; }

        .frm-field { margin-bottom: 1.25rem; }
        .frm-field:last-child { margin-bottom: 0; }
        .frm-field label { display: flex; align-items: center; gap: .35rem; font-size: .82rem; font-weight: 600; color: #64748b; margin-bottom: .45rem; letter-spacing: .01em; }
        .frm-field label i { font-size: .75rem; color: #0284c7; }
        .frm-field input, .frm-field select, .frm-field textarea { font-family: 'DM Sans', sans-serif; font-size: .9rem; width: 100%; border: 1px solid #c9dff2; border-radius: 8px; padding: .7rem 1rem; color: #1e3a5f; background: #f8fbff; outline: none; transition: border .15s, box-shadow .15s; appearance: none; -webkit-appearance: none; box-sizing: border-box; }
        .frm-field input:focus, .frm-field select:focus, .frm-field textarea:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff; }
        .frm-field input[readonly] { background: #f1f7fc; color: #94a3b8; cursor: not-allowed; border-color: #e2edf8; }
        .frm-field textarea { resize: vertical; min-height: 120px; line-height: 1.6; }
        .frm-hint { font-size: .72rem; color: #94a3b8; margin-top: .25rem; }
        .frm-readonly-badge { font-size: .65rem; font-weight: 600; background: #f1f7fc; color: #94a3b8; border: 1px solid #e2edf8; padding: .1rem .45rem; border-radius: 4px; text-transform: uppercase; letter-spacing: .04em; }

        .frm-tipo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: .6rem; margin-bottom: .25rem; }
        .frm-tipo-opt { display: none; }
        .frm-tipo-opt + label { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .4rem; padding: .85rem .5rem; border: 1.5px solid #e2edf8; border-radius: 10px; background: #f8fbff; cursor: pointer; transition: all .18s; font-size: .78rem; font-weight: 600; color: #94a3b8; text-align: center; line-height: 1.25; }
        .frm-tipo-opt + label i { font-size: 1.2rem; }
        .frm-tipo-opt + label:hover { border-color: #bae6fd; background: #e0f2fe; color: #0284c7; }
        .frm-tipo-opt:checked + label { border-color: #0284c7; background: #e0f2fe; color: #0284c7; box-shadow: 0 0 0 3px rgba(56,189,248,.12); }

        .frm-actions { display: flex; align-items: center; justify-content: flex-end; gap: .6rem; margin-top: 1.25rem; }
        .frm-btn-save { font-family: 'DM Sans', sans-serif; font-size: .83rem; font-weight: 600; color: #fff; background: #0284c7; border: none; border-radius: 8px; padding: .55rem 1.4rem; cursor: pointer; display: inline-flex; align-items: center; gap: .4rem; transition: all .18s; box-shadow: 0 2px 8px rgba(2,132,199,.25); }
        .frm-btn-save:hover { background: #0369a1; transform: translateY(-1px); box-shadow: 0 5px 16px rgba(2,132,199,.35); }
        .frm-btn-save i { font-size: .75rem; }
        .greeting-banner {
            background: linear-gradient(135deg,#3a9fd6 0%,#5bb8e8 100%);
            border-radius: 20px;
            padding: 1.8rem 2rem;
            margin-bottom: 1.8rem;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 28px rgba(58,159,214,0.25);
        }
        .greeting-title { font-weight: 800; font-size: 1.5rem; }
        .greeting-sub   { font-size: 0.9rem; opacity: 0.85; }
        .greeting-icon-wrap { font-size: 1.6rem; }
    </style>

    <div class="frm-wrap">
        <div class="frm-inner">

            <div class="greeting-banner">
                <div class="greeting-text">
                    <div class="greeting-title">Registrar Incidente</div>
                    <div class="greeting-sub">Por favor de ser detallado al momento de llenar el formulario.</div>
                </div>
                <div class="greeting-icon-wrap">
                    <i class="fas fa-bus"></i>
                </div>
            </div>

            @if(session('success'))
                <div class="frm-flash-ok"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="frm-err">
                    <strong><i class="fas fa-exclamation-circle me-1"></i>Corrige los siguientes errores:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('empleado.incidentes.store') }}">
                @csrf

                {{-- CARD: Información general --}}
                <div class="frm-card">
                    <div class="frm-section-title">
                        <i class="fas fa-user-tie"></i> Información general
                        <span class="frm-section-line"></span>
                    </div>

                    <div class="frm-field">
                        <label for="conductor_nombre">
                            <i class="fas fa-user-tie"></i> Conductor
                            <span class="frm-readonly-badge">Automático</span>
                        </label>
                        <input type="text" name="conductor_nombre" id="conductor_nombre"
                               value="{{ old('conductor_nombre', $conductorNombre ?? '') }}" readonly>
                    </div>

                    <div class="frm-field">
                        <label for="bus_numero">
                            <i class="fas fa-bus"></i> Número de bus
                        </label>
                        <input type="text" name="bus_numero" id="bus_numero"
                               placeholder="Ej: 042" value="{{ old('bus_numero') }}">
                    </div>

                    <div class="frm-field">
                        <label for="ruta">
                            <i class="fas fa-route"></i> Ruta
                        </label>
                        <input type="text" name="ruta" id="ruta"
                               placeholder="Ej: San Pedro Sula → Tegucigalpa" value="{{ old('ruta') }}">
                    </div>
                </div>

                {{-- CARD: Detalle del incidente --}}
                <div class="frm-card">
                    <div class="frm-section-title">
                        <i class="fas fa-exclamation-triangle"></i> Detalle del incidente
                        <span class="frm-section-line"></span>
                    </div>

                    <div class="frm-field">
                        <label><i class="fas fa-tag"></i> Tipo de incidente</label>
                        <div class="frm-tipo-grid">
                            @php
                                $iconos = [
                                    'Accidente'        => 'fa-car-crash',
                                    'Falla mecánica'   => 'fa-wrench',
                                    'Tráfico'          => 'fa-traffic-light',
                                    'Incidente médico' => 'fa-kit-medical',
                                    'Otro'             => 'fa-circle-exclamation',
                                ];
                            @endphp
                            @foreach($tipos as $tipo)
                                @php $icono = $iconos[$tipo] ?? 'fa-circle-dot'; @endphp
                                <div>
                                    <input class="frm-tipo-opt" type="radio" name="tipo_incidente"
                                           id="tipo_{{ $loop->index }}" value="{{ $tipo }}"
                                        {{ old('tipo_incidente') == $tipo ? 'checked' : '' }}>
                                    <label for="tipo_{{ $loop->index }}">
                                        <i class="fas {{ $icono }}"></i>
                                        {{ $tipo }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="frm-field">
                        <label for="descripcion">
                            <i class="fas fa-align-left"></i> Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion"
                                  placeholder="Describe con detalle lo que ocurrió: lugar, circunstancias, personas involucradas...">{{ old('descripcion') }}</textarea>
                        <div class="frm-hint">Sé lo más detallado posible para facilitar el seguimiento.</div>
                    </div>
                </div>

                <div class="frm-field">
                    <label for="ubicacion">
                        <i class="fas fa-location-dot"></i> Ubicación actual
                    </label>
                    <input type="text" name="ubicacion" id="ubicacion"
                           value="{{ old('ubicacion') }}"
                           placeholder="Ej: Boulevard Morazán, parada UNAH, Terminal...">
                </div>

                <div class="frm-field">
                    <label for="nivel_gravedad">
                        <i class="fas fa-triangle-exclamation"></i> Nivel de gravedad
                    </label>

                    <select name="nivel_gravedad" id="nivel_gravedad">
                        <option value="">Seleccione gravedad</option>
                        <option value="baja" {{ old('nivel_gravedad') == 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ old('nivel_gravedad') == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta" {{ old('nivel_gravedad') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="critica" {{ old('nivel_gravedad') == 'critica' ? 'selected' : '' }}>Crítica</option>
                    </select>
                </div>

                <div class="frm-actions">
                    <button type="submit" class="frm-btn-save">
                        <i class="fas fa-floppy-disk"></i> Guardar incidente
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection
