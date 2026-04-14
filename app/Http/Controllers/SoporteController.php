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
        $allowedPerPage = [5, 10, 25, 50];
        $per_page = $request->input('per_page', 10);

        if (!in_array($per_page, $allowedPerPage)) {
            $per_page = 10;
        }

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

        $solicitudes = $query->latest()
            ->paginate($per_page)
            ->appends($request->all());

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
    public function responderConsulta(Request $request, $id)
    {
        $request->validate([
            'respuesta_admin' => 'required|string',
        ]);

        $solicitud = SolicitudSoporte::findOrFail($id);
        $solicitud->respuesta_admin = $request->respuesta_admin;
        $solicitud->estado = 'resuelto';
        $solicitud->save();

        return back()->with('success', 'Respuesta enviada correctamente');
    }
    public function responder(Request $request, $id)
    {
        $request->validate([
            'respuesta_admin' => 'required'
        ]);

        $solicitud = SolicitudSoporte::findOrFail($id);

        $solicitud->respuesta_admin = $request->respuesta_admin;
        $solicitud->estado = 'resuelto';
        $solicitud->save();

        return back()->with('success', 'Respuesta enviada correctamente');
    }
}
