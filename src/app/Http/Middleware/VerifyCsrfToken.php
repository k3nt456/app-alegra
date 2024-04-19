<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */

    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        # Si la respuesta tiene el código de estado 419, redirige a la URL anterior
        if ($response->status() == 419) {
            return redirect()->back();
        }

        return $response;
    }

    protected $except = [
        //
    ];
}
