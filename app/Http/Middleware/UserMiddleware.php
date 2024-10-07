<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Cek apakah pengguna yang login adalah 'kantin_rsij_1'
        if (Auth::check() && Auth::user()->username !== 'kantin_rsij_1') {
            return $next($request); // Lanjutkan ke user dashboard
        }

        // Redirect ke dashboard admin jika pengguna adalah 'kantin_rsij_1'
        return redirect()->route('admin.dashboard')->with('error', 'You are already an admin.');
    }
}
