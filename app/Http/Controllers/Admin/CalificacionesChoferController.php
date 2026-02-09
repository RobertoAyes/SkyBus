<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalificacionChofer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CalificacionesChoferController extends Controller
{
    public function index()
    {
        $estadisticas = User::where('role', 'Chofer')
            ->withCount('calificaciones')
            ->withAvg('calificaciones', 'estrellas')
            ->get();

        return view('admin.calificaciones.index', compact('estadisticas'));
    }
}

