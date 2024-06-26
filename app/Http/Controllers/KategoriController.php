<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategori', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required',
            'nama_kategori' => 'required',
        ]);

        Kategori::create([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')
                        ->with('success', 'Kategori created successfully.');
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json($kategori);
    }
    

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan.');
        }
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::find($id);
        if (!$kategori) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan.');
        }

        $kategori->kode_kategori = $request->input('kode_kategori');
        $kategori->nama_kategori = $request->input('nama_kategori');
        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate.');
    }


    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')
                        ->with('success', 'Kategori deleted successfully');
    }
}
