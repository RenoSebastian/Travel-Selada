<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\User;
use App\Entities\UserLocation;
use App\Entities\MLocation;
use App\Entities\MBrand;
use Illuminate\Support\Str;
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
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        $username = $request->input('username');
        $password = $request->input('password');
    
        Log::info('Login attempt:', [
            'username' => $username,
        ]);
    
        $user = User::where('username', $username)->first();
    
        if ($user && Hash::check($password, $user->password)) {
            Log::info('Login successful for user:', ['user_id' => $user->id]);
        
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ]);
        
            if ($username === 'kantin_rsij_1') {
                return redirect()->route('admin.dashboard')->with('status', 'Welcome, you have access to the admin dashboard.');
            } else {
                return redirect()->route('user.dashboard')->with('status', 'Welcome, you have limited access.');
            }
        }
        
    }    
    

    public function loginApk(Request $request)
    {
        Log::info('APK login attempt:', [
            'username' => $request->username,
        ]);
    
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $user = User::where('username', $request->username)->first();
    
        if ($user) {
            Log::info('User found:', ['user_id' => $user->id, 'username' => $user->username]);
    
            if (Hash::check($request->password, $user->password)) {
                Log::info('APK login successful:', ['user_id' => $user->id]);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'id' => (string)$user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'fullname' => $user->fullname,
                    ],
                ]);
            } else {
                Log::warning('Invalid password for user:', ['username' => $request->username]);
            }
        } else {
            Log::warning('User not found:', ['username' => $request->username]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Invalid username or password.',
        ], 401);
    }
    

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }

    public function create()
    {
        return view('layouts.admin.location_input');
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|string|max:255',
            'brand_id' => 'required|uuid', // Ubah validasi di sini
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'add_stock_allowed' => 'required|boolean',
            'point_of_sale_allowed' => 'required|boolean',
            'created_by' => 'required|string|max:255',
            'updated_by' => 'required|string|max:255',
        ]);

        // Simpan data lokasi ke database
        MLocation::create([
            'business_id' => $request->business_id,
            'brand_id' => $request->brand_id, // Pastikan ini diubah
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'add_stock_allowed' => $request->add_stock_allowed,
            'point_of_sale_allowed' => $request->point_of_sale_allowed,
            'created_by' => $request->created_by,
            'updated_by' => $request->updated_by,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('location.create')->with('success', 'Lokasi berhasil disimpan!');
    }

}
