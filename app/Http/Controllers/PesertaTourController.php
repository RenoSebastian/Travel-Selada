<?php

namespace App\Http\Controllers;

use App\Entities\PesertaTour;
use App\Entities\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PesertaTourController extends Controller
{
    public function index()
    {
        $buses = Bus::all(); // Ambil semua bus
        $pesertaTours = PesertaTour::with('bus')->get(); // Ambil peserta dengan relasi bus

        return view('peserta_tour.index', compact('buses', 'pesertaTours')); // Kirim $buses ke view
    }

    public function create($busId)
    {
        // Cari data bus berdasarkan ID
        $bus = Bus::findOrFail($busId); 
    
        // Pass the busId variable to the view
        return view('peserta_tour.create', compact('busId', 'bus'));
    }

    public function store(Request $request, $busId)
{
    try {
        // Log request
        Log::info('Request data untuk store peserta tour:', $request->all());

        // Validasi
        $validatedData = $request->validate([
            'fullname' => 'required|array',
            'fullname.*' => 'required|string',
            'phone_number' => 'required|array',
            'phone_number.*' => 'required|string',
            'seat' => 'required|array',
            'seat.*' => 'required|string',
            'bus_id' => 'required|exists:pgsql_mireta.bus,id', 
        ]);

        // Loop untuk menyimpan data
        foreach ($validatedData['fullname'] as $index => $fullname) {
            PesertaTour::create([
                'fullname' => $fullname,
                'phone_number' => $validatedData['phone_number'][$index],
                'seat' => $validatedData['seat'][$index],
                'bus_location' => $busId,
                'status' => 0, 
            ]);
        }

        // Cek kapasitas bus
        $remainingCapacity = Bus::where('id', $busId)->value('capacity') - PesertaTour::where('bus_location', $busId)->count();

        if ($remainingCapacity < 0) {
            return redirect()->route('bus.index')->with('error', 'Bus penuh, sisa kapasitas: ' . abs($remainingCapacity));
        }

        return redirect()->route('bus.index')->with('success', 'Peserta berhasil ditambahkan!');
    } catch (\Exception $e) {
        Log::error('Error menyimpan peserta:', ['error' => $e->getMessage()]);
        return redirect()->route('bus.index')->with('error', 'Terjadi kesalahan saat menyimpan peserta.');
    }
}


    public function edit($id)
    {
        $bus = Bus::findOrFail($id);
        $pesertaTours = PesertaTour::where('bus_location', $id)->get();
        $pesertaTour = PesertaTour::findOrFail($id);

        return view('peserta_tour.edit', compact('bus', 'pesertaTour', 'pesertaTours'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required',
            'phone_number' => 'required',
            'card_number' => 'required',
            'bus_location' => 'required',
            'status' => 'required|integer',
            'seat' => 'required|string', 
            'clock_in' => 'nullable|date', 
            'clock_out' => 'nullable|date', 
        ]);

        $pesertaTour = PesertaTour::findOrFail($id);
        $pesertaTour->update($request->all());

        return redirect()->route('peserta_tour.index')->with('success', 'Data peserta tour berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pesertaTour = PesertaTour::findOrFail($id);
        $pesertaTour->delete();

        return redirect()->route('peserta_tour.index')->with('success', 'Peserta tour berhasil dihapus.');
    }
}
