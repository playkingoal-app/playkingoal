<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inscripcione;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
         $user = auth()->user();

    // para que en la ruta al tener checksuscripcion deje pasar el admin
    if ($user->hasRole('Administrador')) {
        return $next($request);
    }

    // Jugador necesita suscripción
    if ($user->hasRole('Jugador') && ! $user->tieneInscripcionActiva()) {
        return redirect('/subscriptions')
            ->with('warning', 'Debes activar tu suscripción');
    }

    return $next($request);
}
}