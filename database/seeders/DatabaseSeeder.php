<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed Products
        $products = [
            [
                'name' => 'Premium Wireless Headphones Pro X',
                'price' => 299.99,
                'description' => 'Immerse yourself in music quality sound with our flagship wireless headphones. Engineered for audiophiles and professionals.',
                'image' => 'headphones.jpg',
                'category' => 'Audio',
                'stock' => 50,
            ],
            [
                'name' => 'Smart Watch Series 5',
                'price' => 399.00,
                'description' => 'Stay connected, active, and healthy with the new Smart Watch Series 5. Features an always-on Retina display.',
                'image' => 'smartwatch.jpg',
                'category' => 'Wearables',
                'stock' => 30,
            ],
            [
                'name' => 'UltraBook Pro 15',
                'price' => 1299.00,
                'description' => 'Power and portability in one package. The UltraBook Pro 15 features the latest processor and a stunning 4K display.',
                'image' => 'laptop.jpg',
                'category' => 'Computers',
                'stock' => 15,
            ],
            [
                'name' => '4K Action Camera',
                'price' => 199.50,
                'description' => 'Capture your adventures in stunning 4K resolution. Waterproof, shockproof, and ready for anything.',
                'image' => 'camera.jpg',
                'category' => 'Cameras',
                'stock' => 100,
            ],
            [
                'name' => 'Gaming Console X',
                'price' => 499.99,
                'description' => 'Experience next-gen gaming with the Console X. 8K support, 120fps, and a library of exclusive titles.',
                'image' => 'console.jpg',
                'category' => 'Gaming',
                'stock' => 25,
            ],
            [
                'name' => 'Designer Sunglasses',
                'price' => 150.00,
                'description' => 'Stylish protection for your eyes. UV400 protection and premium materials.',
                'image' => 'sunglasses.jpg',
                'category' => 'Accessories',
                'stock' => 200,
            ],
            [
                'name' => 'Leather Handbag',
                'price' => 89.99,
                'description' => 'Elegant and spacious leather handbag. Perfect for everyday use or special occasions.',
                'image' => 'handbag.jpg',
                'category' => 'Fashion',
                'stock' => 40,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
