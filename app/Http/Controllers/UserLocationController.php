<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\UserLocation;
use App\Entities\User;
use App\Entities\MLocation;
use Illuminate\Support\Str;

class UserLocationController extends Controller
{
    public function create()
    {
        // Ambil semua lokasi dari tabel MLocation
        $locations = MLocation::all();

        // Ambil semua user (tourguide)
        $users = User::where('is_active', true)->get();

        return view('user_locations.create', compact('locations', 'users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id', // Memastikan user_id ada di tabel users
            'location_id' => 'required|exists:m_locations,id', // Memastikan location_id ada di tabel m_locations
        ]);

        // Buat UserLocation baru
        UserLocation::create([
            'user_id' => $request->user_id, // Menyimpan user_id
            'brand_id' => 65, // Set brand_id menjadi 65
            'location_id' => $request->location_id, // Menyimpan location_id
        ]);

        return redirect()->route('user_locations.create')->with('success', 'User location berhasil ditambahkan!');
    }
}
