<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Sewa;
use App\Models\LaporanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggalAwal');
        $tanggalAkhir = $request->input('tanggalAkhir');

        $query = Sewa::with(['details.sewas', 'user']);

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('tanggal_sewa', [$tanggalAwal, $tanggalAkhir]);
        }

        // Jika pengguna adalah pelanggan, filter berdasarkan user_id
        if (Auth::user()->hasRole('pelanggan')) {
            $query->where('user_id', Auth::id());
        }

        $sewas = $query->get();

        return view('admin.laporan', compact('sewas'));
    }

    public function exportExcel(Request $request)
    {
        // Implementasi export Excel
    }

    public function exportPDF(Request $request)
    {
        $tanggalAwal = $request->input('tanggalAwal');
        $tanggalAkhir = $request->input('tanggalAkhir');

        $query = Sewa::with(['details.sewas', 'user']);

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('tanggal_sewa', [$tanggalAwal, $tanggalAkhir]);
        }

        // Jika pengguna adalah pelanggan, filter berdasarkan user_id
        if (Auth::user()->hasRole('pelanggan')) {
            $query->where('user_id', Auth::id());
        }

        $sewas = $query->get();

        // Generate PDF using mPDF
        $mpdf = new Mpdf();

        // Load the view and pass the laporanData and image data
        $html = view('admin.report', ['data' => $sewas ])->render();

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    // public function index(Request $request)
    // {
    //     $sewa = Sewa::with('produk')->select('tanggal_sewa', 'jumlah', 'produk_id')->get();

    //     return view('admin.laporan', compact('sewa'));
    // }
}
