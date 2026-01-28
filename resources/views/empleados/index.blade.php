@extends('layouts.layoutadmin')

@section('title', 'Listado de Empleados')

@section('styles')
    <style>
        /* ======= Encabezado Azul ======= */
        .header-bar {
            background: linear-gradient(135deg, #4e73df, #3751b5);
            color: white;
            text-align: center;
            padding: 25px 0;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .header-bar h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        /* ======= Contenedor Principal ======= */
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        /* ======= Estadísticas ======= */
        .stats {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            color: black;
        }

        .stats span {
            margin-right: 20px;
        }

        /* ======= Botones superiores ======= */
        .top-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        /* Contenedor derecho con espacio entre botones */
        .top-btn .btn-group-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }


        .top-btn a.text-link {
            color: #000;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
        }

        .top-btn a.text-link i {
            margin-right: 8px;
            font-size: 20px;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        /* ======= Tarjetas de empleados ======= */
        .employee-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            padding: 5px 0;
        }

        .employee-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            text-align: center;
            font-size: 13px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .employee-card:hover {
            transform: translateY(-3px);
        }

        .employee-card h5 {
            color: #4e73df;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .employee-card p {
            margin: 2px 0;
            color: #555;
        }

        /* ======= Paginación ======= */
        .pagination {
            justify-content: center;
            margin-top: 10px;
        }

        .pagination .page-item .page-link {
            background: rgba(255, 255, 255, 0.2);
            color: black;
            border: none;
        }

        .pagination .page-item.active .page-link {
            background: #4e73df;
            color: white;
        }

        .pagination .page-item .page-link:hover {
            background: #3751b5;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container">

        <!-- Franja Azul -->
        <div class="header-bar">
            <h1>Lista de Empleados</h1>
        </div>

        <!-- Estadísticas -->
        <div class="stats">
            <span><strong>Activos:</strong> {{ $total_activos }}</span>
            <span><strong>Inactivos:</strong> {{ $total_inactivos }}</span>
            <span><strong>Empleados Registrados:</strong> {{ $total_empleados }}</span>
        </div>

        <!-- Botones superiores -->
        <div class="top-btn">
            <div>
                <a href="{{ route('empleados.hu5') }}" class="text-link">
                    <i class="fas fa-search"></i> Buscar Empleado
                </a>
            </div>

            <div class="btn-group-right">
                <a href="http://bustrak.test/admin/pagina" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Atrás
                </a>
                <a href="{{ route('empleados.create') }}" class="btn btn-primary">Registrar Nuevo</a>
            </div>
        </div>

        <!-- Tarjetas de empleados -->
        <div class="employee-grid">
            @forelse($empleados as $empleado)
                <a href="{{ route('empleados.show', $empleado->id) }}" style="text-decoration:none;">
                    <div class="employee-card">
                        @if($empleado->foto && file_exists(storage_path('app/public/'.$empleado->foto)))
                            <img src="{{ asset('storage/'.$empleado->foto) }}" alt="Foto de {{ $empleado->nombre }}"
                                 style="width:100px; height:100px; object-fit:cover; border-radius:50%; margin-bottom:10px;">
                        @else
                            <img src="https://via.placeholder.com/100?text=Sin+Foto" alt="Sin foto"
                                 style="width:100px; height:100px; object-fit:cover; border-radius:50%; margin-bottom:10px;">
                        @endif
                        <h5>{{ $empleado->nombre }} {{ $empleado->apellido }}</h5>
                        <p><strong>Cargo:</strong> {{ $empleado->cargo }}</p>
                        <p><strong>Estado:</strong>
                            <span style="color:{{ $empleado->estado === 'Activo' ? '#2ecc71' : '#7f8c8d' }}">
                                {{ $empleado->estado }}
                            </span>
                        </p>
                    </div>
                </a>
            @empty
                <p style="color:black; text-align:center;">No hay empleados registrados.</p>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="pagination-container">
            {{ $empleados->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
