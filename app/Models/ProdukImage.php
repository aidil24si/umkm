<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukImage extends Model
{
    use HasFactory;

    protected $table = 'produk_images';
    protected $guarded = [];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }
}
