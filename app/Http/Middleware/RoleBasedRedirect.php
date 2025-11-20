<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleBasedRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if user is accessing admin panel but is not admin
            if ($request->is('dashboard-admin*') && $user->role !== 'admin') {
                return redirect('/dashboard-user');
            }

            // Check if user is accessing user panel but is admin
            if ($request->is('dashboard-user*') && $user->role === 'admin') {
                return redirect('/dashboard-admin');
            }
        }

        return $next($request);
    }
}
