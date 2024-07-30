<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $sewa = Sewa::with('produk')->select('tanggal_sewa', 'jumlah', 'produk_id')->get();

        return view('admin.laporan', compact('sewa'));
    }
}
