<?php

namespace App\Http\Controllers;

use App\Entities\PesertaTour;
use App\Entities\Bus;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
            'fullname.*' => 'required|string|max:255',
            'phone_number.*' => 'required|string|max:15',
            'seat.*' => 'required|string|max:5',
            'bus' => 'required|exists:buses,id' // Pastikan validasi ID bus
        ]);

        $busId = $request->input('bus');
        $bus = Bus::with('mbus')->findOrFail($busId);
        $kapasitasBus = $bus->mbus->kapasitas_bus;
        $jumlahPesertaSekarang = PesertaTour::where('bus_location', $busId)->count();
        $jumlahPesertaBaru = count($request->input('fullname'));

        // Cek apakah jumlah peserta melebihi kapasitas
        if (($jumlahPesertaSekarang + $jumlahPesertaBaru) > $kapasitasBus) {
            $sisaKapasitas = $kapasitasBus - $jumlahPesertaSekarang; // Hitung sisa kapasitas
            return response()->json([
                'status' => 'full',
                'sisaKapasitas' => $sisaKapasitas
            ]); // Respons JSON jika bus sudah penuh
        }

        $fullnames = $request->input('fullname');
        $phoneNumbers = $request->input('phone_number');
        $seats = $request->input('seat');

        foreach ($fullnames as $i => $fullname) {
            PesertaTour::create([
                'fullname' => $fullname,
                'phone_number' => $phoneNumbers[$i],
                'seat' => $seats[$i],
                'bus_location' => $busId,
                'card_number' => null,
                'status' => 0
            ]);
        }

        return response()->json(['status' => 'success']); // Respons JSON jika berhasil
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
