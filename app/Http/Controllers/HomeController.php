<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Torneo;
use App\Models\Inscripcione;

class HomeController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $inscripcionesPagadas = $user->inscripciones()
        ->where('estado_pago', 'activo')
        ->with('torneo')
        ->get();

    $inscripcionesPendientes = $user->inscripciones()
        ->where('estado_pago', 'pendiente')
        ->get();

    $torneos = \App\Models\Torneo::all();



   

    return view('home', compact(
        'user',
        'inscripcionesPagadas',
        'inscripcionesPendientes',
        'torneos'
      
      
    ));
}

}
