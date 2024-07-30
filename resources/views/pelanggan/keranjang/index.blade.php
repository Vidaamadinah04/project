@extends('layout.main')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4">Keranjang Belanja</h1>

    <form id="cart-form">
        @csrf
        @if (count($keranjang) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Foto Produk</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keranjang as $cart)
                    <tr>
                        <td>
                            <input name="id_barang[]" value="{{ $cart->produk->id}}" type="checkbox" class="product-checkbox" data-cart-id="{{ $cart->id }}" data-harga="{{ $cart->produk->harga }}" onchange="updateCheckoutTotal()">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="icon-shape icon-md border p-4 rounded-1">
                                        <img src="{{ asset('storage/admin/assets/pic/'  . basename($cart->produk->gambar)) }}"
                                            alt="" style="width: 30px; height: 30px;">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $cart->produk->nama_produk }}</td>
                        <td>
                            <form action="{{ route('tambah.quantity', ['keranjang_id' => $cart->id]) }}" method="post"
                                style="display: inline;">
                                @csrf
                                @method('put')
                                <input type="hidden" name="jumlah" id="jumlah_{{ $cart->id }}"
                                    value="{{ $cart->jumlah }}">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    onclick="updateQuantity('{{ $cart->id }}', -1)" {{ $cart->jumlah }}>-</button>
                            </form>

                            {{-- Tampilkan jumlah --}}
                            <span id="display_jumlah_{{ $cart->id }}">{{ $cart->jumlah }}</span>

                            <form action="{{ route('tambah.quantity', ['keranjang_id' => $cart->id]) }}" method="post"
                                style="display: inline;">
                                @csrf
                                @method('put')
                                <input type="hidden" name="jumlah" id="jumlah_{{ $cart->id }}"
                                    value="{{ $cart->jumlah }}">
                                <button type="button" class="btn btn-sm btn-primary"
                                    onclick="updateQuantity('{{ $cart->id }}', 1)">+</button>
                            </form>
                        </td>
                        <td>{{ $cart->produk->harga }}</td>
                        <td><span id="sub_total_{{ $cart->id }}">{{ $cart->sub_total }}</span></td>

                        <td>
                            <form action="{{ route('hapus.keranjang', ['id' => $cart->id]) }}" method="post"
                                style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row mt-4 justify-content-end">
            <div class="col-md-6 text-md-end">
                <strong>Total Harga:</strong> Rp <span id="total">0.00</span>
            </div>
        </div>

        <!-- Tombol Checkout -->
        <div class="row mt-4 justify-content-end">
            <div class="col-md-6 text-md-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal" onclick="fillCheckoutForm()">Checkout</button>
            </div>
        </div>
    </form>
    @else
        <p class="mt-4">Keranjang belanja Anda kosong.</p>
    @endif

    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="checkout-form" action="{{ route('pelanggan.payment') }}" method="post" enctype="multipart/form-data">
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
                        <div id="checkout-products"></div>
                        <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateQuantity(cartId, increment) {
            var jumlahElement = document.getElementById('jumlah_' + cartId);
            var displayJumlahElement = document.getElementById('display_jumlah_' + cartId);
            var subTotalElement = document.getElementById('sub_total_' + cartId);

            var jumlah = parseInt(jumlahElement.value) + increment;

            if (jumlah >= 1) {
                jumlahElement.value = jumlah;
                displayJumlahElement.innerHTML = jumlah;

                // Retrieve product price dynamically from data attribute
                var harga = parseFloat(document.querySelector('.product-checkbox[data-cart-id="' + cartId + '"]').dataset.harga);
                var subTotal = jumlah * harga;
                subTotalElement.innerHTML = subTotal.toFixed(2);

                // Update nilai pada form sebelum submit
                document.getElementById('jumlah_' + cartId).value = jumlah;

                // Update total
                updateCheckoutTotal();
            }
        }

        function updateCheckoutTotal() {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            var subtotal = 0;

            checkboxes.forEach(function (checkbox) {
                var cartId = checkbox.dataset.cartId;
                var jumlahElement = document.getElementById('jumlah_' + cartId);
                var subTotalElement = document.getElementById('sub_total_' + cartId);

                if (checkbox.checked) {
                    var harga = parseFloat(checkbox.dataset.harga);
                    var jumlah = parseInt(jumlahElement.value);
                    var subTotal = jumlah * harga;
                    subtotal += subTotal;

                    subTotalElement.innerHTML = subTotal.toFixed(2);
                }
            });

            // Update subtotal and total in the DOM
            document.getElementById('total').innerHTML = subtotal.toFixed(2);
        }

        function fillCheckoutForm() {
            var checkboxes = document.querySelectorAll('.product-checkbox:checked');
            var checkoutProductsContainer = document.getElementById('checkout-products');
            checkoutProductsContainer.innerHTML = '';

            checkboxes.forEach(function (checkbox) {
                var cartId = checkbox.dataset.cartId;
                var jumlah = document.getElementById('jumlah_' + cartId).value;
                var produkNama = checkbox.closest('tr').querySelector('td:nth-child(3)').innerText;
                var subTotal = document.getElementById('sub_total_' + cartId).innerText;

                var productDetail = `
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">${produkNama}</h5>
                            <p class="card-text">Jumlah: ${jumlah}</p>
                            <p class="card-text">Subtotal: Rp ${subTotal}</p>
                            <input type="hidden" name="id_barang[]" value="${checkbox.value}">
                            <input type="hidden" name="jumlah[]" value="${jumlah}">
                            <input type="hidden" name="total_harga[]" value="${subTotal}">
                        </div>
                    </div>
                `;

                checkoutProductsContainer.insertAdjacentHTML('beforeend', productDetail);
            });
        }
    </script>
</div>
@endsection
