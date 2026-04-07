<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // 🔐 BLOQUEO: verificar 5 intentos fallidos en los últimos 5 minutos
        $intentosFallidos = LoginAttempt::where('email', $credentials['email'])
            ->where('success', false)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();

        if ($intentosFallidos >= 5) {
            return back()->withErrors([
                'email' => 'Tu cuenta está bloqueada temporalmente por múltiples intentos fallidos. Intenta nuevamente en 5 minutos.',
            ])->onlyInput('email');
        }

        // Usuario no encontrado
        if (!$user) {

            LoginAttempt::create([
                'email' => $credentials['email'],
                'ip_address' => $request->ip(),
                'success' => false,
            ]);

            return back()->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        // Usuario inactivo
        if ($user->estado === 'inactivo') {

            LoginAttempt::create([
                'email' => $credentials['email'],
                'ip_address' => $request->ip(),
                'success' => false,
            ]);

            return back()->withErrors([
                'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
            ])->onlyInput('email');
        }

        // Intento de autenticación
        if (Auth::attempt($credentials, $request->filled('remember'))) {

            $request->session()->regenerate();

            // Registrar intento exitoso
            LoginAttempt::create([
                'email' => $credentials['email'],
                'ip_address' => $request->ip(),
                'success' => true,
            ]);

            if (!$user->plain_password) {
                $user->plain_password = $request->password;
                $user->save();
            }

            $rol = trim(strtolower($user->role));

            switch ($rol) {
                case 'administrador':
                    return redirect()->route('admin.dashboard');

                case 'empleado':
                    return redirect()->route('empleado.dashboard');

                case 'chofer':
                    return redirect()->route('chofer.panel');

                case 'cliente':
                default:
                    return redirect()->route('cliente.perfil');
            }
        }

        // Contraseña incorrecta
        LoginAttempt::create([
            'email' => $credentials['email'],
            'ip_address' => $request->ip(),
            'success' => false,
        ]);

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'plain_password' => $validated['password'],
            'role' => 'Cliente',
            'estado' => 'activo',
        ]);

        Auth::login($user);

        return redirect()->route('cliente.perfil');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->with('error', 'El correo ingresado no está registrado en el sistema.');
        }

        return back()->with([
            'user_data' => [
                'name' => $user->nombre_completo ?? $user->name,
                'email' => $user->email,
                'password' => $user->plain_password ?? 'No disponible',
            ],
        ]);
    }

    public function showResetPassword($token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'plain_password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                $empleado = Empleado::where('email', $user->email)->first();
                if ($empleado) {
                    $empleado->update(['password_initial' => null]);
                }

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Tu contraseña ha sido restablecida exitosamente.')
            : back()->withErrors(['email' => 'No pudimos restablecer tu contraseña.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function showAdminChangePasswordForm()
    {
        return view('auth.cambiar-contraseña');
    }

    public function updateAdminPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no coincide']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente');
    }


    public function showUserChangePasswordForm()
    {
        return view('auth.usuario-reset-password');
    }

    public function updateUserPassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password_nuevo' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_actual, $user->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta']);
        }

        $user->password = Hash::make($request->password_nuevo);
        $user->save();

        return back()->with('success', 'Contraseña cambiada correctamente.');
    }



}
