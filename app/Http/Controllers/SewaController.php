<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Sewa;
use Midtrans\Config;
use App\Models\Produk;
use App\Models\DetailSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'bukti_identitas' => 'required|file|mimes:jpg,png,jpeg',
            'tanggal_sewa' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_sewa',
            'id_barang.*' => 'required|exists:produks,id',
            'jumlah.*' => 'required|integer|min:1',
            'total_harga.*' => 'required|numeric|min:0',
        ]);

        $buktiIdentitasPath = $request->file('bukti_identitas')->store('bukti_identitas');
        $produk_ids = $request->id_barang;

        $user_id = Auth::id();

        $total = 0;

        // Buat transaksi sewa
        $sewa = Sewa::create([
            'user_id' => $user_id,
            'bukti_identitas' => $buktiIdentitasPath,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'total_harga' => $total,
            'status' => 'pending',
        ]);

        // Buat detail transaksi sewa
        foreach ($produk_ids as $index => $produk_id) {
            $produk = Produk::find($produk_id);
            if (!$produk) {
                return redirect()->back()->withErrors(['Produk tidak ditemukan']);
            }

            DetailSewa::create([
                'sewa_id' => $sewa->id,
                'produk_id' => $produk_id,
                'jumlah' => $request->jumlah[$index],
                'sub_total' => $request->total_harga[$index],
            ]);

            $total += $request->total_harga[$index];
        }

        $sewa->update(['total_harga'=>$total]);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction =  false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // \Log::info('Midtrans Server Key: ' . Config::$serverKey);
        // \Log::info('Midtrans Client Key: ' . config('services.midtrans.client_key'));

        $params = [
            'transaction_details' => [
                'order_id' => $sewa->id,
                'gross_amount' => $sewa->total_harga,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('pelanggan.payment', compact('snapToken', 'sewa'));
    
    }
    public function show()
    {
        $produks = Produk::all();
       
        
        return view('index', compact('produks'));
    }

    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $message = '';
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($request->transaction_status == 'settlement'){
            $message='ok';
            $sewa = Sewa::find($request->order_id);
            $sewa->update(['status' => 'paid']);
        }else{
            $message = 'not ok';
        }
        return response()->json([
            'message' => $message
        ]);
    }
}
