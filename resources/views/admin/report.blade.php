<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Service Order</title>
<style>
    body { font-family: Arial, sans-serif; }
    .header { text-align: center; margin-bottom: 20px; }
    .header img { width: 200px; }
    .header h1 { color: navy; margin: 0; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid black; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .right { text-align: right; }
    .footer { margin-top: 20px; font-size: 0.9em; text-align: center; }
</style>
</head>
<body>
    <h1>Laporan Penyewaan</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No.</th>
                @if (auth()->user()->hasRole('admin'))
                <th>Username</th>
                @endif
                <th>Tanggal Sewa</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
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
</body>
</html>