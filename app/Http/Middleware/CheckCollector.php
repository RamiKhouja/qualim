<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCollector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user's role is "collecteur" (collector)
        if (Auth::check() && Auth::user()->role === 'collecteur') {
            return $next($request);
        }

        // Redirect or throw an unauthorized exception, whichever is suitable for your application
        return redirect()->route('dashboard')->with('error', 'Vous n\'êtes pas autorisé à acceder cette page.');
    }
}
