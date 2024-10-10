<?php

namespace App\Http\Controllers;

use App\Entities\Bus;
use App\Entities\MBus;
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
         return view('bus.create', compact('mbuses'));
     }
 
     public function store(Request $request)
    {
        Log::info('Menerima data request untuk menyimpan bus.', ['request' => $request->all()]);
        
        // Validasi data yang diinput
        $request->validate([
            'nama_bus' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
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
            $bus = Bus::create([
                'nama_bus' => $request->nama_bus,
                'alamat' => $request->alamat,
                'tipe_bus' => $request->tipe_bus,
                'created_at' => now(),  // Menambahkan created_at
                'updated_at' => now(),  // Menambahkan updated_at
            ]);

            // Log setelah data berhasil disimpan
            Log::info('Data bus berhasil disimpan.');

            // Mengembalikan respons JSON
            return response()->json([
                'success' => true,
                'message' => 'Data bus berhasil ditambahkan',
                'data' => $bus // Mengembalikan data bus yang baru disimpan
            ], 201); // 201 Created
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data bus: ' . $e->getMessage());

            // Mengembalikan respons JSON jika terjadi kesalahan
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage() // Menyertakan pesan kesalahan
            ], 500); // 500 Internal Server Error
        }
    }


    public function index()
    {
        // Mengambil data dari tabel bus
        $buses = Bus::all();

        // Mengambil data dari tabel m_bus
        $mbuses = MBus::all();

        // Mengirim data ke view
        return view('bus.index', compact('buses', 'mbuses'));
    }
}
