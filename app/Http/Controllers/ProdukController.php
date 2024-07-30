<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Keranjang;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        $kategoris = Kategori::all();
        $ProdukCount = Produk::count();
        $keranjang = Keranjang::where('user_id', auth()->id())->get();
        return view('admin.barang', compact('produks', 'kategoris', 'ProdukCount', 'keranjang'));
    }

    public function ld()
    {
        $produks = Produk::all();
        return view('index', compact('produks'));
    }

    public function create() :View
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_produk' => 'required|max:255',
            'gambar' => 'nullable|image',
            'jumlah_unit' => 'required|numeric',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        if ($request->hasFile('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('admin/assets/pic', 'public');
        }

        Produk::create($validatedData);

        return redirect()->route('barang.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $barang)
    {
        return view('produk.show', compact('barang'));
    }

    public function edit($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
        }
        return view('admin.editbarang', compact('kategoris', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_produk' => 'required|max:255',
            'gambar' => 'nullable|image',
            'jumlah_unit' => 'required|numeric',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
        ]);
    
        $produk = Produk::find($id);
        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
        }
    
        $produk->kategori_id = $request->input('kategori_id');
        $produk->nama_produk = $request->input('nama_produk');
        $produk->jumlah_unit = $request->input('jumlah_unit');
        $produk->deskripsi = $request->input('deskripsi');
        $produk->harga = $request->input('harga');
    
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk_images');
            $produk->gambar = $gambarPath;
        }
    
        $produk->save();
    
        return redirect()->route('barang.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Produk $barang)
    {
        if ($barang->gambar) {
            Storage::delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function getTotalProducts()
    {
        $totalProducts = Produk::count();
        return response()->json(['total_products' => $totalProducts]);
    }
}
