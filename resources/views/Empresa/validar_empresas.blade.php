@extends('layouts.PlantillaCRUD')

@section('styles')
    <style>

        .btn-success {
            background-color: #38a169;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
        }
        .btn-success:hover {
            opacity: 0.85;
        }


        .alert-success {
            background-color: #f0fdf4;
            border-color: #86efac;
            color: #166534;
            padding: 10px 15px;
            border-radius: 6px;
        }


        .table-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 20px;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }


        .filter-box {
            background-color: white;
            color: #333;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-box label {
            font-weight: 600;
        }

        .filter-box select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .filter-box button {
            padding: 6px 12px;
            border-radius: 6px;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            color: #333;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #a084ca;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        tr:hover {
            background-color: #e2e2e2;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
        }

    </style>
@endsection

@section('contenido')
    <div class="container mt-4">
        <h2>Validar Empresas de Buses</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-container">

            <div class="filter-box">
                <form method="GET" action="{{ route('empresas.validar') }}" style="display:flex; gap:10px; width:100%;">
                    <label for="estado"> estado:</label>
                    <select name="estado" id="estado">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado')=='pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="aprobada" {{ request('estado')=='aprobada' ? 'selected' : '' }}>Aprobada</option>
                        <option value="rechazada" {{ request('estado')=='rechazada' ? 'selected' : '' }}>Rechazada</option>
                    </select>
                    <button type="submit" class="btn-success">Filtrar</button>
                </form>
            </div>

            <table>
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Estado de Validación</th>
                </tr>
                </thead>
                <tbody>
                @foreach($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->nombre }}</td>
                        <td>{{ $empresa->telefono }}</td>
                        <td>{{ ucfirst($empresa->estado_validacion ?? 'pendiente') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
