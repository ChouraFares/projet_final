<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAssurance
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['DirecteurGeneral','admin_assurance', 'responsable_finance', 'admin'])) {
            return $next($request);
        }
    
        return redirect('/')->with('error', 'Accès refusé.');
    }
    
    
}
