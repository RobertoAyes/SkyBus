<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /**
     * Muestra el formulario de recuperación de contraseña
     */
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Busca el usuario por email y devuelve sus datos para modal
     */
    public function sendReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.'
        ]);

        // Buscar en tabla users
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->with('error', 'El correo ingresado no está registrado en el sistema.');
        }

        // Devolver con datos para modal
        return back()->with([
            'user_data' => [
                'name' => $user->nombre_completo ?? $user->name,
                'email' => $user->email,
                'password' => $user->plain_password ?? 'No disponible',
            ],
        ]);
    }
}
