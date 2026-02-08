<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuario = Auth::user();

        $extras = $usuario->extras()->paginate(10);

        return view('servicios_adicionales.servicios_adicionales-index', compact('extras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = Auth::user();
        $fecha_hoy = date("Y-m-d");
        $reservas = $usuario->reservas()->where('fecha_reserva', '>=', $fecha_hoy)->get();

        return view('servicios_adicionales.servicios_adicionales-create', compact('reservas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $servicios = new Extra();
        $servicios->user_id = Auth::id();
        $servicios->reserva_id = $request->input('reserva_id');
        $servicios->manta = $request->has('manta');
        $servicios->orejeras = $request->has('orejeras');
        $servicios->refrescos = $request->has('refrescos');
        $servicios->snack = $request->has('snack');
        $servicios->cafe = $request->has('cafe');
        $servicios->almohada = $request->has('almohada');
        $servicios->fecha = date('Y-m-d');
        if ($servicios->save()) {
            return redirect()->route('servicios_adicionales.index')->with('success', 'Los servicios adicionales fueron agregados con éxito.');
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
