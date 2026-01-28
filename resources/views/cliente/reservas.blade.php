@extends('layouts.layoutuser')

@section('contenido')
    <style>
        .reservas-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 40px;
            margin-top: 20px;
        }

        .card h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .card h2 i {
            color: #1976d2;
            margin-right: 15px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #666;
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 25px;
            color: #cbd5e0;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #2d3748;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .empty-state p {
            font-size: 1.1rem;
            color: #718096;
            margin: 0;
        }

        /* Botón de acción opcional */
        .btn-primary-custom {
            background: linear-gradient(135deg, #1976d2, #1565c0);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 25px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
            color: white;
        }
    </style>

    <div class="reservas-container">
        <div class="card">
            <h2>
                <i class="fas fa-ticket-alt"></i>Mis Reservas
            </h2>

            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3>No tienes reservas aún</h3>
                <p>Cuando realices una reserva, aparecerá aquí con todos los detalles de tu viaje.</p>
            </div>
        </div>
    </div>
@endsection
