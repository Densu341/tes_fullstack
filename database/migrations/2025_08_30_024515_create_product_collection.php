<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('products', function ($collection) {
            $collection->string('name');
            $collection->string('sku');
            $collection->boolean('status');
            $collection->string('image');
            $collection->integer('stock');
            $collection->integer('varian');
            $collection->integer('tipe');
            $collection->decimal('cost_price', 10, 2);
            $collection->decimal('price', 10, 2);
            $collection->decimal('special_price', 10, 2);
            $collection->string('category_id');
            $collection->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('products');
    }
};
