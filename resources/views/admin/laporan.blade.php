@extends('layout.main')
@section('css')
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Laporan Penyewaan</h4>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2 align-items">
                                <div class="col">
                                    <label for="tanggalAwal" class="form-label form-inline">Tanggal Sewa :</label>
                                    <input type="date" id="tanggalAwal" name="tanggalAwal" class="form-control">
                                  </div>
                               
                                <div class="col-sm-2 mt-3">
                                    <a href="#" type="submit" class="btn btn-danger mb-2 me-1" onclick="exportExcel()"><i class="uil-print"></i> Excel</a>
                                    <a href="#" class="btn btn-primary mb-2 me-1" onclick="exportPDFWithDates()"><i class="uil-print"></i> PDF</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-centered w-100 table-nowrap mb-0" id="tabelkunjungan">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th scope="col">Tanggal Sewa</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Jumlah</th>
                                            {{-- <th scope="col">Metode Pembayaran</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @if (auth()->user()->hasRole('admin')) --}}
                                        @foreach ($sewa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->tanggal_sewa }}</td>
                                            <td>{{ $item->produk->nama_produk }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            {{-- <td>{{ $item->metode_pembayaran }}</td> --}}
                                        </tr>
                                    @endforeach
                                    {{-- @endif --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function exportPDFWithDates() {
        var tanggalAwal = document.getElementById('tanggalAwal').value;
        var tanggalAkhir = document.getElementById('tanggalAkhir').value;
        // Implementasi export PDF
    }

    function exportExcel() {
        var tanggalAwal = document.getElementById('tanggalAwal').value;
        var tanggalAkhir = document.getElementById('tanggalAkhir').value;
        // Implementasi export Excel
    }
</script>
@endsection
