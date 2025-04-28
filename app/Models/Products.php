<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'user_id',
    ];

    public function images()
    {
        return $this->hasOne(ProductImage::class);
    }
}
