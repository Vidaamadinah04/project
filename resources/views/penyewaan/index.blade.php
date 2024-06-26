@extends('layouts.app')

@section('css')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<style>
    .modal-content {
        background-color: white;
    }
</style>
@endsection

@section('content')

<section id="koleksi" class="pt-4">
    <div class="container px-lg-4">
        <!-- Page Features-->
        <div class="row">
            @foreach($produks as $produk)
<div class="col-lg-4 mb-5">
  <div class="card bg-light border-0 h-80">
    <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
      <a href="#productDetailsModal{{ $produk->id }}" data-bs-toggle="modal" data-bs-target="#productDetailsModal{{ $produk->id }}">
        <img src="{{ asset('storage/'. $produk->gambar) }}" class="img-fluid mb-3" alt="{{ $produk->nama_produk }}">
      </a>
      <h2 class="fs-4 fw-bold">{{ $produk->nama_produk }}</h2>
      <p class="mb-0">Rp.{{ $produk->harga }}</p>
    </div>
  </div>
</div>

<div class="modal fade" id="productDetailsModal{{ $produk->id }}" tabindex="-1" aria-labelledby="productDetailsModalLabel{{ $produk->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productDetailsModalLabel{{ $produk->id }}">Detail  Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-product-content">
        <!-- Isi konten modal di sini -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ttuo</button>
          <a href="#" class="btn btn-primary">Add to Cart</a>
        </div>
      </div>
    </div>
  </div>
@endforeach

    </div>
</section>

@endsection
