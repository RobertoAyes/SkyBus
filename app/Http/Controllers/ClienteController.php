<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    // Perfil del cliente
    public function perfil()
    {
        $usuario = Auth::user();
        return view('cliente.perfil', compact('usuario'));
    }

    // Reservas del cliente
    public function reservas()
    {
        $usuario = Auth::user();
        // Aquí irán las reservas del usuario
        return view('cliente.reservas', compact('usuario'));
    }

    public function dashboard()
    {
        return view('usuarios.dashboard'); // o la ruta a tu Blade correspondiente
    }

    public function edit()
    {
        $usuario = Auth::user();
        return view('cliente.editPerfil', compact('usuario'));
    }

    public function update(Request $request)
    {
        $usuario = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($usuario->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ];

        $validatedData = $request->validate($rules);

        $usuario->name = $validatedData['name'];
        $usuario->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $usuario->password = Hash::make($validatedData['password']);
        }

        $usuario->save();

        return redirect()->route('cliente.perfil')->with('success', 'Tu perfil ha sido actualizado exitosamente.');
    }
}
