<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjangs extends Model
{
    protected $guarded = ['id'];

    use HasFactory;

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function pesanans()
    {
        return $this->belongsToMany(Pesanans::class, 'keranjang_pesanan', 'keranjang_id', 'pesanan_id');
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
