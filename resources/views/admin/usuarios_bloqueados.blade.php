@extends('layouts.layoutadmin')

@section('title', 'Usuarios bloqueados')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            {{-- Card Header estilo como "Consultas de Usuarios" --}}
            <div class="card-header bg-white border-0 d-flex align-items-center">
                <h2 class="mb-0 fw-bold" style="font-size: 2rem;">
                    <i class="fas fa-user-lock me-2 text-primary"></i>Usuarios bloqueados
                </h2>
            </div>

            <div class="card-body">

                {{-- Tabla responsive --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>Email</th>
                            <th>Intentos fallidos</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($bloqueados as $usuario)
                            <tr>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->intentos }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">
                                    <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                                    No hay usuarios bloqueados actualmente
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- Estilos adicionales --}}
    <style>
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endsection
