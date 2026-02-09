@extends('layouts.layoutadmin')

@section('title', 'Calificaciones de Choferes')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="fas fa-chart-line me-2"></i> Estadísticas de Calificaciones
            </h5>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>Chofer</th>
                    <th>Promedio </th>
                    <th>Total Calificaciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($estadisticas as $chofer)
                    <tr>
                        <td>{{ $chofer->name }}</td>
                        <td class="fw-bold text-warning">
                            {{ number_format($chofer->calificaciones_avg_estrellas, 1) ?? '0.0' }}
                        </td>
                        <td>{{ $chofer->calificaciones_count }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
