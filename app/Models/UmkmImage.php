<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmImage extends Model
{
    use HasFactory;

    protected $table = 'umkm_images';
    protected $guarded = [];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    }
}
