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
    // Log data request sebelum validasi
    Log::info('Request data untuk store peserta tour:', $request->all());

    // Validasi data
    $validatedData = $request->validate([
        'fullname' => 'required|array',
        'fullname.*' => 'required|string',
        'phone_number' => 'required|array',
        'phone_number.*' => 'required|string',
        'seat' => 'required|array',
        'seat.*' => 'required|string',
        'bus_id' => 'required|exists:pgsql_mireta.bus,id', // Pastikan bus_id ada
    ]);

    // Log data setelah validasi
    Log::info('Data validasi untuk store peserta tour:', $validatedData);

    // Simpan peserta ke database
    foreach ($validatedData['fullname'] as $index => $fullname) {
        try {
            // Log query sebelum dijalankan
            Log::info('Menyimpan peserta tour ke database:', [
                'fullname' => $fullname,
                'phone_number' => $validatedData['phone_number'][$index],
                'seat' => $validatedData['seat'][$index],
                'bus_id' => $busId, // Log bus_id
            ]);

            PesertaTour::create([
                'fullname' => $fullname,
                'phone_number' => $validatedData['phone_number'][$index],
                'seat' => $validatedData['seat'][$index],
                'bus_location' => $busId, // Menggunakan $busId yang diambil dari parameter
                'status' => 0, // Contoh status
            ]);

            // Log jika berhasil menyimpan
            Log::info('Peserta tour berhasil disimpan:', [
                'fullname' => $fullname,
                'phone_number' => $validatedData['phone_number'][$index],
                'seat' => $validatedData['seat'][$index],
                'bus_id' => $busId, // Log bus_id
            ]);

        } catch (\Exception $e) {
            // Log error jika terjadi kesalahan saat menyimpan
            Log::error('Terjadi kesalahan saat menyimpan peserta tour:', [
                'error' => $e->getMessage(),
                'fullname' => $fullname,
                'phone_number' => $validatedData['phone_number'][$index],
                'seat' => $validatedData['seat'][$index],
                'bus_id' => $busId,
            ]);
        }
    }

    // Log pengecekan kapasitas bus
    Log::info('Cek kapasitas bus:', ['bus_id' => $busId]);

    // Cek kapasitas bus
    $remainingCapacity = Bus::where('id', $busId)->value('capacity') - PesertaTour::where('bus_location', $busId)->count();

    if ($remainingCapacity < 0) {
        Log::warning('Kapasitas bus penuh, sisa kapasitas:', ['sisaKapasitas' => abs($remainingCapacity)]);
        return response()->json(['status' => 'full', 'sisaKapasitas' => abs($remainingCapacity)]);
    }

    return response()->json(['status' => 'success', 'message' => 'Peserta berhasil ditambahkan']);
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
