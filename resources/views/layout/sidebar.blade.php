<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
      <a href="https://www.creative-tim.com" class="simple-text logo-mini">
        
        <!-- <p>CT</p> -->
      </a>
      <img src="{{ asset('admin/assets/img/sufi.jpeg') }}" alt="" style="max-height: 50px;">
      Sufi Outdoor
        <!-- <div class="logo-image-bg">
          <img src="assets/img/logo-big.png">
        </div> -->
      </a>
    </div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        <li class="nav-item  ">
          <a href="{{ route('admin.dashboard') }}">
            <i class="nc-icon nc-bank"></i>
            <p>Dashboard</p>
          </a>
        </li>
        @if (auth()->user()->hasRole('admin'))
        <li class="nav-item  ">
          <a href="{{ route('kategori.index') }}" >
            <i class="nc-icon nc-tile-56"></i>
            <p>Kategori</p>
          </a>
        </li>
        @endif
    
              <li>
                <a href="{{ route('barang.index') }}">
                    <i class="nc-icon nc-box"></i>
                    <p>Produk</p>
                </a>
                <ul class="collapse list-unstyled" id="productSubmenu">
                    <li>
                        <a href="#">Detail Barang</a>
                    </li>
                </ul>
          </li>
        
          @if (auth()->user()->hasRole('admin'))

        {{-- <li>
          <a href="./notifications.html">
            <i class="nc-icon nc-credit-card"></i>
            <p>Transaksi</p>
          </a>
        </li> --}}
        @endif
        <li>
          <a href="{{ route('admin.laporan') }}">
            <i class="nc-icon nc-paper"></i>
            <p>Laporan</p>
          </a>
        </li>
        @if (auth()->user()->hasRole('admin'))
        <li>
          <a href="{{ route('admin.pengguna') }}">
            <i class="nc-icon nc-circle-10"></i>
            <p>Kelola Akun Pengguna</p>
          </a>
        </li>   
        {{-- <li>
          <a href="{{ route('kelola.status.pembayaran') }}">
            <i class="nc-icon nc-paper"></i>
            <p>Kelola Status Pembayaran</p>
          </a>
        </li> --}}
        <li>
          <a href="#pemesananSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="nc-icon nc-paper"></i>
            <p>Kelola Pemesanan</p>
          </a>
          <ul class="collapse list-unstyled" id="pemesananSubmenu">
            <li>
              <a href="{{ route('admin.pemesanan.index') }}">
                <i class="nc-icon nc-bullet-list-67"></i>
                <p>Semua Pemesanan</p>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.pemesanan.proses') }}">
                <i class="nc-icon nc-check-2"></i>
                <p>Proses Pemesanan</p>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.pemesanan.selesai') }}">
                <i class="nc-icon nc-delivery-fast"></i>
                <p>Pemesanan Selesai</p>
              </a>
            </li>
          </ul>
        </li>
        
        @endif
        
        {{-- <li>
          <a href="./user.html">
            <i class="nc-icon nc-box"></i>
            <p>Kelola Barang</p>
          </a>
        </li>
        <li>
          <a href="./user.html">
            <i class="nc-icon nc-bag-16"></i>
            <p>Kelola Kategori Barang</p>
          </a>
        </li>
        <li>
          <a href="./user.html">
            <i class="nc-icon nc-paper"></i>
            <p>Kelola Laporan</p>
          </a>
        </li> --}}
        
       
        
      </ul>
    </div>
  </div>
  