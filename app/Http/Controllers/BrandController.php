<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\MBrand; // Pastikan ini diimpor

class BrandController extends Controller
{
    public function create()
    {
        return view('layouts.admin.brand_input');
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'created_by' => 'required|string|max:255',
            'updated_by' => 'required|string|max:255',
        ]);

        // Simpan data brand ke database
        MBrand::create([
            'business_id' => $request->business_id,
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $request->created_by,
            'updated_by' => $request->updated_by,
            'created_at' => now(), // Jika Anda ingin menyimpan timestamp
            'updated_at' => now(), // Jika Anda ingin menyimpan timestamp
        ]);

        return redirect()->route('brand.create')->with('success', 'Brand berhasil disimpan!');
    }
}
