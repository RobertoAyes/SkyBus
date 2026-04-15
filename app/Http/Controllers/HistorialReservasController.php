<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class HistorialReservasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reservas = Reserva::with([
            'viaje.ruta',
            'asiento'
        ])
            ->where('user_id', Auth::id())
            ->orderBy('fecha_reserva', 'desc')
            ->paginate(10);

        return view('cliente.historial', compact('reservas'));
    }
}
