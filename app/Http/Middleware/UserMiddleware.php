<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        // Cek apakah pengguna yang login tidak memiliki akses penuh
        if (Auth::check() && !Auth::user()->hasFullAccess()) {
            return $next($request); // Lanjutkan ke user dashboard
        }

        // Jika pengguna adalah admin, redirect ke dashboard admin
        $user = Auth::user(); // Ambil user yang terautentikasi
        \Log::info('Admin user attempted to access user dashboard:', ['user_id' => $user->id]);
        return redirect()->route('admin.dashboard')->with('error', 'You cannot access the user dashboard as an admin.');
    }
}
