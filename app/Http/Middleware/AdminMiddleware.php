<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan ini

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('Checking authentication status.');

        if (Auth::check()) {
            Log::info('User is authenticated:', ['user' => Auth::user()]);
            $user = Auth::user();
            if ($user->username === 'kantin_rsij_1') {
                return $next($request); // Lanjutkan ke halaman admin
            }else {
                Log::warning('Access denied for user:', ['username' => Auth::user()->username]);
            }
        } else {
            Log::warning('User is not authenticated.');
        }

        return redirect()->route('login')->withErrors('Access denied.');
    }
}
