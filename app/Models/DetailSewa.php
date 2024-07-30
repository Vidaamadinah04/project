<?php

namespace App\Models;

use App\Models\Sewa;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailSewa extends Model
{
    use HasFactory;

    protected $guarded= [];
    // protected $fillable = ['sewa_id', 'produk_id', 'jumlah', 'sub_total'];

    public function sewa()
    {
        return $this->belongsTo(Sewa::class);
    }

    public function produk()
    {
        return $this->hasOne(Produk::class);
    }
    
}
