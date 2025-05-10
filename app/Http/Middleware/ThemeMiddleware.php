<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        view()->share('theme', [
            'default' => config('theme.default'),
            'frontend' => config('theme.frontend'),
            'backend' => config('theme.backend'),
        ]);
        return $next($request);
    }
}
