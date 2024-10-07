<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request); // Lanjutkan ke halaman admin
        }

        // Redirect ke dashboard user jika bukan admin
        return redirect()->route('user.dashboard')->with('error', 'Access denied. Admins only.');
    }
}
