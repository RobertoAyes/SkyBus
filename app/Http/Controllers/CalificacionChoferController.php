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
        // Obtener todos los choferes con estadísticas
        $estadisticas = User::where('role', 'Chofer')
            ->withCount('calificacionesRecibidas')          // total de calificaciones
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
        

        // Guardar calificación
        CalificacionChofer::create([
            'usuario_id' => auth()->id(),
            'chofer_id' => $request->chofer_id,
            'estrellas' => $request->estrellas,
            'comentario' => $request->comentario,
        ]);


// Enviar notificación a todos los admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notificacion::create([
                'usuario_id' => $admin->id,
                'titulo' => 'Nueva calificación de chofer',
                'mensaje' => 'El usuario ' . auth()->user()->name .
                    ' calificó a un chofer con ' . $request->estrellas . ' estrellas.',
                'tipo' => 'alerta',
            ]);
        }

        return redirect()->back()->with('success', 'Calificación guardada correctamente');


    }
    public function create()
    {
        // Obtener solo usuarios con rol Chofer
        $choferes = User::where('role', 'Chofer')->get();

        return view('cliente.calificaciones.form', compact('choferes'));
    }

}

