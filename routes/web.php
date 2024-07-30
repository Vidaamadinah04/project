<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\Auth\RegisterController;


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
    // Route::post('/add_to_cart', [CartController::class, 'store']);
    Route::view('/', 'product');
    Route::middleware(['role:admin'])->group(function () {

    Route::resource('kategori', KategoriController::class);
    Route::get('kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    });
    //produk
    Route::get('/barang', [ProdukController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [ProdukController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [ProdukController::class, 'store'])->name('barang.store');
    Route::get('/barang/{barang}/edit', [ProdukController::class, 'edit'])->name('admin.barang.edit');
    Route::put('/barang/{barang}', [ProdukController::class, 'update'])->name('admin.barang.update');
    Route::delete('/barang/{barang}', [ProdukController::class, 'destroy'])->name('barang.destroy');
    Route::get('/total-products', [ProdukController::class, 'getTotalProducts']);
    //keranjang
    Route::middleware('role:pelanggan')->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'keranjang'])->name('pelanggan.keranjang.index');
    Route::post('/keranjang/store', [KeranjangController::class, 'tambahKeranjang'])->name('pelanggan.keranjang.store');    });
    Route::delete('/hapus-keranjang/{id}', [KeranjangController::class, 'removeFromKeranjang'])->name('hapus.keranjang');
    Route::put('/keranjang/{keranjang_id}/tambah-quantity', [KeranjangController::class, 'tambahQuantity'])->name('tambah.quantity');
    //akun
    Route::middleware(['role:admin'])->group(function () {
    Route::get('/akun', [AuthController::class, 'kelolaPengguna'])->name('admin.pengguna');
    Route::delete('/akun/{user}', [AuthController::class, 'destroy'])->name('users.destroy');
    Route::post('/akun', [AuthController::class, 'store'])->name('pengguna.store');
    Route::put('/akun/{user}', [AuthController::class, 'update'])->name('pengguna.update');
    Route::get('/akun/{user}/edit', [AuthController::class, 'edit'])->name('pengguna.edit');
    Route::get('/total-users', [AuthController::class, 'getTotalUsers']);
    Route::get('/akun/show', [AuthController::class, 'edit'])->name('client.edit');
    });
    //laporan
    Route::get('/laporan-penyewaan', [LaporanController::class, 'index'])->name('admin.laporan');
    // Route::get('/laporan', function () {
    //     return view('admin.laporan');
    // })->name('admin.laporan');
    //checkout
    Route::get('/checkout', [CheckoutController::class, 'showForm'])->name('pelanggan.checkout');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    });
    //payment
    Route::post('/checkout', [SewaController::class, 'store'])->name('pelanggan.payment');
    Route::post('/midtrans-callback', [SewaController::class, 'midtrans.callback']);
    // Route::get('/', function () {
    // return view('index');
    // });
    //search
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_proses'])->name('register_proses');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-proses', [AuthController::class, 'login_proses'])->name('login-proses');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [SewaController::class, 'show'])->name('index');
    // Route::get('/', [HomeController::class, 'show'])->name('index');
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  