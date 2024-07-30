<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Sewa;
use Midtrans\Config;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bukti_identitas' => 'required|file|mimes:jpg,png,jpeg',
            'tanggal_sewa' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_sewa',
            'id_barang.*' => 'required|exists:produks,id',
            'jumlah.*' => 'required|integer|min:1',
            'total_harga.*' => 'required|numeric|min:0',
        ]);

        $bukti_identitas_path = $request->file('bukti_identitas')->store('bukti_identitas', 'public');
        
        $sewas = [];
        foreach ($validated['id_barang'] as $key => $produk_id) {
            $sewa = new Sewa;
            $sewa->produk_id = $produk_id;
            $sewa->user_id = Auth::id();
            $sewa->tanggal_sewa = $validated['tanggal_sewa'];
            $sewa->tanggal_pengembalian = $validated['tanggal_pengembalian'];
            $sewa->jumlah = $validated['jumlah'][$key];
            $sewa->total_harga = $validated['total_harga'][$key];
            $sewa->bukti_identitas = $bukti_identitas_path;
            $sewa->status = 'pending';
            $sewa->save();

            $sewas[] = $sewa;
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => array_sum($validated['total_harga']),
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('pelanggan.payment', compact('snapToken', 'sewas'));
    }
    public function show()
    {
        $produks = Produk::all();
       
        
        return view('index', compact('produks'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->$order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($request->transaction_status == 'capture'){
            $sewa = Sewa::find($request->order_id);
            $sewa->update(['status' => 'paid']);
        }
    }
}
