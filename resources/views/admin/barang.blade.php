@extends('layout.main')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1>Produk</h1>
    <!-- Button trigger modal -->
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
                            <input type="text" class="form-control" id="harga" name="harga"  required>
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
                                <button class="btn btn-primary btn-sm" onclick="showDetailModal({{ $produk }})">Sewa</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                        <input type="text" class="form-control" id="edit_harga" name="harga" required>
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


<!-- Modal Detail Produk -->
<div class="modal fade" id="detailProductModal" tabindex="-1" aria-labelledby="detailProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailProductModalLabel">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="detailProductImage" src="" class="img-fluid" alt="Gambar Produk">
                    </div>
                    <div class="col-md-6">
                        <h2 id="detailProductName" font-weight: bold;></h2>
                        <p id="detailProductCategory"></p>
                        <p id="detailProductPrice" style="color: red;"></p>
                        <div class="pro-qty">
                            <label for="quantity" class="form-label">Jumlah:</label>
                            <input type="number" id="quantity" name="cart_qty" value="1" min="1" class="form-control">
                        </div>
                        
                        <a href="{{ route('keranjang.index') }}" button class="btn btn-danger mt-3"  >Tambah ke Keranjang</a>
                    </div>
                </div>
                <hr>
                <div>
                    <h5>Stok Produk</h5>
                    <p id="detailProductQuantity"></p>
                </div>
                <div>
                    <h4>Deskripsi Produk</h4>
                    <p id="detailProductDescription"></p>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showDetailModal(produk) {
        document.getElementById('detailProductImage').src = '{{ asset('storage/') }}/' + produk.gambar;
        document.getElementById('detailProductName').innerText = produk.nama_produk;
        document.getElementById('detailProductCategory').innerText = 'Kategori: ' + produk.kategori.nama_kategori;
        document.getElementById('detailProductPrice').innerText = 'Rp. ' + produk.harga;
        document.getElementById('detailProductDescription').innerText = produk.deskripsi;
        document.getElementById('detailProductQuantity').innerText = produk.jumlah_unit;

        var detailProductModal = new bootstrap.Modal(document.getElementById('detailProductModal'));
        detailProductModal.show();
    }

    function openEditModal(id) {
    // Ambil data produk berdasarkan id
    var produk = @json($produks).find(p => p.id === id);

    // Isi form edit dengan data produk
    document.getElementById('edit_id').value = produk.id;
    document.getElementById('edit_kategori_id').value = produk.kategori_id;
    document.getElementById('edit_nama_produk').value = produk.nama_produk;
    document.getElementById('edit_jumlah_unit').value = produk.jumlah_unit;
    document.getElementById('edit_deskripsi').value = produk.deskripsi;
    document.getElementById('edit_harga').value = produk.harga;

    // Set action form untuk update
    document.getElementById('editProductForm').action = "/barang/" + produk.id;

    // Buka modal edit
    var editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
    editProductModal.show();
}
</script>
</script>
@endsection
