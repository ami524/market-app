<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'brand',
        'description',
        'price',
        'product_image',
        'item_condition',

    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function sell()
    {
        return $this->hasOne(Sell::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->hasOne(CategoryProduct::class);
    }
}

