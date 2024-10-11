<?php

namespace App\Http\Controllers;

use App\Entities\MBus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MBusController extends Controller
{
    // Menampilkan form input data m_bus
    public function create()
    {
        // Log saat menampilkan form
        Log::info('Menampilkan form input data m_bus.');
        
        return view('m_bus.create');
    }

    // Menyimpan data m_bus baru
    public function store(Request $request)
    {
        // Log request data yang diterima
        Log::info('Menerima data request untuk menyimpan m_bus.', ['request' => $request->all()]);

        // Validasi data yang diinput
        $request->validate([
            'kapasitas_bus' => 'required|integer',
        ]);

        try {
            // Log data sebelum disimpan
            Log::info('Menyimpan data m_bus ke database.', [
                'kapasitas_bus' => $request->kapasitas_bus,
            ]);

            // Simpan data ke tabel m_bus
            MBus::create([
                'kapasitas_bus' => $request->kapasitas_bus,
                'created_at' => now(),  // Menambahkan created_at
                'updated_at' => now(),  // Menambahkan updated_at
            ]);

            // Log setelah data berhasil disimpan
            Log::info('Data m_bus berhasil disimpan.');

            // Flash message sukses
            return redirect()->route('m_bus.index')->with('success', 'Berhasil menambahkan jenis bus dengan kapasitas '. $request->kapasitas_bus );
        } catch (\Exception $e) {
            // Log error
            Log::error('Terjadi kesalahan saat menyimpan data m_bus: ' . $e->getMessage());

            // Flash message error
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }

    // Menampilkan semua data m_bus
    public function index()
    {
        // Mengambil data dari tabel m_bus
        $mbuses = MBus::all();

        // Mengirim data ke view
        return view('m_bus.index', compact('mbuses'));
    }

      // Menampilkan form edit data m_bus
      public function edit($id)
      {
          // Mencari data m_bus berdasarkan ID
          $mbus = MBus::findOrFail($id);
  
          // Log saat menampilkan form edit
          Log::info('Menampilkan form edit data m_bus untuk ID: ' . $id);
  
          return view('m_bus.edit', compact('mbus'));
      }
  
      // Mengupdate data m_bus
      public function update(Request $request, $id)
      {
          // Log request data yang diterima
          Log::info('Menerima data request untuk mengupdate m_bus dengan ID: ' . $id, ['request' => $request->all()]);
  
          // Validasi data yang diinput
          $request->validate([
              'tipe_bus' => 'required|string|max:255',
              'kapasitas_bus' => 'required|integer',
          ]);
  
          try {
              // Log data sebelum diperbarui
              Log::info('Mengupdate data m_bus dengan ID: ' . $id, [
                  'kapasitas_bus' => $request->kapasitas_bus,
              ]);
  
              // Mencari data m_bus berdasarkan ID
              $mbus = MBus::findOrFail($id);
              $mbus->update([
                  'kapasitas_bus' => $request->kapasitas_bus,
              ]);
  
              // Log setelah data berhasil diperbarui
              Log::info('Data m_bus dengan ID ' . $id . ' berhasil diperbarui.');
  
              // Flash message sukses
              return redirect()->route('m_bus.index')->with('success', 'Berhasil memperbarui data bus');
          } catch (\Exception $e) {
              // Log error
              Log::error('Terjadi kesalahan saat mengupdate data m_bus: ' . $e->getMessage());
  
              // Flash message error
              return back()->with('error', 'Terjadi kesalahan saat mengupdate data');
          }
      }
  
      // Menghapus data m_bus
      public function destroy($id)
      {
          try {
              // Mencari data m_bus berdasarkan ID
              $mbus = MBus::findOrFail($id);
              $mbus->delete();
  
              // Log setelah data berhasil dihapus
              Log::info('Data m_bus dengan ID ' . $id . ' berhasil dihapus.');
  
              // Flash message sukses
              return redirect()->route('m_bus.index')->with('success', 'Data m_bus berhasil dihapus');
          } catch (\Exception $e) {
              // Log error
              Log::error('Terjadi kesalahan saat menghapus data m_bus: ' . $e->getMessage());
  
              // Flash message error
              return back()->with('error', 'Terjadi kesalahan saat menghapus data');
          }
      }
}
