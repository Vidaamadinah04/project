@extends('layout.main')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1>Produk</h1>
    @if(isset($produks))
    {{-- <p>Variabel $produks ditemukan dengan jumlah {{ $produks->count() }} produk.</p>
@else
    <p>Variabel $produks tidak ditemukan.</p> --}}
@endif
    <!-- Button trigger modal -->
    @if (auth()->user()->hasRole('admin'))

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#productModal">
        Tambah Produk
    </button>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Form Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option disabled selected>Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_unit" class="form-label">Jumlah Unit</label>
                            <input type="number" class="form-control" id="jumlah_unit" name="jumlah_unit" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga"  required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Edit Produk -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Form Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="editProductForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_kategori_id">Kategori</label>
                        <select name="kategori_id" id="edit_kategori_id" class="form-control" required>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="edit_nama_produk" name="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="edit_gambar" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah_unit" class="form-label">Jumlah Unit</label>
                        <input type="number" class="form-control" id="edit_jumlah_unit" name="jumlah_unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="edit_harga" name="harga" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Produk</h4>
        </div>
        <div class="card-body">
            <div class="table">
                <table class="table">
                    <thead class="text-dark">
                        <tr>
                            <th>NO</th>
                            <th>KATEGORI</th>
                            <th>NAMA PRODUK</th>
                            <th>GAMBAR</th>
                            <th>JUMLAH UNIT</th>
                            <th>DESKRIPSI</th>
                            <th>HARGA</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produks as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produk->kategori->nama_kategori }}</td>
                            <td>{{ $produk->nama_produk }}</td>
                            <td>
                                @if($produk->gambar)
                                {{-- <img src="{{ asset('public/admin/assets/pic/'.$produk->gambar) }}" alt="gambar_produk" width="50" height="50"> --}}
                                <img src="{{ asset('storage/'.$produk->gambar) }}" alt="gambar_produk" width="50" height="50">

                                @else
                                Tidak ada gambar
                                @endif
                            </td>
                            <td>{{ $produk->jumlah_unit }}</td>
                            <td>{{ $produk->deskripsi }}</td>
                            <td>{{ $produk->harga }}</td>
                            <td>
                                <button onclick="openEditModal({{ $produk->id }})" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('barang.destroy', $produk->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin Produk ini Akan dihapus?')"> <i class="fas fa-trash"></i>Delete</button>
                                </form>
                                {{-- <button class="btn btn-primary btn-sm" onclick="showDetailModal({{ $produk }})">Sewa</button> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

    

@if (auth()->user()->hasRole('pelanggan'))
<section id="koleksi" class="pt-3">
    <div class="container px-lg-3">
        <!-- Page Features-->
        <div class="row">
            @foreach($produks as $produk)
            <div class="col-lg-3 mb-5">
                <div class="card bg-light border-0 h-80">
                    <div class="card-body text-center p-3 p-lg-5 pt-0 pt-lg-0">
                        <a href="#productDetailsModal{{ $produk->id }}" data-bs-toggle="modal" data-bs-target="#productDetailsModal{{ $produk->id }}">
                            <img src="{{ asset('storage/'. $produk->gambar) }}" class="img-fluid mb-3" alt="{{ $produk->nama_produk }}">
                        </a>
                        <h2 class="fs-4 fw-bold">{{ $produk->nama_produk }}</h2>
                        <p class="mb-0">Rp. {{ $produk->harga }}</p>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#productDetailsModal{{ $produk->id }}">Sewa</button>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Produk -->
            <div class="modal fade" id="productDetailsModal{{ $produk->id }}" tabindex="-1" aria-labelledby="productDetailsModalLabel{{ $produk->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productDetailsModalLabel{{ $produk->id }}">Detail Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/'. $produk->gambar) }}" alt="{{ $produk->nama_produk }}" width="200" height="200" class="img-fluid mb-3">
                                </div>
                                <div class="col-md-8">
                                    <h5>{{ $produk->nama_produk }}</h5>
                                    <p>Harga: Rp. {{ $produk->harga }}</p>
                                    <p>Stok: {{ $produk->jumlah_unit }}</p>
                                    <p>Deskripsi: {{ $produk->deskripsi }}</p>
                                    <form action="{{ route('pelanggan.keranjang.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                        <div class="mb-2">
                                            <label for="quantity{{ $produk->id }}" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="quantity{{ $produk->id }}" name="cart_qty" min="1" max="{{ $produk->jumlah_unit }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @endforeach
        </div>
    </div>
</section>
@endif




@endsection

@section('js')
<script>
    function showDetailModal(produk) {
        document.getElementById('detailProductImage').src = '{{ asset('storage/') }}/' + produk.gambar;
        document.getElementById('detailProductName').innerText = produk.nama_produk;
        document.getElementById('detailProductPrice').innerText = 'Rp. ' + produk.harga;
        document.getElementById('detailProductQuantity').innerText = 'Stok: ' + produk.jumlah_unit;

        document.getElementById('product_id').value = produk.id;
        document.getElementById('nama_produk').value = produk.nama_produk;
        document.getElementById('product_price').value = produk.harga;

        var detailProductModal = new bootstrap.Modal(document.getElementById('detailProductModal'));
        detailProductModal.show();
    }

    function openEditModal(id) {
        var produks = @json($produks); // Pastikan $produks didefinisikan dan di-passing dari controller ke view
        var produk = produks.find(p => p.id === id);

        if (produk) {
            document.getElementById('edit_id').value = produk.id;
            document.getElementById('edit_kategori_id').value = produk.kategori_id;
            document.getElementById('edit_nama_produk').value = produk.nama_produk;
            document.getElementById('edit_jumlah_unit').value = produk.jumlah_unit;
            document.getElementById('edit_deskripsi').value = produk.deskripsi;
            document.getElementById('edit_harga').value = produk.harga;

            document.getElementById('editProductForm').action = "/barang/" + produk.id;

            var editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editProductModal.show();
        } else {
            console.error('Produk tidak ditemukan dengan ID:', id);
        }
    }

    function navigateToCheckout(produkId) {
        // Redirect to checkout page with produkId as parameter
        window.location.href = 'sewa.index';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Event listener untuk tombol tambah ke keranjang
        document.querySelectorAll('.btn-add-to-cart').forEach(button => {
            button.addEventListener('click', async function () {
                const produkId = this.getAttribute('data-product-id');
                const quantity = document.querySelector(`#quantity-${produkId}`).value;

                try {
                    const response = await fetch('{{ route('pelanggan.keranjang.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            produk_id: produkId,
                            cart_qty: quantity
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menambahkan produk ke keranjang.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

@endsection
