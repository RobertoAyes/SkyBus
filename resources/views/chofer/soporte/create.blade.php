@extends('layouts.layoutchofer')

@section('title', 'Solicitar Soporte Técnico')

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
        .frm-field input, .frm-field textarea { font-family: 'DM Sans', sans-serif; font-size: .9rem; width: 100%; border: 1px solid #c9dff2; border-radius: 8px; padding: .7rem 1rem; color: #1e3a5f; background: #f8fbff; outline: none; transition: border .15s, box-shadow .15s; box-sizing: border-box; }
        .frm-field input:focus, .frm-field textarea:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); background: #fff; }
        .frm-field textarea { resize: vertical; min-height: 140px; line-height: 1.6; }
        .frm-hint { font-size: .72rem; color: #94a3b8; margin-top: .25rem; }
        .frm-err-field { font-size: .72rem; color: #dc2626; margin-top: .25rem; }

        .frm-actions { display: flex; align-items: center; justify-content: flex-end; gap: .6rem; margin-top: 1.25rem; }
        .frm-btn-save { font-family: 'DM Sans', sans-serif; font-size: .83rem; font-weight: 600; color: #fff; background: #0284c7; border: none; border-radius: 8px; padding: .55rem 1.4rem; cursor: pointer; display: inline-flex; align-items: center; gap: .4rem; transition: all .18s; box-shadow: 0 2px 8px rgba(2,132,199,.25); }
        .frm-btn-save:hover { background: #0369a1; transform: translateY(-1px); box-shadow: 0 5px 16px rgba(2,132,199,.35); }
        .frm-btn-save i { font-size: .75rem; }
    </style>

    <div class="frm-wrap">
        <div class="frm-inner">

            <div class="frm-topbar">
                <h1 class="frm-title">Solicitar Soporte Técnico</h1>
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

            <form action="{{ route('chofer.soporte.store') }}" method="POST">
                @csrf

                <div class="frm-card">
                    <div class="frm-section-title">
                        <i class="fas fa-tools"></i> Detalles de la solicitud
                        <span class="frm-section-line"></span>
                    </div>

                    <div class="frm-field">
                        <label for="titulo">
                            <i class="fas fa-heading"></i> Título
                        </label>
                        <input type="text" name="titulo" id="titulo"
                               placeholder="Describe brevemente el problema…"
                               value="{{ old('titulo') }}" required>
                        @error('titulo')
                        <div class="frm-err-field">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="frm-field">
                        <label for="descripcion">
                            <i class="fas fa-align-left"></i> Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" required
                                  placeholder="Explica con detalle el problema que estás experimentando…">{{ old('descripcion') }}</textarea>
                        <div class="frm-hint">Sé lo más detallado posible para facilitar el seguimiento.</div>
                        @error('descripcion')
                        <div class="frm-err-field">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="frm-actions">
                    <button type="submit" class="frm-btn-save">
                        <i class="fas fa-paper-plane"></i> Enviar Solicitud
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection
