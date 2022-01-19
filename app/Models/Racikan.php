<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Racikan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function item()
    {
        return $this->hasMany(ItemRacikan::class, 'racikan_id');
    }
}
