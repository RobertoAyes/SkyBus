<?php

namespace App\Http\Controllers;

use App\Models\CalificacionChofer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CalificacionChoferController extends Controller
{
    /**
     * Mostrar formulario para calificar chofer
     */


    public function index()
    {
        // Obtener choferes con promedio y total de calificaciones
        $estadisticas = User::where('role', 'Chofer')
            ->withCount('calificacionesRecibidas')   // total de calificaciones
            ->withAvg('calificacionesRecibidas', 'estrellas') // promedio de estrellas
            ->get();

        return view('admin.calificaciones.index', compact('estadisticas'));
    }




    /**
     * Guardar la calificación
     */
    public function store(Request $request)
    {
        $request->validate([
            'chofer_id'  => 'required|exists:users,id',
            'estrellas'  => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        CalificacionChofer::create([
            'usuario_id' => auth()->id(), // usuario que califica
            'chofer_id'  => $request->chofer_id,
            'estrellas'  => $request->estrellas,
            'comentario' => $request->comentario,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Calificación guardada correctamente');
    }
}

