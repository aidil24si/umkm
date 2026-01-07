<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'pesanan_id';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'warga_id');
    }

    public function details()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id', 'pesanan_id');
    }
}
