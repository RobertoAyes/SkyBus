<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegistroUsuarioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // ✅ VALIDACIÓN SEGURA DE per_page
        $perPage = $request->input('per_page', 10);
        if (!in_array($perPage, [5, 10, 25, 50])) {
            $perPage = 10;
        }

        $usuarios = Usuario::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre_completo', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('dni', 'like', "%{$search}%");
                });
            })
            ->paginate($perPage);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('Vista_registro.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'dni' => 'required|numeric|digits:13|unique:usuarios,dni',
            'email' => 'required|email|unique:usuarios,email|unique:users,email',
            'telefono' => 'required|numeric|digits:8',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = new Usuario();
        $usuario->nombre_completo = $request->nombre_completo;
        $usuario->dni = $request->dni;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        User::create([
            'name' => $usuario->nombre_completo,
            'email' => $usuario->email,
            'password' => Hash::make($request->password),
            'dni' => $usuario->dni,
            'telefono' => $usuario->telefono,
            'role' => 'cliente',
            'estado' => 'activo',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Usuario registrado correctamente. Ya puedes iniciar sesión.');
    }

    public function show(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    public function consultar(Request $request)
    {
        $search = $request->input('search');

        // ✅ VALIDACIÓN SEGURA DE per_page
        $perPage = $request->input('per_page', 10);
        if (!in_array($perPage, [5, 10, 25, 50])) {
            $perPage = 10;
        }

        $usuarios = Usuario::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('usuarios.nombre_completo', 'like', "%{$search}%")
                        ->orWhere('usuarios.email', 'like', "%{$search}%")
                        ->orWhere('usuarios.dni', 'like', "%{$search}%");
                });
            })
            ->join('users', 'usuarios.email', '=', 'users.email')
            ->select(
                'usuarios.*',
                'users.role as rol',
                'users.estado'
            );

        if ($request->filled('dni')) {
            $usuarios->where('usuarios.dni', 'like', '%' . $request->dni . '%');
        }

        if ($request->filled('estado')) {
            $usuarios->where('users.estado', $request->estado);
        }

        if ($request->filled('fecha_registro')) {
            $usuarios->whereDate('usuarios.created_at', $request->fecha_registro);
        }

        $usuarios = $usuarios->paginate($perPage)->appends($request->all());

        return view('usuarios.consultar', compact('usuarios'));
    }

    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.Editar', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $originalEmail = $usuario->email;

        $request->validate([
            'nombre_completo' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'dni' => ['required', 'numeric', 'digits:13', Rule::unique('usuarios', 'dni')->ignore($usuario->id)],
            'email' => ['required', 'email', Rule::unique('usuarios', 'email')->ignore($usuario->id)],
            'telefono' => 'required|numeric|digits:8',
            'password' => 'nullable|string|min:8|confirmed',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $usuario->nombre_completo = $request->nombre_completo;
        $usuario->dni = $request->dni;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;

        if ($request->filled('password')) {
            $usuario->password = $request->password;
        }

        $usuario->save();

        $user = User::where('email', $originalEmail)->first();
        if ($user) {
            $user->name = $usuario->nombre_completo;
            $user->email = $usuario->email;
            $user->estado = $request->estado;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
        }

        return redirect()->route('usuarios.consultar')
            ->with('success', 'Usuario actualizado exitosamente.');
    }
}
