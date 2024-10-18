<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $guarded = ['id'];

    use HasFactory;

    public function categories()
    {
        return  $this->belongsTo(categories::class, 'category_id');
    }
}
