<?php

namespace App\Models;

use App\Models\Sewa;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanModel extends Model
{
    protected $fillable = [
        'tanggal_sewa',
        'jumlah',
        'nama_produk',
        // tambahkan kolom lain sesuai kebutuhan
    ];

    public function sewa()
    {
        return $this->belongsTo(Sewa::class, 'tanggal_sewa', 'jumlah');
        // sesuaikan dengan kunci asing yang sesuai antara tabel laporan dan sewa
    }
}
