<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisHarga extends Model
{
    use HasFactory;
    protected $table = 'jenis_harga';
    protected $guarded = ['id'];
}
