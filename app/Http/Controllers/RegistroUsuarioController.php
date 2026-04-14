<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegistroUsuarioController extends Controller
{
    // ─── Helpers ──────────────────────────────────────────────
    private function validarPerPage($value): int
    {
        return in_array((int)$value, [5, 10, 25, 50]) ? (int)$value : 10;
    }

    // ─── Index ───
    public function index(Request $request)
    {
        $perPage = $this->validarPerPage($request->input('per_page', 10));
        $search  = $request->input('search');

        $usuarios = Usuario::query()
            ->when($search, fn($q) =>
            $q->where(fn($q2) =>
            $q2->where('nombre_completo', 'like', "%{$search}%")
                ->orWhere('email',          'like', "%{$search}%")
                ->orWhere('dni',            'like', "%{$search}%")
            )
            )
            ->paginate($perPage)
            ->appends($request->only(['search', 'per_page'])); // ✅ Fix: mantiene filtros en paginación

        return view('usuarios.index', compact('usuarios'));
    }

    // ─── Create ───────────────────────────────────────────────
    public function create()
    {
        return view('Vista_registro.create');
    }

    // ─── Store ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'dni'             => 'required|numeric|digits:13|unique:usuarios,dni|unique:users,dni',
            'email'           => 'required|email|unique:usuarios,email|unique:users,email',
            'telefono'        => 'required|numeric|digits:8',
            'password'        => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $usuario = Usuario::create([
                'nombre_completo' => $request->nombre_completo,
                'dni'             => $request->dni,
                'email'           => $request->email,
                'telefono'        => $request->telefono,
                'password'        => Hash::make($request->password),
            ]);

            User::create([
                'name'     => $usuario->nombre_completo,
                'email'    => $usuario->email,
                'password' => Hash::make($request->password),
                'dni'      => $usuario->dni,
                'telefono' => $usuario->telefono,
                'role'     => 'cliente',
                'estado'   => 'activo',
            ]);
        });

        return redirect()->back()
            ->with('success', 'Usuario registrado correctamente. Ya puedes iniciar sesión.');
    }

    // ─── Show ─────────────────────────────────────────────────
    public function show(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    // ─── Consultar ────
    public function consultar(Request $request)
    {
        $perPage = $this->validarPerPage($request->input('per_page', 10));
        $search  = $request->input('search');

        $usuarios = Usuario::query()
            ->leftJoin('users', 'usuarios.email', '=', 'users.email')
            ->select('usuarios.*', 'users.role as rol', 'users.estado')
            ->when($search, fn($q) =>
            $q->where(fn($q2) =>
            $q2->where('usuarios.nombre_completo', 'like', "%{$search}%")
                ->orWhere('usuarios.email',         'like', "%{$search}%")
                ->orWhere('usuarios.dni',           'like', "%{$search}%")
            )
            )
            ->when($request->filled('dni'), fn($q) =>

            $q->where('usuarios.dni', 'like', '%' . $request->dni . '%')
            )
            ->when($request->filled('estado'), fn($q) =>
            $q->where('users.estado', $request->estado)
            )
            ->when($request->filled('fecha_registro'), fn($q) =>
            $q->whereDate('usuarios.created_at', $request->fecha_registro)
            )
            ->paginate($perPage)
            ->appends($request->only(['search', 'dni', 'estado', 'fecha_registro', 'per_page']));

        return view('usuarios.consultar', compact('usuarios'));
    }

    // ─── Edit ──
    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.Editar', compact('usuario'));
    }

    // ─── Update ───
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $emailOriginal = $usuario->email;

        $request->validate([
            'nombre_completo' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'dni'             => ['required', 'numeric', 'digits:13',
                Rule::unique('usuarios', 'dni')->ignore($usuario->id),
                Rule::unique('users',    'dni')->ignore($usuario->id, 'id')],
            'email'           => ['required', 'email',
                Rule::unique('usuarios', 'email')->ignore($usuario->id),
                Rule::unique('users',    'email')->ignore($usuario->id, 'id')],
            'telefono'        => 'required|numeric|digits:8',
            'password'        => 'nullable|string|min:8|confirmed',
            'estado'          => 'required|in:activo,inactivo',
        ]);

        DB::transaction(function () use ($request, $usuario, $emailOriginal) {
            $usuario->nombre_completo = $request->nombre_completo;
            $usuario->dni             = $request->dni;
            $usuario->email           = $request->email;
            $usuario->telefono        = $request->telefono;

            if ($request->filled('password')) {
                $usuario->password = Hash::make($request->password); // Hash::make()
            }

            $usuario->save();

            $user = User::where('email', $emailOriginal)->first();

            if ($user) {
                $user->name   = $usuario->nombre_completo;
                $user->email  = $usuario->email;
                $user->dni    = $usuario->dni;
                $user->estado = $request->estado;

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }

                $user->save();
            }
        });

        return redirect()->route('usuarios.consultar')
            ->with('success', 'Usuario actualizado exitosamente.');
    }
}
