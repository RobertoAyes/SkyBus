@extends('layouts.layoutchofer')

@section('title', 'Solicitar Soporte Técnico')

@section('contenido')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-tools me-2"></i>Solicitar Soporte Técnico</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('soporte.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="5" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Enviar Solicitud</button>
            </form>
        </div>
    </div>
@endsection
