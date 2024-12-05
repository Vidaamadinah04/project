<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Sewa;
use Midtrans\Config;
use App\Models\Produk;
use App\Models\DetailSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_sewa' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_sewa',
            'id_barang.*' => 'required|exists:produks,id',
            'jumlah.*' => 'required|integer|min:1',
            'total_harga.*' => 'required|numeric|min:0',
        ]);

        $produk_ids = $request->id_barang;
        $user_id = Auth::id();
        $total = 0;

        $sewa = Sewa::create([
            'user_id' => $user_id,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'total_harga' => $total,
            'status' => 'pending',
        ]);

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

        $sewa->update(['total_harga' => $total]);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        Log::info('Midtrans Server Key: ' . Config::$serverKey);
        Log::info('Midtrans Client Key: ' . config('services.midtrans.client_key'));

        $order_id = $sewa->id . '-' . time();
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $sewa->total_harga,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->username,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
        ];

        Log::info('Snap Token Params: ', $params);

        try {
            $snapToken = Snap::getSnapToken($params);
            Log::info('Snap Token: ' . $snapToken);
            return view('pelanggan.payment', compact('snapToken', 'sewa'));
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Gagal membuat transaksi pembayaran.']);
        }
    }

    public function show()
    {
        $produks = Produk::all();
        return view('index', compact('produks'));
    }

    public function callback(Request $request)
    {
        Log::info('Callback received: ', $request->all());

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        $message = '';

        // Extract the original order_id (before the timestamp addition)
        $order_id_parts = explode('-', $request->order_id);
        $sewa_id = $order_id_parts[0];

        if ($request->transaction_status == 'settlement') {
            $message = 'ok';
            $sewa = Sewa::find($sewa_id);
            if ($sewa) {
                $sewa->update(['status' => 'paid']);
            }
        } else {
            $message = 'not ok';
        }

        return response()->json(['message' => $message]);
    }

    public function index()
    {
        $sewas = Sewa::with('user')->get();
        return view('admin.status_pembayaran', compact('sewas'));
    }
}
