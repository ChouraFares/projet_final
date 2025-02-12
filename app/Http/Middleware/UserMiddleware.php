<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $allowedRoles = ['user', 'responsable_finance', 'admin_assurance', 'super_admin_transit', 'TransitAgent'];

        if (Auth::check() && in_array(Auth::user()->role, $allowedRoles)) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'You do not have user access.');
    }

}

