<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOut extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function jenisHarga()
    {
        return $this->belongsTo(JenisHarga::class, 'jenis_harga_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
