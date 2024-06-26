<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Prevent caching sensitive pages
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}