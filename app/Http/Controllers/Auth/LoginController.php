<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empleado;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirige al usuario según su rol
     */
    protected function authenticated(Request $request, $user)
    {
        $empleado = Empleado::where('email', $user->email)->first();

        if ($empleado) {
            $rol = strtolower($empleado->rol);

            if ($rol === 'administrador') {
                return redirect()->to('/admin/pagina');
            }

            if ($rol === 'empleado') {
                return redirect()->route('empleado.dashboard');
            }
        }

        $rolUser = strtolower($user->role);

        if ($rolUser === 'administrador') {
            // Redirige a la vista con el layout que mencionaste
            return redirect()->to('/admin/pagina');
        }

        if ($rolUser === 'empleado') {
            return redirect()->route('empleado.dashboard');
        }

        return redirect()->route('cliente.perfil');
    }
}
