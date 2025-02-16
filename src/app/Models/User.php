<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;

    // タイムスタンプを無効化
    public $timestamps = false;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'post_code',
        'address',
        'profile_image',
    ];


    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function sells()
    {
        return $this->hasMany(Sell::class);
    }

    public function Orders()
    {
        return $this->hasMany(Order::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedProducts()
    {
        return $this->belongsToMany(Product::class, 'likes')->withTimestamps();
    }

    public function sellProducts()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function buyProducts()
    {
        return $this->hasMany(Product::class, 'buyer_id');
    }
}