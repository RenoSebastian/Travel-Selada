<?php

namespace App\Http\Controllers;

use App\Entities\PesertaTour;
use App\Entities\Bus;
use Illuminate\Http\Request;

class PesertaTourController extends Controller
{
    public function index()
    {
        // Ambil semua peserta tour dan relasi ke bus
        $pesertaTours = PesertaTour::with('bus')->get();
        return view('peserta_tour.index', compact('pesertaTours'));
    }

    public function create($bus_id)
    {
        // Cari data bus berdasarkan ID
        $bus = Bus::findOrFail($bus_id);
    
        return view('peserta_tour.create', compact('bus_id'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'fullname.*' => 'required|string|max:255',
        'phone_number.*' => 'required|string|max:15',
        'seat.*' => 'required|string|max:5',
        'bus_id' => 'required|exists:bus,id' // Validasi bus_id
    ]);

    // Ambil data peserta dari request
    $fullnames = $request->input('fullname');
    $phoneNumbers = $request->input('phone_number');
    $seats = $request->input('seat');
    $busId = $request->input('bus_id'); // Ambil bus_id

    // Inisialisasi counter untuk menghitung jumlah peserta yang berhasil ditambahkan
    $count = 0;

    // Loop untuk menyimpan maksimal 5 peserta
    for ($i = 0; $i < count($fullnames); $i++) {
        PesertaTour::create([
            'fullname' => $fullnames[$i],
            'phone_number' => $phoneNumbers[$i],
            'seat' => $seats[$i],
            'bus_location' => $busId, // Set bus_location dengan bus_id
            'card_number' => null, // Set card_number menjadi null
            'status' => 0 // Status default 0
        ]);
        $count++; // Increment counter
    }

    // Kirim pesan sukses dengan jumlah peserta yang ditambahkan
    return redirect()->route('bus.index', ['bus_id' => $busId])->with('success', 'Anda berhasil menambah ' . $count . ' peserta baru!');
}

    public function edit($id)
    {
        // Ambil data bus berdasarkan ID
        $bus = Bus::findOrFail($id);
    
        // Ambil data peserta tour yang terdaftar di bus ini
        $pesertaTours = PesertaTour::where('bus_location', $id)->get();
    
        // Kirim data bus dan peserta tour ke view
        return view('bus.edit', compact('bus', 'pesertaTours'));
    }
    
    public function update(Request $request, $id)
    {
        // Validasi
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

        // Update data peserta tour
        $pesertaTour = PesertaTour::findOrFail($id);
        $pesertaTour->update($request->all());

        return redirect()->route('peserta_tour.index')->with('success', 'Data peserta tour berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus peserta tour
        $pesertaTour = PesertaTour::findOrFail($id);
        $pesertaTour->delete();

        return redirect()->route('peserta_tour.index')->with('success', 'Peserta tour berhasil dihapus.');
    }
}
