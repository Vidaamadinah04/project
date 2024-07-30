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

        <li>
          <a href="./notifications.html">
            <i class="nc-icon nc-credit-card"></i>
            <p>Transaksi</p>
          </a>
        </li>
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
  