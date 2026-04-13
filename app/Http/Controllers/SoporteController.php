<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SolicitudSoporte;

class SoporteController extends Controller
{
    // ===============================
    // CHOFER: Historial de solicitudes
    // ===============================
    public function indexChofer(Request $request)
    {
        $query = SolicitudSoporte::where('chofer_id', Auth::id());

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $solicitudes = $query->latest()->paginate(10);

        return view('chofer.soporte.indexChofer', compact('solicitudes'));
    }

    // ===============================
    // CHOFER: Crear nueva solicitud
    // ===============================
    public function crear()
    {
        return view('chofer.soporte.create');
    }

    // ===============================
    // CHOFER: Guardar solicitud
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required'
        ]);

        SolicitudSoporte::create([
            'chofer_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => 'pendiente'
        ]);

        return redirect()
            ->route('chofer.soporte.index')
            ->with('success', 'Solicitud enviada correctamente');

    }

    // ===============================
    // ADMIN: Ver todas las solicitudes
    // ===============================
    public function indexAdmin(Request $request)
    {
        $query = SolicitudSoporte::with('chofer');

        // BUSQUEDA
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        //  FILTRO ESTADO
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        //  FILTRO FECHA
        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        //  CANTIDAD DE REGISTROS
        $perPage = $request->get('per_page', 5);

        $solicitudes = $query
            ->latest()
            ->paginate($perPage)
            ->appends($request->all());

        return view('admin.soportes', compact('solicitudes'));
    }
}
