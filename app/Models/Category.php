<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';
    protected $fillable = ['name'];

    // Konversi _id menjadi id agar kompatibel dengan Laravel & Inertia
    public function getIdAttribute($value = null)
    {
        return (string) ($value ?? $this->attributes['_id'] ?? null);
    }
}
