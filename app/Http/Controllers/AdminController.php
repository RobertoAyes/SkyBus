<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard del administrador
    public function dashboard()
    {
        $totalUsuarios = User::where('role', 'cliente')->count();
        $usuariosActivos = User::where('role', 'cliente')->where('estado', 'activo')->count();
        $usuariosInactivos = User::where('role', 'cliente')->where('estado', 'inactivo')->count();

        return view('admin.dashboard', compact('totalUsuarios', 'usuariosActivos', 'usuariosInactivos'));
    }

    // HU24: Listado de usuarios para validación - ACTUALIZADO
    public function usuarios()
    {
        // CAMBIO: Ahora muestra TODOS los usuarios (clientes, empleados, admins)
        $usuarios = User::all();

        // Si solo quieres mostrar clientes, usa:
        // $usuarios = User::where('role', 'cliente')->get();

        return view('admin.usuarios', compact('usuarios'));
    }

    // HU24: Cambiar estado del usuario (activo/inactivo)
    public function cambiarEstado(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        // Cambiar el estado
        $nuevoEstado = $usuario->estado === 'activo' ? 'inactivo' : 'activo';
        $usuario->estado = $nuevoEstado;
        $usuario->save();

        return redirect()->route('admin.usuarios')->with('success', "Usuario {$usuario->name} ahora está {$nuevoEstado}");
    }

    public function index()
    {
        $estadisticas = User::where('role', 'Chofer')
            ->withCount('calificacionesRecibidas')
            ->withAvg('calificacionesRecibidas', 'estrellas')
            ->get();

        return view('admin.calificaciones.index', compact('estadisticas'));
    }

}
