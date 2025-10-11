<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product 1
        Product::create([
            'name' => 'Plain Red T-Shirt',
            'description' => 'A high-quality plain red cotton t-shirt for daily wear.',
            'price' => 1500.00,
            'color' => 'Red',
            'image_url' => 'https://placehold.co/600x400/FF0000/FFFFFF?text=Red+T-Shirt' // අපි දැනට sample image එකක් දාමු
        ]);

        // Product 2
        Product::create([
            'name' => 'Plain Blue T-Shirt',
            'description' => 'A comfortable plain blue cotton t-shirt.',
            'price' => 1500.00,
            'color' => 'Blue',
            'image_url' => 'https://placehold.co/600x400/0000FF/FFFFFF?text=Blue+T-Shirt'
        ]);

        // Product 3
        Product::create([
            'name' => 'Plain Black T-Shirt',
            'description' => 'A classic plain black cotton t-shirt for any occasion.',
            'price' => 1600.00,
            'color' => 'Black',
            'image_url' => 'https://placehold.co/600x400/000000/FFFFFF?text=Black+T-Shirt'
        ]);

        // Product 4
        Product::create([
            'name' => 'Plain White T-Shirt',
            'description' => 'A clean and fresh plain white cotton t-shirt.',
            'price' => 1450.00,
            'color' => 'White',
            'image_url' => 'https://placehold.co/600x400/FFFFFF/000000?text=White+T-Shirt'
        ]);
    }
}
