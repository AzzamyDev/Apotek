<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = ['status' => 'boolean'];

    public function jenisHarga()
    {
        return $this->belongsTo(JenisHarga::class, 'tipe_harga_id');
    }
}
