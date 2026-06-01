<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectCountry
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('country_code')) {

            try {

                $location = geoip($request->ip());

                session([
                    'country_code' => $location->iso_code ?? 'FR',
                ]);

            } catch (\Throwable $e) {

                session([
                    'country_code' => 'FR',
                ]);
            }
        }

        return $next($request);
    }
}