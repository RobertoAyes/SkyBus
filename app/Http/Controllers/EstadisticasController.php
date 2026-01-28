<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        $query = User::query();

        if ($fechaInicio) {
            $query->whereDate('created_at', '>=', $fechaInicio);
        }
        $query->whereDate('created_at', '<=', $fechaFin);

        if ($tipoEstado && $tipoEstado !== 'todos') {
            $query->where('estado', $tipoEstado);
        }

        $usuarios = $query->get();

        $usuariosActivos = $usuarios->where('estado', 'activo')->count();
        $usuariosInactivos = $usuarios->where('estado', 'inactivo')->count();

        // Distribución de usuarios por rol
        $usuariosPorRol = $usuarios->groupBy('role')->map->count();

        // Detalle por rol y estado
        if ($tipoEstado === 'todos' || !$tipoEstado) {
            $detallePorRol = $usuarios->groupBy(['role', 'estado'])->map(function ($estados) {
                return $estados->map->count();
            });
        } else {
            $detallePorRol = $usuarios->groupBy('role')->map->count();
        }

        // Usuarios por fecha para el gráfico
        $usuariosPorFecha = $usuarios
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->map->count()
            ->sortKeys();

        return view('estadisticas.estadisticasHU46', compact(
            'usuariosActivos',
            'usuariosInactivos',
            'usuariosPorFecha',
            'detallePorRol',
            'usuariosPorRol',
            'periodo',
            'tipoEstado'
        ));
    }

    // Opcional: si necesitas un método separado para mostrar sin filtros
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

        return view('estadisticas.estadisticasHU46', compact(
            'usuariosActivos',
            'usuariosInactivos',
            'usuariosPorRol',
            'detallePorRol',
            'usuariosPorFecha'
        ));
    }
}


