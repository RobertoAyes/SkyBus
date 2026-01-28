@extends('layouts.layoutuser')

@section('title', 'Mis Notificaciones')

@section('contenido')
    <div class="container mt-4">
        <h2 class="mb-3" style="color:#1e63b8;">
            <i class="fas fa-bell me-2"></i>Mis Notificaciones
        </h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($notificaciones->count() > 0)
            <div class="list-group shadow-sm">
                @foreach($notificaciones as $notif)
                    <div class="list-group-item d-flex justify-content-between align-items-start {{ $notif->leida ? 'bg-light' : '' }}">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{ $notif->titulo }}</div>
                            <small>{{ $notif->mensaje }}</small><br>
                            <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            @if(!$notif->leida)
                                <a href="{{ route('notificaciones.leida', $notif->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-check"></i> Leer
                                </a>
                            @endif
                            <form action="{{ route('notificaciones.eliminar', $notif->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                No tienes notificaciones.
            </div>
        @endif
    </div>
@endsection
