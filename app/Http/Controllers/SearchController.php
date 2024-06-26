<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\User; // Contoh model, sesuaikan dengan kebutuhan Anda

class SearchController extends Controller
{
    public function search(Request $request)
    {

        // $data['produks'] = $this->roduks->Query()->where('name','like','%'.$request->q. '%')->paginate
        // (12);
        $query = $request->input('query');
        $results = Produk::where('id', 'like', "%$query%")
        ->orWhere('deskripsi', 'like', "%$query%")
        ->get();

        return view('admin.search', compact('results','query'));
    }
}
