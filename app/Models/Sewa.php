<?php

namespace App\Models;

use App\Models\Sewa;
use App\Models\User;
use App\Models\Produk;
use App\Models\DetailSewa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sewa extends Model
{

    protected $guarded= [];
    // protected $fillable = [
    //     'user_id',
    //     'produk_id',
    //     'bukti_identitas',
    //     'tanggal_sewa',
    //     'tanggal_pengembalian',
    //     'jumlah',
    //     'total_harga',
    //     'status',
    // ];
   

    // public function produk()
    // {
    //     return $this->belongsTo(Produk::class, 'produk_id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detail_sewas()
    {
        return $this->hasMany(DetailSewa::class);
    }
}
