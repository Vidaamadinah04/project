<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Keranjang;
use App\Models\Sewa;
use App\Models\Produk;
use App\Models\DetailSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    $produk_id = $request->id_barang;    
    $produk = Produk::find($produk_id);
    if (!$produk) {
        return redirect()->back()->withErrors(['Produk tidak ditemukan']);
    }
    $user_id = Auth::id();
    $sewa = Sewa::create([
                'user_id' => $user_id,
                'produk_id' => $produk_id,
                'bukti_identitas' => $buktiIdentitasPath,
                'tanggal_sewa' => $request->tanggal_sewa,
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'jumlah' => $request->jumlah,
                'total_harga' => $request->total_harga,
                'status' => 'pending', 
            ]);
        
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;
            // \Midtrans\Config::$serverKey = 'SB-Mid-server-2DLXSd04QEvbBxSAFPEI-OgN';
            // \Midtrans\Config::$isProduction = false;
            // \Midtrans\Config::$isSanitized = true;
            // \Midtrans\Config::$is3ds = true;
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

            $snapToken =\Midtrans\Snap::getSnapToken($params);
            return view('pelanggan.payment', compact('snapToken', 'sewa'));
}

public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
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
// public function callback(Request $request)
// {
//     $serverKey = config('midtrans.server_key');
//     $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

//     if ($hashed == $request->signature_key) {
//         // Temukan objek sewa berdasarkan order_id yang diterima
//         $sewa = Sewa::find($request->order_id);
        
//         if ($sewa) {
//             // Update status sewa
//             $sewa->update(['status' => 'Paid']);
//         } else {
//             // Tangani kasus jika sewa tidak ditemukan
//             \Log::warning('Sewa tidak ditemukan dengan ID: ' . $request->order_id);
//         }
//     } else {
//         // Tangani kasus jika signature_key tidak cocok
//         \Log::warning('Signature key tidak cocok untuk order_id: ' . $request->order_id);
//     }
// //    $serverKey = config('midtrans.server_key');
// //    $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
// //    if($hashed == $request->signature_key){
// //     $sewa == Sewa::find($request->order_id);
// //     $sewa->update(['status' => 'Paid']);
// //    }
// }

}
