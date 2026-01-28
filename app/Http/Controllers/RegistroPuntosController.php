<?php

namespace App\Http\Controllers;

use App\Models\RegistrarPuntos;
use App\Models\Reserva;
use App\Models\CanjeBeneficio;
use App\Models\CanjeRealizado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroPuntosController extends Controller
{
    // MÉTODO EXISTENTE - NO MODIFICAR
    public function create($reserva_id)
    {
        $reserva = Reserva::findOrFail($reserva_id);

        if ($reserva->estado !== 'confirmada') {
            return redirect()->route('cliente.historial')
                ->with('error', 'No puedes registrar puntos porque la reserva no está confirmada.');
        }

        return view('puntos.create', compact('reserva'));
    }

    // MÉTODO EXISTENTE - NO MODIFICAR
    public function store(Request $request, $reserva_id)
    {
        $request->validate([
            'puntos' => 'required|integer|min:1|max:10',
        ]);

        if (RegistrarPuntos::where('reserva_id', $reserva_id)->exists()) {
            return redirect()->back()->with('error', 'Los puntos ya fueron registrados para este viaje.');
        }

        RegistrarPuntos::create([
            'reserva_id' => $reserva_id,
            'usuario_id' => Auth::id(),
            'puntos' => $request->puntos,
        ]);

        return redirect()->route('cliente.historial')
            ->with('success', 'Puntos registrados correctamente.');
    }

    // NUEVO MÉTODO: Mostrar puntos y beneficios
    public function index()
    {
        $puntosTotales = RegistrarPuntos::where('usuario_id', Auth::id())->sum('puntos');
        $beneficios = CanjeBeneficio::where('activo', true)->get();
        $puntosRegistros = RegistrarPuntos::with('reserva.viaje')
            ->where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('puntos.index', compact('puntosTotales', 'beneficios', 'puntosRegistros'));
    }

    // NUEVO MÉTODO: Procesar canje de puntos
    public function canjear(Request $request, $beneficio_id)
    {
        $beneficio = CanjeBeneficio::findOrFail($beneficio_id);
        $puntosTotales = RegistrarPuntos::where('usuario_id', Auth::id())->sum('puntos');

        // VALIDAR PUNTOS SUFICIENTES
        if ($puntosTotales < $beneficio->puntos_requeridos) {
            return redirect()->route('puntos.index')
                ->with('error', 'No tienes puntos suficientes para canjear este beneficio. Necesitas ' . $beneficio->puntos_requeridos . ' puntos.');
        }

        // REGISTRAR EL CANJE
        CanjeRealizado::create([
            'usuario_id' => Auth::id(),
            'beneficio_id' => $beneficio->id,
            'puntos_usados' => $beneficio->puntos_requeridos,
        ]);

        return redirect()->route('puntos.index')
            ->with('success', '¡Beneficio canjeado exitosamente! Se descontaron ' . $beneficio->puntos_requeridos . ' puntos de tu saldo.');
    }
}
