<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmpleadoController extends Controller
{
    /* ===================== DASHBOARDS ===================== */

    public function dashboardEmpleado()
    {
        $user = auth()->user();

        if ($user->role !== 'Empleado') {
            abort(403);
        }

        return view('empleados.dashboard');
    }

    public function dashboardChofer()
    {
        if (auth()->user()->role !== 'Chofer') {
            abort(403);
        }

        return view('chofer.dashboard');
    }

    /* ===================== LISTADO ===================== */

    public function index(Request $request)
    {
        $query = Empleado::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(fn($q) =>
            $q->where('nombre', 'like', "%$buscar%")
                ->orWhere('apellido', 'like', "%$buscar%")
                ->orWhere('cargo', 'like', "%$buscar%")
            );
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        $empleados = $query->orderBy('nombre')->paginate(10);

        return view('empleados.index_hu5', compact('empleados'));
    }

    /* ===================== CREAR ===================== */

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u'
            ],

            'apellido' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u'
            ],

            'dni' => [
                'required',
                'digits:13',
                'unique:empleados,dni'
            ],

            'cargo' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u'
            ],

            'fecha_ingreso' => [
                'required',
                'date'
            ],

            'rol' => [
                'required',
                'in:Empleado,Administrador,Chofer'
            ],

            // Opcional, pero máximo 2 MB
            'foto' => [
                'nullable',
                'image',
                'max:2048'
            ],

        ], [

            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser texto.',
            'apellido.max' => 'El apellido no puede superar los 255 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',

            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe contener exactamente 13 números.',
            'dni.unique' => 'El DNI ingresado ya está registrado.',

            'cargo.required' => 'El cargo es obligatorio.',
            'cargo.string' => 'El cargo debe ser texto.',
            'cargo.max' => 'El cargo no puede superar los 255 caracteres.',
            'cargo.regex' => 'El cargo solo puede contener letras y espacios.',

            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.date' => 'La fecha de ingreso no es válida.',

            'rol.required' => 'Debe seleccionar un rol.',
            'rol.in' => 'El rol seleccionado no es válido.',

            'foto.image' => 'El archivo seleccionado debe ser una imagen.',
            'foto.max' => 'La imagen no debe pesar más de 2 MB.',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('empleados', 'public');
        }

        $baseEmail = strtolower($request->nombre . '.' . $request->apellido);

        $email = $baseEmail . '@bustrak.com';

        $i = 1;

        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . $i . '@bustrak.com';
            $i++;
        }

        $password = Str::random(8);

        $empleado = Empleado::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'cargo' => $request->cargo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'rol' => $request->rol,
            'estado' => 'Activo',
            'foto' => $foto,
            'email' => $email,
            'password_initial' => $password,
        ]);

        User::create([
            'name' => "{$empleado->nombre} {$empleado->apellido}",
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $empleado->rol,
            'estado' => 'activo',
        ]);

        return redirect()->route('empleados.hu5')
            ->with(
                'success',
                "Empleado registrado | Email: $email | Contraseña: $password"
            );
    }

    /* ===================== ACTIVAR / DESACTIVAR ===================== */

    public function guardarDesactivacion(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'motivo_baja' => 'required'
        ]);

        $empleado->update([
            'estado' => 'Inactivo',
            'motivo_baja' => $request->motivo_baja,
            'fecha_desactivacion' => Carbon::now(),
        ]);

        User::where('email', $empleado->email)
            ->update(['estado' => 'inactivo']);

        return back()->with('success', 'Empleado desactivado');
    }

    public function activar($id)
    {
        $empleado = Empleado::findOrFail($id);

        $empleado->update([
            'estado' => 'Activo',
            'motivo_baja' => null,
            'fecha_desactivacion' => null,
        ]);

        User::where('email', $empleado->email)
            ->update(['estado' => 'activo']);

        return back()->with('success', 'Empleado activado');
    }

    public function perfil()
    {
        $user = auth()->user();

        return view('empleados.perfil', compact('user'));
    }

    /* ===================== ACTUALIZAR ===================== */

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u'
            ],

            'apellido' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u'
            ],

            'dni' => [
                'required',
                'digits:13',
                'unique:empleados,dni,' . $empleado->id
            ],

            'cargo' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u'
            ],

            'fecha_ingreso' => [
                'required',
                'date'
            ],

            'rol' => [
                'required',
                'string'
            ],

            'estado' => [
                'required',
                'string'
            ],

            // Opcional, pero máximo 2 MB
            'foto' => [
                'nullable',
                'image',
                'max:2048'
            ],

        ], [

            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser texto.',
            'apellido.max' => 'El apellido no puede superar los 255 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',

            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe contener exactamente 13 números.',
            'dni.unique' => 'El DNI ingresado ya está registrado.',

            'cargo.required' => 'El cargo es obligatorio.',
            'cargo.string' => 'El cargo debe ser texto.',
            'cargo.max' => 'El cargo no puede superar los 255 caracteres.',
            'cargo.regex' => 'El cargo solo puede contener letras y espacios.',

            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.date' => 'La fecha de ingreso no es válida.',

            'rol.required' => 'Debe seleccionar un rol.',

            'estado.required' => 'El estado es obligatorio.',

            'foto.image' => 'El archivo seleccionado debe ser una imagen.',
            'foto.max' => 'La imagen no debe pesar más de 2 MB.',
        ]);

        $empleado->nombre = $request->nombre;
        $empleado->apellido = $request->apellido;
        $empleado->dni = $request->dni;
        $empleado->cargo = $request->cargo;
        $empleado->fecha_ingreso = $request->fecha_ingreso;
        $empleado->rol = $request->rol;
        $empleado->estado = $request->estado;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('empleados', 'public');
            $empleado->foto = $path;
        }

        $empleado->save();

        return redirect()->route('empleados.hu5')
            ->with('success', 'Empleado actualizado correctamente.');
    }
}

