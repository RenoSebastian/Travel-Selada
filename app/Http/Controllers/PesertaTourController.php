<?php

namespace App\Http\Controllers;

use App\Entities\PesertaTour;
use App\Entities\Bus;
use App\Entities\MBus;
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
            // Validasi input untuk satu peserta
            $validatedData = $request->validate([
                'fullname' => 'required|string',
                'phone_number' => 'required|string',
                'seat' => 'required|string',
                'bus_id' => 'required|exists:pgsql_mireta.bus,id',
            ]);
    
            // Ambil bus dan tipe bus untuk mengecek kapasitas
            $bus = Bus::findOrFail($busId);
            $tipeBus = $bus->tipe_bus;
    
            // Ambil kapasitas bus dari m_bus
            $kapasitasBus = MBus::where('id', $tipeBus)->value('kapasitas_bus');
    
            // Hitung jumlah peserta yang sudah terdaftar di bus ini
            $jumlahPeserta = PesertaTour::where('bus_location', $busId)->count();
    
            // Cek apakah kapasitas bus sudah penuh
            if ($jumlahPeserta >= $kapasitasBus) {
                return redirect()->route('bus.index')->with('error', 'Bus sudah penuh, kapasitas maksimal adalah ' . $kapasitasBus . ' peserta.');
            }
    
            // Simpan data peserta tour
            PesertaTour::create([
                'fullname' => $validatedData['fullname'],
                'phone_number' => $validatedData['phone_number'],
                'seat' => $validatedData['seat'],
                'bus_location' => $busId,
                'status' => 0, // Set default status ke 0
            ]);
    
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
