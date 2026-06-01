<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuscripcionActiva
{
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->tieneSuscripcionActiva()) {
            return redirect('/planes');
        }

        return $next($request);
    }
}

