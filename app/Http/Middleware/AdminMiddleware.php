<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user(); // Ambil pengguna yang terautentikasi

            // Log ID pengguna untuk debugging
            \Log::info('User ID before query in AdminMiddleware:', ['user_id' => $user->id]);

            // Periksa apakah username sesuai dengan admin
            if ($user->username === 'kantin_rsij_1') {
                return redirect('/'); // Lanjutkan ke halaman admin
            }
        }

        return redirect('admin.dashboard'); // Atau rute lain jika tidak memiliki akses
    }
}