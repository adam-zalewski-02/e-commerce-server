<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'SKU', 
        'price', 
        'stock'
    ];

    public function translations() {
        return $this->hasMany(ProductTranslation::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class)
                    ->using(OrderProduct::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function products() {
        return $this->belongsToMany(Cart::class)
                    ->using(CartProduct::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
