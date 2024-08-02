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
                            <div class="col">
                                <label for="tanggalAkhir" class="form-label form-inline">s/d</label>
                                <input type="date" id="tanggalAkhir" name="tanggalAkhir" class="form-control">
                            </div>
                            <div class="col-sm-2 mt-3">
                               
                                <a href="/laporan/export-pdf" class="btn btn-primary mb-2 me-1" onclick="exportPDFWithDates()"><i class="uil-print"></i> PDF</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-centered w-100 table-nowrap mb-0" id="tabelkunjungan">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        @if (auth()->user()->hasRole('admin'))
                                        <th scope="col">Username</th>
                                        @endif
                                        <th scope="col">Tanggal Sewa</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Jumlah</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sewas as $item)
                                        @foreach ($item->details as $detail)
                                            <tr>
                                                <td>{{ $loop->parent->iteration }}</td>
                                                @if (auth()->user()->hasRole('admin'))
                                                    <td>{{ $item->user->username }}</td>
                                                @endif
                                                <td>{{ $item->tanggal_sewa }}</td>
                                                <td>{{ $detail->produkMany ? $detail->produkMany->nama_produk : 'Tidak ada data' }}</td>                                                <td>{{ $detail->jumlah }}</td>
                                                
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
