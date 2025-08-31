<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Audio',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Buah Berduri',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Casing Handphone',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Elektronik',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Fashion Pria',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Fashion Wanita',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Handphone & Tablet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Jam Tangan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kamera',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Laptop & Aksesoris',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Peralatan Rumah Tangga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Perawatan Tubuh',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sepatu Pria',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sepatu Wanita',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tas Pria',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tas Wanita',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
