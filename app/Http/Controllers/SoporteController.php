<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudSoporte;
use Illuminate\Support\Facades\Auth;

class SoporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('chofer.soporte.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        SolicitudSoporte::create([
            'chofer_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('soporte.create')->with('success', 'Solicitud enviada correctamente.');
    }

    public function index()
    {
        $solicitudes = SolicitudSoporte::where('chofer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('chofer.soporte.index', compact('solicitudes'));
    }
}
