<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransitAgentAchat
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedRoles = ['responsable_finance', 'TransitAgent','super_admin_transit'];

        if (Auth::check() && in_array(Auth::user()->role, $allowedRoles)) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'You do not have  access.');
    }
}
