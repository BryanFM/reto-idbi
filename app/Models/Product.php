<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['sku', 'name', 'unit_price', 'stock'];
    
    protected static function booted()
    {
        static::creating(function ($product) {
            $product->sku = strtoupper($product->sku); // SKU en MAYUS
        });
    }
}