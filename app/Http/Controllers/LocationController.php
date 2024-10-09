<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\UserLocation;
use App\Entities\MLocation;
use App\Entities\MemberData;

class LocationController extends Controller
{
    public function showForm()
    {
        return view('locations.form');
    }

    public function getLocations(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'user_id' => 'required|string',
        ]);
    
        $userId = $validatedData['user_id'];
    
        // Ambil lokasi pengguna
        $userLocationRecord = UserLocation::where('user_id', $userId)->first();
    
        // Jika lokasi ditemukan
        if ($userLocationRecord) {
            $locationId = $userLocationRecord->location_id;
    
            // Ambil data anggota berdasarkan location_id
            $members = MemberData::where('location_id', $locationId)->get();
    
            // Siapkan data anggota yang cocok
            $matchingMembers = [];
            foreach ($members as $member) {
                $matchingMembers[] = [
                    'name' => $member->fullname,
                    'phone' => $member->phone,
                    'code' => $member->code,
                    'seat' => $member->name,
                ];
            }
    
            // Kembalikan respons JSON dengan data
            return response()->json([
                'status' => 'success',
                'userId' => $userId,
                'locationId' => $locationId,
                'matchingMembers' => $matchingMembers,
            ]);
        }
    
        // Jika tidak ada lokasi ditemukan, kembalikan respons dengan status yang sesuai
        return response()->json([
            'status' => 'success',
            'userId' => $userId,
            'locationId' => null,
            'matchingMembers' => [],
        ]);
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
