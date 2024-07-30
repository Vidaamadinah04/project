<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = [
        'user_id',
        'produk_id',
        'bukti_identitas',
        'tanggal_sewa',
        'tanggal_pengembalian',
        'status',
        'total_harga',
    ];

    public function detail_sewas()
    {
        return $this->hasMany(DetailSewa::class);
    }
}
