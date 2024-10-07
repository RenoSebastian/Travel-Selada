<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\User;
use App\Entities\Members;
use App\Entities\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Ambil username dan password dari request
        $username = $request->input('username');
        $password = $request->input('password');

        // Coba autentikasi pengguna
        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            // Cek jika user adalah admin
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('status', 'Welcome to the Admin Dashboard.');
            } else {
                return redirect()->route('user.dashboard')->with('status', 'Welcome to the User Dashboard.');
            }
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function loginApk(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        Log::info('Login attempt:', [
            'username' => $username,
            'password' => $password
        ]);

        $user = User::attemptLogin($username, $password);

        if ($user) {
            Log::info('Login successful:', ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                ],
            ]);
        } else {
            Log::warning('Login failed for username: ' . $username);

            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.',
            ], 401);
        }
    }
}
