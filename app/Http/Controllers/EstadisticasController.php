<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ItinerarioChofer;
use Carbon\Carbon;

class EstadisticasController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->input('periodo');
        $tipoEstado = $request->input('estado');

        $fechaInicio = null;
        $fechaFin = now()->toDateString();


        if ($periodo) {
            switch ($periodo) {
                case 'semana':
                    $fechaInicio = now()->subWeek()->toDateString();
                    break;
                case 'mes':
                    $fechaInicio = now()->subMonth()->toDateString();
                    break;
                case 'anio':
                    $fechaInicio = now()->subYear()->toDateString();
                    break;
            }
        }


        $queryUsuarios = User::query();
        if ($fechaInicio) {
            $queryUsuarios->whereDate('created_at', '>=', $fechaInicio);
        }
        $queryUsuarios->whereDate('created_at', '<=', $fechaFin);

        if ($tipoEstado && $tipoEstado !== 'todos') {
            $queryUsuarios->where('estado', $tipoEstado);
        }

        $usuarios = $queryUsuarios->get();

        $usuariosActivos = $usuarios->where('estado', 'activo')->count();
        $usuariosInactivos = $usuarios->where('estado', 'inactivo')->count();
        $usuariosPorRol = $usuarios->groupBy('role')->map->count();

        $detallePorRol = $usuarios->groupBy('role')->map(function ($roles) {
            return $roles->groupBy('estado')->map->count();
        });

        $usuariosPorFecha = $usuarios
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->map->count()
            ->sortKeys();


        $queryViajes = ItinerarioChofer::query();
        $queryViajes->where('estado_viaje', 'Finalizado');

        if ($fechaInicio) {
            $queryViajes->whereDate('hora_llegada', '>=', $fechaInicio);
        }
        $queryViajes->whereDate('hora_llegada', '<=', $fechaFin);

        $viajes = $queryViajes->get();
        $totalViajesFinalizados = $viajes->count();


        $viajesPorPeriodo = [];
        $labels = [];

        switch ($periodo) {
            case 'semana':

                for ($i = 6; $i >= 0; $i--) {
                    $fecha = now()->subDays($i);
                    $labels[] = $fecha->format('d M');
                    $cantidad = $viajes->filter(function ($v) use ($fecha) {
                        return $v->hora_llegada->format('Y-m-d') === $fecha->format('Y-m-d');
                    })->count();
                    $viajesPorPeriodo[] = $cantidad;
                }
                break;

            case 'mes':

                $start = Carbon::parse($fechaInicio);
                $end = Carbon::parse($fechaFin);
                for ($date = $start; $date->lte($end); $date->addDay()) {
                    $labels[] = $date->format('d M');
                    $cantidad = $viajes->filter(function ($v) use ($date) {
                        return $v->hora_llegada->format('Y-m-d') === $date->format('Y-m-d');
                    })->count();
                    $viajesPorPeriodo[] = $cantidad;
                }
                break;

            case 'anio':
            default:

                $start = Carbon::parse($fechaInicio);
                $end = Carbon::parse($fechaFin);
                $months = [];
                while ($start->lte($end)) {
                    $label = $start->format('M Y');
                    $labels[] = $label;
                    $cantidad = $viajes->filter(function ($v) use ($start) {
                        return $v->hora_llegada->format('Y-m') === $start->format('Y-m');
                    })->count();
                    $viajesPorPeriodo[] = $cantidad;
                    $start->addMonth();
                }
                break;
        }

        $viajesPorMes = [
            'labels' => $labels,
            'values' => $viajesPorPeriodo,
        ];

        return view('estadisticas.estadisticasHU46', compact(
            'usuariosActivos',
            'usuariosInactivos',
            'usuariosPorFecha',
            'detallePorRol',
            'usuariosPorRol',
            'periodo',
            'tipoEstado',
            'totalViajesFinalizados',
            'viajesPorMes'
        ));
    }

    public function mostrar()
    {
        $usuarios = User::all();

        $usuariosActivos = $usuarios->where('estado', 'activo')->count();
        $usuariosInactivos = $usuarios->where('estado', 'inactivo')->count();

        $usuariosPorRol = $usuarios->groupBy('role')->map->count();
        $detallePorRol = $usuarios->groupBy(['role', 'estado'])->map(function ($estados) {
            return $estados->map->count();
        });

        $usuariosPorFecha = $usuarios
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->map->count()
            ->sortKeys();

        $viajes = ItinerarioChofer::where('estado_viaje', 'Finalizado')->get();
        $totalViajesFinalizados = $viajes->count();


        $labels = [];
        $values = [];
        $hoy = now();
        for ($i = 11; $i >= 0; $i--) {
            $mes = $hoy->copy()->subMonths($i);
            $labels[] = $mes->format('M Y');
            $cantidad = $viajes->filter(function ($v) use ($mes) {
                return $v->hora_llegada->format('Y-m') === $mes->format('Y-m');
            })->count();
            $values[] = $cantidad;
        }

        $viajesPorMes = [
            'labels' => $labels,
            'values' => $values,
        ];

        return view('estadisticas.estadisticasHU46', compact(
            'usuariosActivos',
            'usuariosInactivos',
            'usuariosPorRol',
            'detallePorRol',
            'usuariosPorFecha',
            'totalViajesFinalizados',
            'viajesPorMes'
        ));
    }
}

