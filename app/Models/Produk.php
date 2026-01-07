<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'produk_id';
    protected $guarded = [];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'produk_id', 'produk_id');
    }

    public function images()
    {
        return $this->hasMany(ProdukImage::class, 'produk_id', 'produk_id');
    }
}
