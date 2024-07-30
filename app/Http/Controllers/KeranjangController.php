<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Keranjang;

use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    function keranjang()
    {
        $keranjang = Keranjang::where('user_id', auth()->user()->id)->with('produk')->get();
        // dd($keranjang);
        return view('pelanggan.keranjang.index', compact('keranjang'));
    }

    public function tambahKeranjang(Request $request)
{
    // Validasi input atau ambil data produk dari request
    $produk = Produk::find($request->input('produk_id'));

    if (!$produk) {
        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.']);
        }
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    // Jika produk belum ada di keranjang, tambahkan produk ke keranjang
    $keranjangItem = new Keranjang();
    $keranjangItem->user_id = auth()->user()->id;
    $keranjangItem->produk_id = $produk->id; // Set produk_id sesuai dengan produk yang dipilih
    $keranjangItem->nama_produk = $produk->nama_produk; // Pastikan nama produk diambil dengan benar
    $keranjangItem->jumlah = $request->input('cart_qty'); // Default quantity, bisa diubah sesuai kebutuhan
    $keranjangItem->harga = $produk->harga * $request->input('cart_qty'); // Hitung harga berdasarkan jumlah
    $keranjangItem->sub_total = $keranjangItem->harga * $keranjangItem->jumlah;
    $keranjangItem->save();

    if ($request->wantsJson()) {
        return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan ke keranjang.']);
    }

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
}

    public function tambahQuantity(Request $request, $keranjang_id)
{
    $keranjang = Keranjang::find($keranjang_id);
    $keranjang->jumlah = $request->input('jumlah');
    $keranjang->save();

    $this->updateTotalPesanan(auth()->user()->id);

    return redirect()->back()->with('success', 'Quantity updated successfully.');
}

    public function removeFromKeranjang(Request $request, $id)
    {
        $keranjang = Keranjang::find($id);

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Item tidak ditemukan dalam keranjang.');
        }

        $keranjang->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    private function updateTotalPesanan($id)
    {
        $total = Keranjang::where('id', $id)->sum('harga');

        // Simpan total pesanan ke dalam tabel pesanan
        $pesanan = Keranjang::where('id', $id)->first();
        if ($pesanan) {
            $pesanan->total = $total;
            $pesanan->save();
        }
    }
}