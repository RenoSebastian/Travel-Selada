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
        // Validate incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|string',
        ]);

        $userId = $validatedData['user_id'];

        // Retrieve location_id based on user_id
        $userLocation = UserLocation::where('user_id', $userId)->first();

        if ($userLocation) {
            $locationId = $userLocation->location_id;

            // Retrieve all member data with the same location_id
            $members = MemberData::where('location_id', $locationId)->get();

            // Format member data into an array
            $matchingMembers = [];
            foreach ($members as $member) {
                $matchingMembers[] = [
                    'name' => $member->fullname,
                    'phone' => $member->phone,
                    'code' => $member->code,
                    'seat' => $member->name,
                ];
            }

            // Return JSON response with detailed data
            return response()->json([
                'status' => 'success',
                'data' => [
                    'userId' => $userId,
                    'locationId' => $locationId,
                    'matchingMembers' => $matchingMembers,
                ],
            ]);
        }

        // Return JSON response for no matching members
        return response()->json([
            'status' => 'success',
            'data' => [
                'userId' => $userId,
                'locationId' => null,
                'matchingMembers' => [],
            ],
        ]);
    }

    public function create()
    {
        return view('layouts.admin.location_input');
    }

    public function store(Request $request)
    {
        $request->validate([
           'business_id' => 'required|uuid', 
            'brand_id' => 'required|integer',
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
