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


    public function index(Request $request)
    {
        $query = CalificacionChofer::query()
            ->join('users as chofer', 'calificaciones_chofer.chofer_id', '=', 'chofer.id')
            ->join('users as usuario', 'calificaciones_chofer.usuario_id', '=', 'usuario.id')
            ->select(
                'calificaciones_chofer.*',
                'chofer.name as chofer_nombre',
                'usuario.name as usuario_nombre'
            );


        if ($request->buscar) {
            $q = $request->buscar;
            $query->where(function($sub) use ($q) {
                $sub->where('chofer.name', 'like', "%$q%")
                    ->orWhere('usuario.name', 'like', "%$q%")
                    ->orWhere('calificaciones_chofer.comentario', 'like', "%$q%");
            });
        }


        if ($request->estrellas) {
            $query->where('calificaciones_chofer.estrellas', $request->estrellas);
        }

        if ($request->fecha) {
            $query->whereDate('calificaciones_chofer.created_at', $request->fecha);
        }


        $comentarios = $query
            ->orderBy('calificaciones_chofer.created_at', 'desc')
            ->paginate($request->per_page ?? 10)
            ->appends($request->all());

        return view('admin.calificaciones.index', compact('comentarios'));
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

