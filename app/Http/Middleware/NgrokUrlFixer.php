<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class NgrokUrlFixer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (str_contains($request->getHost(), 'ngrok-free.app') || str_contains($request->getHost(), 'ngrok.io')) {
            URL::forceScheme('https');
            // Optional: forceRootUrl if assets are still not loading correctly
            // URL::forceRootUrl($request->root());
        }

        return $next($request);
    }
}