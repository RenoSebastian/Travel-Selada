<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\User;
use Illuminate\Support\Str; // Import Str untuk generate UUID\
use Illuminate\Support\Facades\Hash;

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

    public function index(Request $request)
    {
        // Ambil daftar pengguna dengan pagination
        $users = User::paginate(5); // 10 pengguna per halaman

        return view('Locations.user_list', compact('users'));
    }

        // Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'is_active' => 'required|boolean',
        ]);

        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui data pengguna
        $user->update([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'updated_at' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        // Cari pengguna berdasarkan ID dan hapus
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }

}
