<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::all();
        return view('checkout.keranjang.index', compact('keranjang'));
    }

    public function store(Request $request)
    {
        $keranjang = new Keranjang();
        $keranjang->nama_produk = $request->nama_produk;
        $keranjang->jumlah = $request->jumlah;
        $keranjang->harga = $request->harga;
        $keranjang->save();

        return response()->json(['message' => 'Item added to cart'], 200);
    }
}