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
    
        return view('peserta_tour.create', compact('bus'));
    }

    public function store(Request $request)
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

        // Simpan data peserta tour
        PesertaTour::create($request->all());

        return redirect()->route('peserta_tour.index')->with('success', 'Peserta tour berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Cari peserta tour dan bus
        $pesertaTour = PesertaTour::findOrFail($id);
        $buses = Bus::all();
        return view('peserta_tour.edit', compact('pesertaTour', 'buses'));
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
