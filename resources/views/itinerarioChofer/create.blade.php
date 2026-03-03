@extends('layouts.layoutadmin')

@section('title', 'Asignar Itinerario')


@section('content')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .frm-wrap { font-family: 'DM Sans', sans-serif; background: #f0f9ff; min-height: 100vh; padding: 1.75rem 1.5rem; }
        .frm-inner { max-width: 860px; margin: 0 auto; }

        .frm-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .frm-title { font-size: 1.3rem; font-weight: 700; color: #0c1a2e; letter-spacing: -.02em; margin: 0; }

        .frm-btn-back { display: inline-flex; align-items: center; gap: .4rem; font-size: .8rem; font-weight: 600; color: #64748b; background: #fff; border: 1px solid #e2edf8; border-radius: 7px; padding: .4rem .85rem; text-decoration: none; transition: all .15s; }
        .frm-btn-back:hover { color: #1e3a5f; border-color: #c9dff2; background: #f8fbff; }
        .frm-btn-back i { font-size: .72rem; }

        .frm-err { background: #fff1f0; border: 1px solid #fecaca; border-radius: 9px; padding: .7rem 1rem; margin-bottom: 1.1rem; font-size: .82rem; color: #dc2626; }
        .frm-err ul { padding-left: 1.1rem; }
        .frm-err li { margin-top: .2rem; }

        .frm-card { background: #fff; border: 1px solid #e2edf8; border-radius: 12px; padding: 2rem 2.25rem; box-shadow: 0 1px 10px rgba(14,165,233,.05); margin-bottom: 1.25rem; }

        .frm-section-title { font-size: .72rem; font-weight: 700; color: #0284c7; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 1rem; display: flex; align-items: center; gap: .4rem; }
        .frm-section-title i { font-size: .75rem; }
        .frm-section-line { flex: 1; height: 1px; background: #e2edf8; }

        .frm-field { margin-bottom: 1.25rem; }
        .frm-field:last-child { margin-bottom: 0; }
        .frm-field label { display: block; font-size: .82rem; font-weight: 600; color: #64748b; margin-bottom: .45rem; letter-spacing: .01em; }
        .frm-field input, .frm-field select { font-family: 'DM Sans', sans-serif; font-size: .9rem; width: 100%; border: 1px solid #c9dff2; border-radius: 8px; padding: .7rem 1rem; color: #1e3a5f; background: #f8fbff; outline: none; transition: border .15s, box-shadow .15s; appearance: none; -webkit-appearance: none; }
        .frm-field input:focus, .frm-field select:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff; }
        .frm-field input[type="datetime-local"] { font-family: 'DM Mono', monospace; font-size: .87rem; }
        .frm-hint { font-size: .72rem; color: #94a3b8; margin-top: .25rem; }

        .frm-row { display: flex; flex-direction: column; gap: 0; }

        .frm-paradas-labels { display: grid; grid-template-columns: 1fr 100px 32px; gap: .4rem; padding: 0 .7rem; margin-bottom: .25rem; }
        .frm-paradas-labels span { font-size: .68rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; }

        #frm-paradas-container { display: flex; flex-direction: column; gap: .5rem; }

        .frm-parada-item { display: grid; grid-template-columns: 1fr 100px 32px; gap: .4rem; align-items: center; background: #f8fbff; border: 1px solid #e2edf8; border-radius: 8px; padding: .5rem .7rem; transition: border .15s; }
        .frm-parada-item:focus-within { border-color: #bae6fd; }
        .frm-parada-item input { font-family: 'DM Sans', sans-serif; font-size: .83rem; border: 1px solid #c9dff2; border-radius: 6px; padding: .38rem .6rem; color: #1e3a5f; background: #fff; outline: none; transition: border .15s, box-shadow .15s; width: 100%; }
        .frm-parada-item input:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.12); }

        .frm-btn-remove { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; border: 1px solid #fecaca; background: #fff1f0; color: #dc2626; font-size: .72rem; cursor: pointer; transition: all .15s; flex-shrink: 0; }
        .frm-btn-remove:hover { background: #fee2e2; transform: scale(1.06); }

        .frm-btn-add { display: inline-flex; align-items: center; gap: .35rem; font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 600; color: #0284c7; background: #e0f2fe; border: 1px dashed #bae6fd; border-radius: 7px; padding: .42rem .9rem; cursor: pointer; transition: all .15s; margin-top: .5rem; }
        .frm-btn-add:hover { background: #f0f9ff; border-color: #38bdf8; }

        .frm-actions { display: flex; align-items: center; justify-content: flex-end; gap: .6rem; margin-top: 1.25rem; }
        .frm-btn-cancel { font-family: 'DM Sans', sans-serif; font-size: .83rem; font-weight: 600; color: #64748b; background: #fff; border: 1px solid #e2edf8; border-radius: 8px; padding: .55rem 1.1rem; text-decoration: none; transition: all .15s; }
        .frm-btn-cancel:hover { color: #1e3a5f; background: #f8fbff; border-color: #c9dff2; }
        .frm-btn-save { font-family: 'DM Sans', sans-serif; font-size: .83rem; font-weight: 600; color: #fff; background: #0284c7; border: none; border-radius: 8px; padding: .55rem 1.4rem; cursor: pointer; display: inline-flex; align-items: center; gap: .4rem; transition: all .18s; box-shadow: 0 2px 8px rgba(2,132,199,.25); }
        .frm-btn-save:hover { background: #0369a1; transform: translateY(-1px); box-shadow: 0 5px 16px rgba(2,132,199,.35); }
        .frm-btn-save i { font-size: .75rem; }
    </style>
    <div class="frm-wrap">
        <div class="frm-inner">

            <div class="frm-topbar">
                <h1 class="frm-title">Asignar Itinerario</h1>
                <a href="{{ route('itinerarioChofer.index') }}" class="frm-btn-back">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

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

            <form action="{{ route('itinerarioChofer.store') }}" method="POST">
                @csrf

                <div class="frm-card">
                    <div class="frm-section-title">
                        <i class="fas fa-user-tie"></i> Asignación
                        <span class="frm-section-line"></span>
                    </div>

                    <div class="frm-row">
                        <div class="frm-field">
                            <label for="chofer_id">Chofer</label>
                            <select name="chofer_id" id="chofer_id" required>
                                <option value="">Seleccionar chofer…</option>
                                @foreach($choferes as $chofer)
                                    <option value="{{ $chofer->id }}" {{ old('chofer_id') == $chofer->id ? 'selected' : '' }}>
                                        {{ $chofer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="frm-field">
                            <label for="ruta_id">Ruta</label>
                            <select name="ruta_id" id="ruta_id" required>
                                <option value="">Seleccionar ruta…</option>
                                @foreach($rutas as $ruta)
                                    <option value="{{ $ruta->id }}" {{ old('ruta_id') == $ruta->id ? 'selected' : '' }}>
                                        {{ $ruta->origen }} → {{ $ruta->destino }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="frm-field">
                        <label for="fecha">Fecha y Hora</label>
                        <input type="datetime-local" name="fecha" id="fecha" value="{{ old('fecha') }}" required>
                        <div class="frm-hint">Selecciona el día y la hora de salida</div>
                    </div>
                </div>

                <div class="frm-card">
                    <div class="frm-section-title">
                        <i class="fas fa-map-marker-alt"></i> Paradas intermedias
                        <span style="font-weight:400;font-size:.68rem;color:#94a3b8;text-transform:none;letter-spacing:0;">&nbsp;(opcional)</span>
                        <span class="frm-section-line"></span>
                    </div>

                    <div class="frm-paradas-labels">
                        <span>Lugar de parada</span>
                        <span>Tiempo (min)</span>
                        <span></span>
                    </div>

                    <div id="frm-paradas-container">
                        <div class="frm-parada-item">
                            <input type="text" name="paradas[lugar][]" placeholder="Ej: Terminal Norte">
                            <input type="number" name="paradas[tiempo][]" placeholder="0" min="0" step="1">
                            <button type="button" class="frm-btn-remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>

                    <button type="button" id="frm-btn-add" class="frm-btn-add">
                        <i class="fas fa-plus"></i> Agregar parada
                    </button>
                </div>

                <div class="frm-actions">
                    <a href="{{ route('itinerarioChofer.index') }}" class="frm-btn-cancel">Cancelar</a>
                    <button type="submit" class="frm-btn-save"><i class="fas fa-check"></i> Guardar Itinerario</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('frm-btn-add').addEventListener('click', function () {
            var container = document.getElementById('frm-paradas-container');
            var div = document.createElement('div');
            div.className = 'frm-parada-item';
            div.innerHTML = '<input type="text" name="paradas[lugar][]" placeholder="Ej: Terminal Norte">'
                + '<input type="number" name="paradas[tiempo][]" placeholder="0" min="0" step="1">'
                + '<button type="button" class="frm-btn-remove"><i class="fas fa-times"></i></button>';
            container.appendChild(div);
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.frm-btn-remove')) {
                var items = document.querySelectorAll('.frm-parada-item');
                var item  = e.target.closest('.frm-parada-item');
                if (items.length > 1) {
                    item.remove();
                } else {
                    item.querySelectorAll('input').forEach(function(i) { i.value = ''; });
                }
            }
        });
    </script>
@endsection
