<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CalificacionChofer;

class CalificacionChoferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar formulario
    public function formulario()
    {
        return view('CalificacionChofer.calificarChofer');
    }

    // Guardar calificación
    public function guardar(Request $request)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:255',
            'mejoras' => 'required|string|max:255',
            'positivo' => 'required|string|max:255',
            'comportamientos' => 'required|string|max:255',
            'velocidad' => 'required|in:si,no',
            'seguridad' => 'required|in:si,no',
        ]);

        CalificacionChofer::create([
            'usuario_id' => null,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'mejoras' => $request->mejoras,
            'positivo' => $request->positivo,
            'comportamientos' => $request->comportamientos,
            'velocidad' => $request->velocidad,
            'seguridad' => $request->seguridad,
        ]);

        return redirect()->back()->with('success', '¡Tu calificación fue enviada exitosamente!');
    }

}


