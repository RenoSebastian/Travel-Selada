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
            Log::info('User is authenticated:', ['username' => $user->username]);

            // Tentukan akses berdasarkan username
            if ($user->hasFullAccess()) {
                return $next($request); // Lanjutkan ke halaman admin
            } else {
                Log::warning('Access denied for user:', ['username' => $user->username]);
                return redirect()->route('user.dashboard')->withErrors('Access denied.');
            }
        } else {
            Log::warning('User is not authenticated.');
            return redirect()->route('login')->withErrors('Access denied.');
        }
    }
}
