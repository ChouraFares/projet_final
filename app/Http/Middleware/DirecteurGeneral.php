<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DirecteurGeneral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user is an admin and belongs to the HR department
        if ($user->role === 'DirecteurGeneral' && $user->employe->Direction === 'DG') {
            return $next($request);
        }

        return redirect()->route('Directeur_General.dashboard')->with('error', 'Vous n\'avez pas accès à cette section.');
    }

}
