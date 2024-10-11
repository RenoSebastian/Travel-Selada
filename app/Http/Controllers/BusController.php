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
    $bus = Bus::findOrFail($bus_id);
    $mbuses = MBus::all();
    $user_travel = UserTravel::all();

    return view('peserta_tour.create', compact('bus', 'mbuses', 'user_travel'));
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'fullname.*' => 'required|string|max:255',
            'phone_number.*' => 'required|string|max:15',
            'seat.*' => 'required|string|max:5',
            'bus_id' => 'required|exists:bus,id'
        ]);
    
        // Ambil ID bus
        $busId = $request->input('bus_id');
    
        // Ambil data bus
        $bus = Bus::with('mbus')->findOrFail($busId); // Include relasi ke MBus
    
        // Kapasitas bus
        $kapasitasBus = $bus->mbus->kapasitas;
    
        // Hitung jumlah peserta yang sudah ada di bus tersebut
        $jumlahPesertaSekarang = PesertaTour::where('bus_location', $busId)->count();
    
        // Hitung jumlah peserta yang ingin ditambahkan
        $jumlahPesertaBaru = count($request->input('fullname'));
    
        // Cek apakah penambahan peserta melebihi kapasitas
        if (($jumlahPesertaSekarang + $jumlahPesertaBaru) > $kapasitasBus) {
            // Jika melebihi kapasitas, kembalikan dengan error
            return back()->with('error', 'Jumlah peserta melebihi kapasitas bus.');
        }
    
        // Inisialisasi counter untuk menghitung jumlah peserta yang berhasil ditambahkan
        $count = 0;
    
        // Ambil data peserta dari request
        $fullnames = $request->input('fullname');
        $phoneNumbers = $request->input('phone_number');
        $seats = $request->input('seat');
    
        // Loop untuk menyimpan peserta
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
    
         // Kirim pesan sukses ke session
        session()->flash('success', 'Anda berhasil menambah ' . $count . ' peserta baru!');

        // Redirect ke halaman Data Bus
        return redirect()->route('bus.index');
        
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