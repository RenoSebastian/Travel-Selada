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

        $user = User::find($userId);

        if ($user) {
            $matchingParticipants = PesertaTour::where('id_user', $user->id)->get();

            $participantsData = $matchingParticipants->map(function ($participant) {
                return [
                    'fullname' => $participant->fullname,
                    'phone' => $participant->phone_number,
                    'seat' => $participant->seat,
                    'class' => $participant->class,
                ];
            });

            return response()->json([
                'user_id' => $userId,
                'participants' => $participantsData,
            ]);
        }

        return response()->json([
            'user_id' => $userId,
            'participants' => [],
        ]);
    }


    public function create()
    {
        return view('Locations.location_input'); // Pastikan nama view sesuai
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'business_id' => 'required|string|max:255',
            'brand_id' => 'required|integer', // Pastikan brand_id adalah integer
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'add_stock_allowed' => 'required|boolean',
            'point_of_sale_allowed' => 'required|boolean',
            'created_by' => 'required|string|max:255',
            'updated_by' => 'required|string|max:255',
        ]);
    
        // Ambil id terakhir dari database
        $lastId = MLocation::max('id'); // Mengambil id terakhir
    
        // Buat id baru
        $newId = $lastId + 1;
    
        // Simpan data lokasi ke database
        MLocation::create([
            'id' => $newId, // Menggunakan id yang baru dibuat
            'business_id' => $validatedData['business_id'],
            'brand_id' => $validatedData['brand_id'],
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'add_stock_allowed' => $validatedData['add_stock_allowed'],
            'point_of_sale_allowed' => $validatedData['point_of_sale_allowed'],
            'created_by' => $validatedData['created_by'],
            'updated_by' => $validatedData['updated_by'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Redirect setelah berhasil menyimpan data
        return redirect()->route('location.create')->with('success', 'Lokasi berhasil disimpan!');
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
