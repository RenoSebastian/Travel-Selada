<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('Checking authentication status.');

        if (Auth::check()) {
            $user = Auth::user();
            Log::info('Authentication status:', ['authenticated' => Auth::check()]);

            Log::info('User is authenticated:', ['user' => $user]);

            // Cek apakah pengguna adalah admin
            if ($user->username === 'kantin_rsij_1') {
                return $next($request); // Lanjutkan ke halaman admin
            } else {
                // Untuk pengguna biasa, arahkan ke dashboard pengguna
                return redirect()->route('user.dashboard')->with('status', 'Welcome, you have limited access.'); 
            }
        } else {
            Log::warning('User is not authenticated.');
            return redirect()->route('login')->withErrors('Access denied.'); // Arahkan ke halaman login
        }
    }
}
