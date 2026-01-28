<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calificacion;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function create($reserva_id)
    {
        $reserva = Reserva::findOrFail($reserva_id);

        if (session('success')) {
            return view('calificacion.create', compact('reserva'));
        }


        $viaje = $reserva->viaje;


        if ($reserva->estado !== 'confirmada' || !$viaje->fecha_llegada) {
            return redirect()->route('cliente.historial')
                ->with('error', 'No puedes calificar. Tu viaje aún no ha terminado ');
        }



        if (Calificacion::where('reserva_id', $reserva->id)->exists()) {
            return redirect()->route('cliente.historial')->with('error', 'Este viaje ya fue calificado.');
        }

        return view('calificacion.create', compact('reserva'));
    }

    public function store(Request $request, $reserva_id)
    {

        $request->validate([
            'estrellas' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|required_if:estrellas,1,2',
        ]);


        $existingCalificacion = Calificacion::where('reserva_id', $reserva_id)
            ->where('usuario_id', Auth::id() ?? null)
            ->first();



        if ($existingCalificacion) {

            return redirect()->route('calificacion.create', $reserva_id)
                ->with('error', 'Ya has calificado este viaje.');
        }


        Calificacion::create([
            'reserva_id' => $reserva_id,
            'usuario_id' => null,
            'estrellas' => $request->estrellas,
            'comentario' => $request->comentario,
        ]);


        return redirect()->route('calificacion.create', $reserva_id)
            ->with('success', 'Calificación registrada correctamente.');
    }
}

