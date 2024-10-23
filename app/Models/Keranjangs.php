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
        return $this->hasMany(Products::class);
    }
}
