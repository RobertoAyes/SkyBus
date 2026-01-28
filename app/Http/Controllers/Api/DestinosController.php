<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DestinosController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::with(['lugares', 'comidas'])->get();

        if ($departamentos->isEmpty()) {
            return response()->json([
                "error" => "No hay departamentos registrados"
            ], 200);
        }

        $data = [];

        foreach ($departamentos as $dep) {

            $imagenDep = $dep->imagen
                ? url($dep->imagen)
                : url("/catalago/img/default.jpg");

            $data[$dep->nombre] = [
                'imagen' => $imagenDep,

                'lugares' => $dep->lugares->map(fn($l) => [
                    'nombre' => $l->nombre,
                    'imagen' => url($l->imagen)
                ]),

                'comidas' => $dep->comidas->map(fn($c) => [
                    'nombre' => $c->nombre,
                    'imagen' => url($c->imagen)
                ]),
            ];
        }

        return response()->json($data);
    }

}
