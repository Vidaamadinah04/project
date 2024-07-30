<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Keranjang;
use App\Models\Sewa;
use App\Models\Produk;
use App\Models\DetailSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function showForm(Request $request)
    {
        $ids = $request->input('id_barang');
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada barang yang dipilih untuk checkout.');
        }

        $keranjang = auth()->user()->keranjang()->whereIn('produk_id', $ids)->get();

        if ($keranjang->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong atau produk tidak ditemukan.');
        }

        return view('pelanggan.checkout', compact('keranjang'));
    }

    public function processCheckout(Request $request)
    {
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

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        \Log::info('Midtrans Server Key: ' . Config::$serverKey);
        \Log::info('Midtrans Client Key: ' . config('services.midtrans.client_key'));

        $params = array(
            'transaction_details' => array(
                'order_id' => $sewa->id,
                'gross_amount' => $request->total_harga,
            ),
            'customer_details' => array(
                'first_name' => auth()->user()->username,
                'last_name' => '',
                'email' => auth()->user()->email,
            ),
        );

        $snapToken = Snap::getSnapToken($params);
        return view('pelanggan.payment', compact('snapToken', 'sewa'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $sewa = Sewa::find($request->order_id);

            if ($sewa) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $sewa->update(['status' => 'Paid']);
                } else {
                    $sewa->update(['status' => 'Failed']);
                }
            } else {
                \Log::warning('Sewa tidak ditemukan dengan ID: ' . $request->order_id);
            }
        } else {
            \Log::warning('Signature key tidak cocok untuk order_id: ' . $request->order_id);
        }
    }
}
