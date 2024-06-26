<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\KeranjangController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [ProdukController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/barang', function () {
        return view('admin.barang');
    })->name('admin.barang');
    Route::post('/add_to_cart', [CartController::class, 'store']);
Route::view('/', 'product');
    
    // Route::get('/kategori', function () {
    //     return view('admin.kategori');
    // })->name('admin.kategori');
    // Route::resource('/kategori', KategoriController::class)->names('admin.kategori');
    Route::resource('kategori', KategoriController::class);

    //produk
    Route::get('/barang', [ProdukController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [ProdukController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [ProdukController::class, 'store'])->name('barang.store');
    Route::get('/barang/{barang}/edit', [ProdukController::class, 'edit'])->name('admin.barang.edit');
    Route::put('/barang/{barang}', [ProdukController::class, 'update'])->name('admin.barang.update');
    // Route::get('/barang/{barang}/edit', [ProdukController::class, 'edit'])->name('barang.edit');
    // Route::put('/barang/{barang}', [ProdukController::class, 'update'])->name('barang.update'); 
    Route::delete('/barang/{barang}', [ProdukController::class, 'destroy'])->name('barang.destroy');



    //keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/store', [KeranjangController::class, 'store'])->name('keranjang.store');

    //akun
    Route::get('/akun', [AuthController::class, 'kelolaPengguna'])->name('pengguna.index');
    Route::delete('/akun/{user}', [AuthController::class, 'destroy'])->name('users.destroy');
    Route::post('/akun', [AuthController::class, 'store'])->name('pengguna.store');
    Route::put('/akun/{user}/update', [AuthController::class, 'update'])->name('pengguna.update');
Route::get('/akun/{user}/edit', [AuthController::class, 'edit'])->name('pengguna.edit');



    Route::get('/akun/show', [AuthController::class, 'edit'])->name('client.edit');

    //checkout



    //laporan
    Route::get('/laporan', function () {
        return view('laporan.index');
    })->name('laporan.index');

   //penyewaan
    Route::get('/', [SewaController::class, 'index'])->name('index');


    Route::get('/keranjang', function () {
        return view('checkout.keranjang.index');
    })->name('keranjang.index');
    });


   

    Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/', function () {
    return view('index');
});
// Route::get('/login', function () {
//     return view('login.index');
// });

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_proses'])->name('register_proses');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-proses', [AuthController::class, 'login_proses'])->name('login-proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [SewaController::class, 'show'])->name('index');

Route::get('/home', [HomeController::class, 'index'])->name('home');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
