<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\UserLocation;
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
    
}
