<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user is an admin and belongs to the HR department
        if ($user->role === 'admin' && $user->employe->Direction === 'RH') {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas accès à cette section.');
    }
}


