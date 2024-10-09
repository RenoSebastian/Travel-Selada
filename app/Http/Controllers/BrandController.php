<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function create()
    {
        return view('layouts.admin.brand_input'); // Ganti dengan nama view yang sesuai
    }

      // Metode untuk menyimpan data brand
      public function store(Request $request)
      {
          // Validasi input
          $request->validate([
              'brand_name' => 'required|string|max:255',
          ]);
  
          // Simpan data brand ke database (disesuaikan dengan model Anda)
          // Brand::create(['name' => $request->brand_name]);
  
          return redirect()->route('brand.create')->with('success', 'Brand berhasil disimpan!');
      }
}

