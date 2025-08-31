<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'product';

    protected $fillable = [
        'name',
        'sku',
        'status',
        'stock',
        'image',
        'price',
        'cost_price',
        'special_price',
        'category_id',
        'tipe',
        'varian',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'price' => 'decimal:2',
        'special_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
