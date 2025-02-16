<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'categories_products';
protected $fillable = [];

public function product()
{
    return $this->hasOne(Product::class);
}

public function categories()
{
    return $this->belongsToMany(Category::class);
}
}

