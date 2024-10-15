<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entities\UserLocation;
use App\Entities\MLocation;
use App\Entities\MemberData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Entities\PesertaTour;
use App\Entities\User;


class LocationController extends Controller
{
    public function showForm()
    {
        return view('Locations.form');
    }

    public function getLocations(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|string',
        ]);
    
        $userId = $validatedData['user_id'];
    
        // Ambil user berdasarkan user_id
        $user = User::find($userId);
    
        if ($user) {
            $busId = $user->id_bus;
    
            // Ambil semua peserta tour yang memiliki bus_location sama dengan id_bus dari pengguna
            $matchingParticipants = PesertaTour::where('bus_location', $busId)->get();
    
            // Format data ke dalam JSON
            $participantsData = $matchingParticipants->map(function ($participant) {
                return [
                    'fullname' => $participant->fullname,
                    'phone' => $participant->phone_number,
                    'class' => $participant->class,
                    'status' => $participant->status,
                ];
            });
    
            return response()->json([
                'user_id' => $userId,
                'bus_id' => $busId,
                'participants' => $participantsData,
            ]);
        }
    
        return response()->json([
            'user_id' => $userId,
            'bus_id' => null,
            'participants' => [], // Kembalikan koleksi kosong jika pengguna tidak ditemukan
        ]);
    }
    

    public function create()
    {
        return view('Locations.location_input'); // Pastikan nama view sesuai
    }   

    public function index(Request $request)
    {
        // Ambil jumlah item per halaman dari query parameter, default 10
        $perPage = $request->get('per_page', 5);

        // Ambil data lokasi dengan pagination
        $locations = MLocation::paginate($perPage);

        // Tampilkan view dengan data lokasi
        return view('Locations.list_location', compact('locations'));
    }
}
