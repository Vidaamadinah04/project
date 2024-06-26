@extends('layouts.keranjang.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<section id="keranjang" class="pt-4">
    <div class="container px-lg-4">
        <h2 class="fs-4 fw-bold">Keranjang Belanja</h2>
        <div class="alert alert-success" role="alert">
            Pilih voucher Gratis Ongkir untuk menikmati Gratis Ongkir
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"><input type="checkbox"></th>
                    <th scope="col">Produk</th>
                    <th scope="col">Harga Satuan</th>
                    <th scope="col">Kuantitas</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                @foreach ($keranjang as $item)
                <tr>
                    <td><input type="checkbox"></td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->harga * $item->jumlah }}</td>
                    <td><button class="btn btn-danger btn-sm">Hapus</button></td>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
