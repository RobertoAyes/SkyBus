<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;

class PerfilChoferController extends Controller
{
    public function verPerfil()
    {
        $usuario = auth()->user();

        if (strtolower($usuario->role) !== 'chofer') {
            abort(403);
        }

        $chofer = Empleado::where('email', $usuario->email)->firstOrFail();

        return view('PerfilChofer.perfil', compact('chofer', 'usuario'));
    }
}
