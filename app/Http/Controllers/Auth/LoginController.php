<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empleado;
use App\Models\LoginAttempt;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Número máximo de intentos fallidos permitidos
     */
    protected function maxAttempts()
    {
        return 5;
    }

    /**
     * Minutos que el usuario permanecerá bloqueado
     */
    protected function decayMinutes()
    {
        return 5;
    }

    /**
     * Sobrescribimos el login para registrar intentos
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Verificar si excede intentos
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            // Registrar intento exitoso
            LoginAttempt::create([
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'success' => true,
            ]);

            return $this->sendLoginResponse($request);
        }

        // Incrementar intentos fallidos
        $this->incrementLoginAttempts($request);

        // Registrar intento fallido
        LoginAttempt::create([
            'email' => $request->email,
            'ip_address' => $request->ip(),
            'success' => false,
        ]);

        return $this->sendFailedLoginResponse($request);
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

            if ($rol === 'chofer') {
                return redirect()->route('chofer.panel');
            }
        }

        $rolUser = strtolower($user->role);

        if ($rolUser === 'administrador') {
            return redirect()->to('/admin/pagina');
        }

        if ($rolUser === 'empleado') {
            return redirect()->route('empleado.dashboard');
        }

        if ($rolUser === 'chofer') {
            return redirect()->route('chofer.panel');
        }

        return redirect()->route('cliente.perfil');
    }

    /**
     * Mensaje cuando falla login
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Credenciales incorrectas.',
            ]);
    }
}
