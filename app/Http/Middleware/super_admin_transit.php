<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class super_admin_transit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié et s'il a le rôle "TransitAgent"
        if (Auth::check() && Auth::user()->role === 'super_admin_transit') {
            return $next($request);
        }

        // Redirection si l'utilisateur n'est pas autorisé
        return redirect('/')->with('error', 'Accès refusé.');
    }
}
