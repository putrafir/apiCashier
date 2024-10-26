<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanans extends Model
{
    protected $guarded = ['id'];

    use HasFactory;


    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    public function categories()
    {
        return  $this->belongsTo(Categories::class, 'category_id');
    }
    public function keranjangs()
    {
        return $this->hasMany(Keranjangs::class, 'product_id'); // Relasi ke keranjang
    }
}
