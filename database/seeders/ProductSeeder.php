<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Product 1',
            'image' => 'product1.jpg',
            'price' => 20.00,
        ]);

        Product::create([
            'name' => 'Product 2',
            'image' => 'product2.jpg',
            'price' => 35.00,
        ]);

        Product::create([
            'name' => 'Product 3',
            'image' => 'product3.jpg',
            'price' => 50.00,
        ]);
    }
}
