<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['SKU', 'locale', 'name', 'description'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'SKU', 'SKU');
    }
}
