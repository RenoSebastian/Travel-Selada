<?php

namespace App\Http\Controllers;

use App\Entities\Members; // Ini adalah entitas yang sudah kita buat sebelumnya
use Illuminate\Http\Request;

class MembersController extends Controller
{
    // Fungsi untuk menampilkan data members
    public function index()
    {
        $members = Members::all(); // Ambil semua data dari tabel members
        return view('members.index', compact('members')); // Mengirim data ke view
    }
}
