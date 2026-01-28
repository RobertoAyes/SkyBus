<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeConfig;
use App\Models\Beneficio;
use App\Models\Preparacion;

class HomeController extends Controller
{
    public function index()
    {
        $homeConfig = HomeConfig::first();
        $beneficios = Beneficio::all();
        $preparaciones = Preparacion::all();

        return view('interfaces.principal', compact('homeConfig', 'beneficios', 'preparaciones'));
    }
}
