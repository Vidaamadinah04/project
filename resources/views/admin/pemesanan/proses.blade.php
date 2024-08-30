@extends('layout.main')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Proses Pemesanan</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-centered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Username</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pemesanans as $pemesanan)
                                @foreach($pemesanan->details as $detail)
                                    <tr>
                                        <td>{{ $loop->parent->iteration }}</td>
                                        <td>{{ $pemesanan->user->username ?? 'N/A' }}</td>
                                        <td>{{ $pemesanan->tanggal_sewa }}</td>
                                        <td>{{ $pemesanan->tanggal_pengembalian }}</td>
                                        <td>{{ $detail->produkMany->nama_produk ?? 'Tidak ada data' }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>Rp{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                                        <td>{{ $pemesanan->status }}</td>
                                        <td>
                                            <!-- Tombol Selesai -->
                                            <a href="{{ route('admin.pemesanan.selesai', ['id' => $pemesanan->id]) }}" class="btn btn-success">Selesai</a>

                                            <!-- Tombol Batalkan -->
                                            <a href="{{ route('admin.pemesanan.batalkan', ['id' => $pemesanan->id]) }}" class="btn btn-danger">Batalkan</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
