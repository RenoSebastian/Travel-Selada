<?php

namespace App\Http\Controllers;

use App\Entities\PesertaTour;
use App\Entities\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourLeaderController extends Controller
{
    public function index()
    {
        // Ambil ID user yang login (Tour Leader)
        $userId = Auth::id();

        // Cari semua bus yang dihandle oleh tour leader tersebut
        $buses = Bus::where('tl_id', $userId)->get();

        // Jika tidak ada bus, beri notifikasi bahwa TL belum memiliki bus
        if ($buses->isEmpty()) {
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki bus yang terdaftar.');
        }

        // Ambil daftar peserta untuk bus-bus tersebut
        $pesertaTours = PesertaTour::whereIn('bus_location', $buses->pluck('id'))->with('bus')->get();

        return view('tour_leader.index', compact('buses', 'pesertaTours'));
    }

    public function show($busId)
    {
        // Pastikan bus yang dipilih adalah milik tour leader yang login
        $userId = Auth::id();
        $bus = Bus::where('id', $busId)->where('tl_id', $userId)->firstOrFail();

        // Ambil daftar peserta yang ada di bus tersebut
        $pesertaTours = PesertaTour::where('bus_location', $busId)->with('bus')->get();

        return view('tour_leader.show', compact('bus', 'pesertaTours'));
    }
}
