@extends('layout.main')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4">Checkout</h1>

    <form action="{{ route('pelanggan.payment') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="bukti_identitas" class="form-label">Bukti Identitas</label>
            <input type="file" class="form-control" id="bukti_identitas" name="bukti_identitas" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
            <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
            <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
        </div>
        <h3 class="mt-4">Detail Produk</h3>
        @foreach ($keranjang as $cart)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $cart->produk->nama_produk }}</h5>
                    <p class="card-text">Jumlah: {{ $cart->jumlah }}</p>
                    <p class="card-text">Subtotal: Rp {{ $cart->sub_total }}</p>
                    <input type="hidden" name="id_barang" value="{{ $cart->produk->id }}">
                    <input type="hidden" name="jumlah" value="{{ $cart->jumlah }}">
                    <input type="hidden" name="total_harga" value="{{ $cart->sub_total }}">
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
    </form>
</div>
@endsection