<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(['name' => 'Audio']);

        Product::insert([
            [
                'name' => 'Speaker Bluetooth',
                'sku' => 'SPK-BT-001',
                'varian' => '1',
                'status' => '1',
                'stock' => '100',
                'tipe' => '1',
                'price' => 250000,
                'cost_price' => 200000,
                'special_price' => 240000,
                'image' => 'products/speaker.png',
                'category_id' => $category->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Headset Wireless',
                'sku' => 'HST-WL-001',
                'varian' => '1',
                'status' => '1',
                'stock' => '50',
                'tipe' => '1',
                'price' => 350000,
                'cost_price' => 300000,
                'special_price' => 340000,
                'image' => 'products/headset.png',
                'category_id' => $category->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Earphone Wired',
                'sku' => 'ERF-WD-001',
                'varian' => '1',
                'status' => '1',
                'stock' => '200',
                'tipe' => '1',
                'price' => 150000,
                'cost_price' => 100000,
                'special_price' => 140000,
                'image' => 'products/earphone.png',
                'category_id' => $category->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Earphone Wireless',
                'sku' => 'ERF-WL-001',
                'varian' => '1',
                'status' => '1',
                'stock' => '150',
                'tipe' => '1',
                'price' => 200000,
                'cost_price' => 150000,
                'special_price' => 190000,
                'image' => 'products/earphone_wireless.png',
                'category_id' => $category->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
