<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class SewaController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
       
        
        return view('penyewaan.index', compact('produks'));
    }
    public function show()
    {
        $produks = Produk::all();
       
        
        return view('index', compact('produks'));
    }
}
