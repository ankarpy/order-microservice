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
            throw new AuthenticationException('Wrong API key provided');
        }

        return $next($request);
    }
}
