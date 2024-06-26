<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;


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
}
