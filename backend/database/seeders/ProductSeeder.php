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
        Product::create([
            'name' => 'Plain Black T-Shirt',
            'description' => 'A high-quality 100% cotton plain black t-shirt.',
            'price' => 1500.00,
            'image_url' => 'images/black-tshirt.jpg'
        ]);

        Product::create([
            'name' => 'Plain White T-Shirt',
            'description' => 'A comfortable 100% cotton plain white t-shirt.',
            'price' => 1500.00,
            'image_url' => 'images/white-tshirt.jpg'
        ]);

        Product::create([
            'name' => 'Plain Blue T-Shirt',
            'description' => 'A vibrant 100% cotton plain blue t-shirt.',
            'price' => 1600.00,
            'image_url' => 'images/blue-tshirt.jpg'
        ]);
    }
}
