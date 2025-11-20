<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'merchant_id' => 1,
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'High-quality wireless headphones with noise cancelling.',
                'price' => 70.00,
                'stock' => 25,
                'category' => 'Electronic',
                'image' => 'products/headphones.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'merchant_id' => 1,
                'name' => 'Organic Honey 500ml',
                'description' => 'Pure organic honey from certified farms.',
                'price' => 10.00,
                'stock' => 50,
                'category' => 'Food',
                'image' => 'products/honey.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'merchant_id' => 2,
                'name' => 'Classic Denim Jacket',
                'description' => 'Unisex denim jacket suitable for all seasons.',
                'price' => 35.00,
                'stock' => 15,
                'category' => 'Fashion',
                'image' => 'products/denim_jacket.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'merchant_id' => 2,
                'name' => 'Vitamin C Serum',
                'description' => 'Brightening serum with 10% pure vitamin C.',
                'price' => 13.00,
                'stock' => 40,
                'category' => 'Beauty and Personal Care',
                'image' => 'products/vitc_serum.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'merchant_id' => 3,
                'name' => 'Minimalist Wooden Coffee Table',
                'description' => 'Modern small coffee table made of teak wood.',
                'price' => 70.00,
                'stock' => 10,
                'category' => 'Furniture',
                'image' => 'products/coffee_table.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'merchant_id' => 3,
                'name' => 'Premium Dog Food 1kg',
                'description' => 'High-protein premium food for adult dogs.',
                'price' => 35.00,
                'stock' => 70,
                'category' => 'Pet Products',
                'image' => 'products/dog_food.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
