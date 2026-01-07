<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;
    protected $table = 'umkm';
    protected $primaryKey = 'umkm_id';
    protected $guarded = [];

    // Relasi ke Pemilik (User)
    public function pemilik() {
        return $this->belongsTo(User::class, 'pemilik_warga_id');
    }

    // Relasi ke Produk
    public function produk() {
        return $this->hasMany(Produk::class, 'umkm_id', 'umkm_id');
    }

    // Gallery images
    public function images() {
        return $this->hasMany(UmkmImage::class, 'umkm_id', 'umkm_id');
    }
}