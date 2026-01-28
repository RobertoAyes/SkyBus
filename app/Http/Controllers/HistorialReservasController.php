<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class HistorialReservasController extends Controller
{
    // Solo usuarios autenticados
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuario = Auth::user();

        // Traer reservas del usuario con información del viaje
        $reservas = Reserva::with('viaje')
            ->where('user_id', $usuario->id)
            ->orderBy('fecha_reserva', 'desc')
            ->paginate(10);

        return view('cliente.historial', compact('reservas'));
    }
}

