<?php

namespace App\Http\Controllers;

use App\Entities\Bus;
use App\Entities\MBus;
use App\Entities\UserTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusController extends Controller
{
    // Menampilkan form input data bus
    public function create()
    {
        // Log saat menampilkan form
        Log::info('Menampilkan form input data bus.');

        // Ambil data dari tabel m_bus untuk pilihan tipe bus
        $mbuses = MBus::all();
        $user_travel = UserTravel::all();
        return view('bus.create', compact('mbuses', 'user_travel'));
    }

    // Menyimpan data bus baru
    public function store(Request $request)
    {
        Log::info('Menerima data request untuk menyimpan bus.', ['request' => $request->all()]);

        // Validasi data yang diinput
        $request->validate([
            'nama_bus' => 'required|string|max:255',
            'alamat_penjemputan' => 'required|string|max:255',
            'tl_id' => 'required|exists:user_travel,id',
            'tipe_bus' => 'required|exists:m_bus,id',
        ]);

        Log::info('Validasi berhasil.');

        try {
            // Log data sebelum disimpan
            Log::info('Menyimpan data bus ke database.', [
                'nama_bus' => $request->nama_bus,
                'alamat' => $request->alamat,
                'tipe_bus' => $request->tipe_bus
            ]);

            // Simpan data ke tabel bus
            Bus::create([
                'nama_bus' => $request->nama_bus,
                'alamat_penjemputan' => $request->alamat_penjemputan,
                'tl_id' => $request->tl_id,
                'tipe_bus' => $request->tipe_bus,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Log setelah data berhasil disimpan
            Log::info('Data bus berhasil disimpan.');

            // Flash message sukses
            return redirect()->route('bus.index')->with('success', 'Data bus berhasil disimpan.');
        } catch (\Exception $e) {
            // Log kesalahan
            Log::error('Terjadi kesalahan saat menyimpan data bus: ' . $e->getMessage());

            // Flash message error
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }

    public function index()
    {
        // Mengambil data dari tabel bus
        $buses = Bus::all();

        // Mengambil data dari tabel m_bus
        $mbuses = MBus::all();

        $user_travel = UserTravel::all();

        // Mengirim data ke view
        return view('bus.index', compact('buses', 'mbuses', 'user_travel'));
    }

    public function edit($id)
    {
        $bus = Bus::findOrFail($id);
        return view('bus.edit', compact('bus'));
    }

    public function update(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);
        $bus->update($request->all());
        return redirect()->route('bus.index')->with('success', 'Data bus berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);
        $bus->delete();
        return redirect()->route('bus.index')->with('success', 'Data bus berhasil dihapus');
    }
}
