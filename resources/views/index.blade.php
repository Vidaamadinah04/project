<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Heroic Features - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="lp/assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="lp/css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-lg-5">
            <a class="navbar-brand" href="">Sufi Outdoor</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Masuk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#s&k">Syarat & Ketentuan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="py-5">
        <div class="container px-lg-5">
            <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                <div class="m-4 m-lg-5">
                    <h1 class="display-5 fw-bold">Selamat datang!</h1>
                    <p class="fs-4"> di Sufi Outdoor</p>
                    <a class="btn btn-primary btn-lg" href="#koleksi">Koleksi</a>
                </div>
            </div>
        </div>
       <br>
       <br>
       <br>
    </header>
    <!-- Page Content-->
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
                      {{-- <p class="mb-0">Rp.{{ $produk->harga }}</p> --}}
                      <p class="mb-0">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
          <br>
          <a href="#productDetailsModal{{ $produk->id }}" data-bs-toggle="modal" data-bs-target="#productDetailsModal{{ $produk->id }}" class="btn btn-primary"> Detail Produk</a>

          

        </div>
      </div>
    </div>
     <!-- Product Details Modal -->
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
                            <p class="mb-0">Harga : Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                            <p>Stok: {{ $produk->jumlah_unit }}</p>
                            <p>Deskripsi: {{ $produk->deskripsi }}</p>
                            <div class="mb-2">
                                <label for="quantity{{ $produk->id }}" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity{{ $produk->id }}" name="cart_qty" min="1" max="{{ $produk->jumlah_unit }}" required>
                            </div>
                            <form action="{{ route('pelanggan.keranjang.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <button type="submit" a href="/login" class="btn btn-primary">+ Keranjang</button>
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
    <section id="s&k" class="pt-3"> 
        <div class="container px-lg-3">
        <div class="row">
            <div class="policy-section">
                <h2>Informasi Pembayaran dan Kebijakan Kerusakan</h2>
        
                <div class="policy-content">
                    <h3>Deposit</h3>
                    <p>Untuk setiap penyewaan barang, diperlukan pembayaran uang muka sebesar <strong>50%</strong> dari total biaya sewa. Pembayaran ini akan diambil sebagai jaminan dan akan dikurangi dari total biaya sewa pada saat checkout.</p>
                </div>
        
                <div class="policy-content">
                    <h3>Kebijakan Kerusakan</h3>
                    <p>Kami sangat menjaga kualitas barang yang kami sewakan. Namun, jika terjadi kerusakan pada barang selama masa sewa, tanggung jawab atas biaya perbaikan atau penggantian barang yang rusak akan ditanggung oleh penyewa. Harap pastikan untuk memeriksa barang sebelum menggunakannya dan melaporkan setiap kerusakan yang ada saat menerima barang.</p>
                </div>
        
              
            </div>
        </div>
    </section>
    <!-- Footer-->
    {{-- <footer class="py-5 bg-dark" id="kontak">
        <div class="container">
            <a href="https://wa.me/083148763559" target="_blank" style="text-decoration: none; color: inherit;">
                <img src="public/admin/assets/img/WhatsApp.svg" alt="WhatsApp" style="width: 20px; height: 20px; vertical-align: middle;">
                083148763559
              </a>        
        </div>
    </footer> --}}
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="lp/js/scripts.js"></script>
</body>

</html>
