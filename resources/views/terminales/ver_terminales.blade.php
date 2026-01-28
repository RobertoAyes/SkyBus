@extends('layouts.layoutadmin')

@section('title', 'Visualización de Terminales')

@section('content')
    <div class="container mt-5">
        <div class="card p-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #e6e9f0 100%); border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h2 class="text-center mb-4" style="color: #003366;">Visualización de Terminales</h2>

            <!-- Formulario de búsqueda y filtro -->
            <form method="GET" action="{{ route('terminales.ver_terminales') }}" class="row g-2 mb-4">
            <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o ciudad" value="{{ $search }}">
                </div>
                <div class="col-md-3">
                    <select name="estado" class="form-select">
                        <option value="">-- Todos los estados --</option>
                        <option value="activo" {{ $estado == 'activo' ? 'selected' : '' }}>Activas</option>
                        <option value="inactivo" {{ $estado == 'inactivo' ? 'selected' : '' }}>Inactivas</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    <a href="{{ route('terminales.index') }}" class="btn btn-secondary w-100">Limpiar</a>
                </div>
            </form>

            <!-- Tabla de terminales -->
            @if ($terminales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Ciudad</th>
                            <th class="text-center">Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($terminales as $terminal)
                            <tr>
                                <td>{{ $terminal->nombre }}</td>
                                <td>{{ $terminal->direccion }}</td>
                                <td>{{ $terminal->ciudad }}</td>
                                <td class="text-center">
                                    @if ($terminal->estado == 'activo')
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-3 d-flex justify-content-center">
                    {{ $terminales->links() }}
                </div>
            @else
                <p class="text-center text-muted mt-4">No hay terminales registradas.</p>
            @endif
        </div>
    </div>
@endsection
