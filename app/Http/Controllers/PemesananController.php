<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        // Ambil semua data sewa dengan relasi user dan detail
        $pemesanans = Sewa::with(['user', 'details'])->get();

        // Kirim data ke view
        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    public function proses()
    {
        // Ambil semua data sewa dengan status 'paid' dan sertakan relasi 'details.produkMany'
        $pemesanans = Sewa::with(['details.produkMany'])
            ->where('status', 'paid')
            ->get();
    
        // Kirim data ke view
        return view('admin.pemesanan.proses', compact('pemesanans'));
        
    }

    public function selesai()
    {
        // Ambil semua data sewa dengan status 'selesai'
        $pemesanans = Sewa::with(['user', 'details.produkMany'])
            ->where('status', 'selesai')
            ->get();

        // Kirim data ke view
        return view('admin.pemesanan.selesai', compact('pemesanans'));
    }
}
