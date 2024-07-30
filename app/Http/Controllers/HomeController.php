<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
        // return view('dashboard');
        public function index()
    {
        if (auth()->user()->role == 'admin'){
            return view('dashboard');
        } else if (auth()->user()->role == 'users'){
            return view ('pelatih.dashboard');
        }
    }
    public function show()
    {
        $produks = Produk::all(); // Mengambil semua data produk
        dd($produks);
        return view('index', compact('produks')); // Mengirimkan data ke view
    }
}
