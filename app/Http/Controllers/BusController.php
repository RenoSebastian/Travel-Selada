<?php

namespace App\Http\Controllers;

use App\Entities\Bus;
use App\Entities\MBus;
use App\Entities\UserTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Entities\PesertaTour; 

class BusController extends Controller
{
    // Menampilkan form input data bus
    public function create()
    {
        // Log saat menampilkan form
        Log::info('Menampilkan form input data bus.');
        // Ambil data bus terkait
        $mbuses = MBus::all();
        $user_travel = UserTravel::all();

        return view('bus.create', compact('mbuses', 'user_travel'));
    }
    
     // Menyimpan data bus baru
     public function store(Request $request)
     {
         // Validasi input bus baru
         $request->validate([
             'nama_bus' => 'required|string|max:255',
             'alamat_penjemputan' => 'required|string|max:255',
             'tipe_bus' => 'required|exists:m_bus,id',
             'tl_id' => 'required|exists:user_travel,id', // Tour leader
         ]);
 
         // Buat bus baru
         Bus::create([
             'nama_bus' => $request->input('nama_bus'),
             'alamat_penjemputan' => $request->input('alamat_penjemputan'),
             'tipe_bus' => $request->input('tipe_bus'),
             'tl_id' => $request->input('tl_id'), // Tour leader ID
         ]);
 
         // Redirect dan tampilkan pesan sukses
         return redirect()->route('bus.index')->with('success', 'Bus baru berhasil ditambahkan!');
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
        // Ambil data peserta tour yang terdaftar di bus ini dengan pagination
        $pesertaTours = PesertaTour::where('bus_location', $id)->paginate(5);
        $mbuses = MBus::all();
        $user_travel = UserTravel::all();
        
        // Kirim data bus dan peserta tour ke view
        return view('bus.edit', compact('bus', 'pesertaTours', 'mbuses', 'user_travel'));
    }

    public function update(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);
        // Update data, termasuk tour leader
        $bus->update([
            'nama_bus' => $request->input('nama_bus'),
            'alamat_penjemputan' => $request->input('alamat_penjemputan'),
            'tipe_bus' => $request->input('tipe_bus'),
            'tl_id' => $request->input('tour_leader') // Pastikan ini
        ]);
        return redirect()->route('bus.index')->with('success', 'Data bus berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);
        $bus->delete();
        return redirect()->route('bus.index')->with('success', 'Data bus berhasil dihapus');
    }
}