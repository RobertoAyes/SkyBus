<?php

namespace App\Http\Controllers;

use App\Models\RegistroRenta;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon; // Importamos Carbon para calcular la duración del viaje

class RegistroRentaController extends Controller
{
    /**
     * Muestra la lista de todas las rentas.
     */

        public function index()
    {
        // Obtiene las rentas paginadas para el listado
        $rentas = RegistroRenta::orderBy('id', 'desc')->paginate(5);
        return view('rentas.index', compact('rentas'));
    }
    /**
     * Muestra el formulario para crear una nueva renta.
     */
    public function create()
    {
        return view('rentas.create');
    }

    /**
     * Almacena una nueva renta en la base de datos.
     * Se asegura de calcular y guardar el total_tarifa.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'email_cliente' => 'nullable|email|max:255',
            'dni_cliente' => 'required|string|max:20|regex:/^[a-zA-Z0-9]+$/',
            'tipo_evento' => 'required|string|max:50',
            'destino' => 'required|string|max:255',
            'punto_partida' => 'required|string|max:255',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tarifa' => 'required|numeric|min:0.01',
            'descuento_valor' => 'nullable|numeric|min:0|max:100',
            'anticipo' => 'nullable|numeric|min:0',
            'num_pasajeros_confirmados' => 'nullable|integer|min:0|max:500',
            'num_pasajeros_estimados' => 'nullable|integer|min:1|max:500',
            'hora_salida' => 'nullable|date_format:H:i',
            'hora_retorno' => 'nullable|date_format:H:i',
        ]);

        try {
            DB::beginTransaction();

            // --- CREAR O BUSCAR CLIENTE ---
            $cliente = Usuario::firstOrCreate(
                ['dni' => $data['dni_cliente']],
                [
                    'nombre_completo' => $data['nombre_cliente'],
                    'email' => $data['email_cliente'] ?? 'temp' . Str::random(6) . '@bustrak.test',
                    'telefono' => '00000000',
                    'password' => Hash::make(Str::random(12)),
                ]
            );

            // --- CALCULAR TOTALES ---
            $tarifa = $data['tarifa'];
            $descuentoPorcentaje = $data['descuento_valor'] ?? 0;

            // 1. Calcular Monto de Descuento
            $descuentoMonto = $tarifa * ($descuentoPorcentaje / 100);

            // 2. Calcular Total Tarifa (Costo Base - Descuento)
            $totalCalculado = $tarifa - $descuentoMonto;

            // --- CREAR RENTA ---
            $renta = RegistroRenta::create([
                'codigo_renta' => 'RNT-' . Str::upper(Str::random(8)),
                'usuario_id' => $cliente->id,
                'nombre_completo' => $cliente->nombre_completo,
                'tipo_evento' => $data['tipo_evento'],
                'destino' => $data['destino'],
                'punto_partida' => $data['punto_partida'],
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_fin' => $data['fecha_fin'],
                'num_pasajeros_confirmados' => $data['num_pasajeros_confirmados'] ?? 0,
                'num_pasajeros_estimados' => $data['num_pasajeros_estimados'] ?? 0,
                'hora_salida' => $data['hora_salida'] ?? null,
                'hora_retorno' => $data['hora_retorno'] ?? null,
                'tarifa' => $tarifa,
                'descuento' => $descuentoMonto,
                'total_tarifa' => $totalCalculado, // Guarda el total calculado
                'anticipo' => $data['anticipo'] ?? 0,
                'penalizacion' => 0, // Inicializar la penalización
            ]);

            DB::commit();

            return redirect()->route('rentas.index')
                ->with('success', 'Renta registrada correctamente. Cliente: ' . $cliente->nombre_completo);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['general' => 'Error al guardar la renta: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Muestra el formulario para editar una renta existente.
     */
    public function edit(RegistroRenta $renta)
    {
        return view('rentas.edit', compact('renta'));
    }

    /**
     * Actualiza una renta existente en la base de datos.
     * Se asegura de recalcular y guardar el total_tarifa.
     */
    public function update(Request $request, RegistroRenta $renta)
    {
        $data = $request->validate([
            'tipo_evento' => 'required|string|max:50',
            'destino' => 'required|string|max:255',
            'punto_partida' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'num_pasajeros_confirmados' => 'nullable|integer|min:0|max:500',
            'num_pasajeros_estimados' => 'nullable|integer|min:1|max:500',
            'tarifa' => 'required|numeric|min:0.01',
            'descuento_valor' => 'nullable|numeric|min:0', // Descuento en % (valor)
            'anticipo' => 'nullable|numeric|min:0',
            'hora_salida' => 'nullable|date_format:H:i',
            'hora_retorno' => 'nullable|date_format:H:i',
            'penalizacion' => 'nullable|numeric|min:0', // Aseguramos que se pueda actualizar la penalización
        ]);

        // --- RECALCULAR TOTALES ---
        $tarifa = $data['tarifa'];
        $descuentoPorcentaje = $data['descuento_valor'] ?? 0;

        // 1. Calcular Monto de Descuento
        $descuentoMonto = ($tarifa * $descuentoPorcentaje) / 100;

        // 2. Calcular Total Tarifa (Costo Base - Descuento)
        $data['descuento'] = $descuentoMonto;
        $data['total_tarifa'] = $tarifa - $descuentoMonto; // Guarda el nuevo total

        $renta->update($data);

        return redirect()->route('rentas.index')->with('success', 'Renta actualizada correctamente.');
    }

    /**
     * Elimina una renta de la base de datos.
     */
    public function destroy(RegistroRenta $renta)
    {
        $renta->delete();
        return redirect()->route('rentas.index')->with('success', 'Renta eliminada correctamente.');
    }
}
