<?php

namespace App\Models;

use App\Models\Sewa;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


// class Produk extends Model
// {
//     public function kategori()
//     {
//         return $this->belongsTo(Kategori::class);
//     }
// }



class Produk extends Model
{
    // protected $fillable = [
    //     'nama_kategori', 'nama_produk', 'gambar', 'jumlah_unit', 'deskripsi', 'harga'
    // ];

    protected $table = 'produks';
    protected $fillable = [
        'id',
        'kategori_id',
        'nama_produk',
        'gambar',
        'jumlah_unit',
        'deskripsi',
        'harga'
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    // public function keranjang()
    // {
    //     return $this->hasMany(Keranjang::class);
    // }
    public function detailSewas()
    {
        return $this->hasMany(DetailSewa::class);
    }
    public function sewas()
    {
        return $this->hasMany(Sewa::class);
    }
}

