@extends('layout.main')

@section('content')
<div class="container">
    <h1>Detail Sewa</h1>
    <p>ID: {{ $sewa->id }}</p>
    <p>Deskripsi: {{ $sewa->deskripsi }}</p>
    <p>Harga: {{ $sewa->harga }}</p>
    <a href="{{ route('sewa.show', ['id' => $sewa->id]) }}">Lihat Detail</a>
</div>
@endsection
