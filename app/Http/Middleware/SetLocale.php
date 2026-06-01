<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
     // Lista de idiomas permitidos
        $allowed = ['en','fr','es'];

        // 1️⃣ Si viene un query string ?lang=fr (o desde form POST con name=lang)
        if ($request->has('lang') && in_array($request->get('lang'), $allowed)) {
            Session::put('locale', $request->get('lang'));
        }

        // 2️⃣ Si ya hay idioma guardado en sesión, usarlo
        if (Session::has('locale') && in_array(Session::get('locale'), $allowed)) {
            App::setLocale(Session::get('locale'));
        } else {
            // 3️⃣ Si no hay idioma en sesión, usar inglés por defecto
            App::setLocale('en');
            Session::put('locale', 'en');
        }

        return $next($request);
    }
}