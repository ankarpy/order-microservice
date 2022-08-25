<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class ApiKeyMiddleware
{
    /**
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if(!$key = $request->post('apikey') or $key !== config('app.api_key')) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return $next($request);
    }
}
