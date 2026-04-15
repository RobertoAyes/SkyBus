<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ciudad;
use App\Models\Ruta;
use App\Models\Viaje;
use App\Models\Asiento;
use App\Models\Reserva;

class ReservaController extends Controller
{
    // ❌ QUITADO middleware global auth
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create()
    {
        $ciudades = Ciudad::all();
        $rutas = Ruta::where('estado', true)->get();

        return view('cliente', compact('ciudades', 'rutas'));
    }

    // ✔ PÚBLICO (puede usarlo guest)
    public function buscar(Request $request)
    {
        $request->validate([
            'ruta_id' => 'required|exists:rutas,id',
            'fecha' => 'required|date'
        ]);

        $viajes = Viaje::with('ruta')
            ->where('ruta_id', $request->ruta_id)
            ->whereDate('fecha_hora_salida', $request->fecha)
            ->get();

        return response()->json($viajes->map(function ($v) {
            return [
                'id' => $v->id,
                'ruta' => [
                    'origen' => $v->ruta->origen ?? '',
                    'destino' => $v->ruta->destino ?? '',
                ],
                'fecha_hora_salida' => $v->fecha_hora_salida,
                'asientos_disponibles' => $v->asientosDisponibles() ?? 0,
            ];
        }));
    }

    // ✔ PÚBLICO (puede usarlo guest)
    public function asientos($viaje_id)
    {
        $viaje = Viaje::with('asientos')->findOrFail($viaje_id);

        return response()->json([
            'asientos' => $viaje->asientos->map(function ($a) {
                return [
                    'id' => $a->id,
                    'numero' => $a->numero,
                    'ocupado' => (bool) $a->ocupado,
                ];
            })
        ]);
    }

    // 🔒 SOLO AQUÍ SE EXIGE LOGIN
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'error' => 'UNAUTHENTICATED'
            ], 401);
        }

        try {

            $request->validate([
                'viaje_id' => 'required|exists:viajes,id',
                'asientos' => 'required|array|min:1|max:5',
                'asientos.*' => 'string'
            ]);

            $codigo = 'RES-' . now()->format('YmdHis');
            $userId = Auth::id();

            DB::beginTransaction();

            foreach ($request->asientos as $numeroAsiento) {

                $asiento = Asiento::where('viaje_id', $request->viaje_id)
                    ->where('numero', $numeroAsiento)
                    ->lockForUpdate()
                    ->first();

                if (!$asiento) {
                    DB::rollBack();
                    return response()->json([
                        'error' => "Asiento no existe: $numeroAsiento"
                    ], 404);
                }

                $yaReservado = Reserva::where('viaje_id', $request->viaje_id)
                    ->whereHas('asiento', function ($q) use ($numeroAsiento) {
                        $q->where('numero', $numeroAsiento);
                    })
                    ->exists();

                if ($yaReservado) {
                    DB::rollBack();
                    return response()->json([
                        'error' => "Asiento ya reservado: $numeroAsiento"
                    ], 409);
                }

                Reserva::create([
                    'user_id' => $userId,
                    'viaje_id' => $request->viaje_id,
                    'asiento_id' => $asiento->id,
                    'codigo_reserva' => $codigo,
                    'fecha_reserva' => now(),
                    'estado' => 'confirmada',
                ]);

                $asiento->update(['ocupado' => 1]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'codigo_reserva' => $codigo,
                'total_asientos' => count($request->asientos)
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Error interno en servidor',
                'debug' => $e->getMessage()
            ], 500);
        }
    }
}
