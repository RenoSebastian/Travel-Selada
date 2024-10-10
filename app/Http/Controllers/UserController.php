<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\User;
use Illuminate\Support\Str; // Import Str untuk generate UUID

class UserController extends Controller
{
    public function create()
    {
        return view('Locations.user_input');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users', // Pastikan username unik
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Buat user baru
        User::create([
            'id' => Str::uuid(), // Generate UUID untuk id
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'is_active' => true, // Atur status default
            'created_by' => 'system', // Atur sesuai kebutuhan
            'created_at' => now(), // Atur waktu saat ini
        ]);

        return redirect()->route('users.create')->with('success', 'User berhasil ditambahkan!');
    }
}
