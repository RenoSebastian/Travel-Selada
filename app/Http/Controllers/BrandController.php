<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function create()
    {
        return view('layouts.admin.brand_input'); // Ganti dengan nama view yang sesuai
    }
}

