<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    /**
     * Muestra el formulario de soporte/ayuda
     */
    public function index()
    {
        return view('ayuda.soporte');
    }

    /**
     * Almacena una nueva consulta
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string|max:1000'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'correo.required' => 'El correo es obligatorio',
            'correo.email' => 'El correo debe ser válido',
            'asunto.required' => 'El asunto es obligatorio',
            'mensaje.required' => 'El mensaje es obligatorio',
            'mensaje.max' => 'El mensaje no puede exceder 1000 caracteres'
        ]);

        try {
            Consulta::create([
                'user_id' => auth()->id(),
                'nombre_completo' => $request->nombre,
                'correo' => $request->correo,
                'asunto' => $request->asunto,
                'mensaje' => $request->mensaje
            ]);

            return redirect()->back()->with('success', '¡Consulta enviada exitosamente! Te responderemos pronto.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al enviar tu consulta. Intenta nuevamente.');
        }
    }

    /**
     * Lista todas las consultas (para panel admin)
     */
    public function listar(Request $request)
    {
        $query = Consulta::query();

        //  BUSQUEDA
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre_completo', 'like', "%{$buscar}%")
                    ->orWhere('asunto', 'like', "%{$buscar}%");
            });
        }

        //  FILTRO ESTADO
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        //  FILTRO POR FECHA
        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        //  PAGINACIÓN FIJA (5 REGISTROS)
        $perPage = $request->get('per_page', 5);

        $consultas = $query
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->all());

        return view('ayuda.consultas_admin', compact('consultas'));
    }

    /**
     * CONSULTAS DEL USUARIO (Mejorado: buscador, filtro fechas, paginación estilo extras)
     */
    public function misConsultas(Request $request)
    {
        // Permitir solo estos valores de paginación
        $allowedPerPage = [5, 10, 25, 50];
        $per_page = $request->input('per_page', 10);
        if (!in_array($per_page, $allowedPerPage)) {
            $per_page = 10;
        }

        $query = Consulta::where('user_id', auth()->id());

        // 🔍 Buscador
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('asunto', 'like', "%{$buscar}%")
                    ->orWhere('mensaje', 'like', "%{$buscar}%");
            });
        }

        // 📅 Filtro por fechas
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // 📄 Ordenar y paginar
        $consultas = $query->orderBy('created_at', 'desc')
            ->paginate($per_page)
            ->appends($request->all());

        return view('ayuda.indexh44', compact('consultas'));
    }

    /**
     * Responder consulta (admin)
     */
    public function responderConsulta(Request $request, $id)
    {
        $request->validate([
            'respuesta_admin' => 'required|string|max:2000',
        ]);

        $consulta = Consulta::findOrFail($id);
        $consulta->respuesta_admin = $request->respuesta_admin;
        $consulta->estado = 'Respondida';
        $consulta->save();

        return redirect()->back()->with('success', '¡Respuesta enviada correctamente!');
    }
}
/**
 * sirve
 */
