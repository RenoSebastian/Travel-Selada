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

    public function create($id) // Change the parameter to $id
    {
        // Cari data bus berdasarkan ID
        $bus = Bus::findOrFail($id);
        
        // Pass the bus_id variable to the view
        return view('peserta_tour.create', compact('id', 'bus_id'));
    }
    

    public function store(Request $request)
{
    $request->validate([
        'fullname.*' => 'required|string|max:255',
        'phone_number.*' => 'required|string|max:15',
        'seat.*' => 'required|string|max:5',
        'bus' => 'required|exists:bus,id' // Pastikan ini valid
    ]);

    $busId = $request->input('bus');
    $bus = Bus::with('mbus')->findOrFail($busId);
    $kapasitasBus = $bus->mbus->kapasitas_bus; // Ubah ini jika kolomnya berbeda
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

    $count = 0;
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
        $count++;
    }

    session()->flash('success', "Anda berhasil menambah {$count} peserta baru!");
    return redirect()->route('bus.index');
}

    

    public function edit($id)
    {
        // Ambil data bus berdasarkan ID
        $bus = Bus::findOrFail($id);
    
        // Ambil data peserta tour yang terdaftar di bus ini
        $pesertaTours = PesertaTour::where('bus_location', $id)->get();
    
        // Kirim data bus dan peserta tour ke view
        $pesertaTour = PesertaTour::findOrFail($id); // Ambil peserta berdasarkan ID
        return view('peserta_tour.edit', compact('bus', 'pesertaTour', 'pesertaTours'));

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
