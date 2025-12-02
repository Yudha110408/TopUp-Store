<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@topupstore.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Demo',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        // Categories
        $categories = [
            [
                'name' => 'Mobile Legends',
                'slug' => 'mobile-legends',
                'description' => 'Top up diamond Mobile Legends dengan harga terbaik',
                'is_active' => true,
            ],
            [
                'name' => 'Free Fire',
                'slug' => 'free-fire',
                'description' => 'Top up diamond Free Fire murah dan cepat',
                'is_active' => true,
            ],
            [
                'name' => 'PUBG Mobile',
                'slug' => 'pubg-mobile',
                'description' => 'Top up UC PUBG Mobile terpercaya',
                'is_active' => true,
            ],
            [
                'name' => 'Roblox',
                'slug' => 'roblox',
                'description' => 'Top up Robux untuk Roblox',
                'is_active' => true,
            ],
            [
                'name' => 'Genshin Impact',
                'slug' => 'genshin-impact',
                'description' => 'Top up Genesis Crystal Genshin Impact',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);

            // Create Products for each category
            $products = [
                [
                    'name' => $category->name . ' - 100 Diamond/UC/Robux',
                    'slug' => Str::slug($category->name . ' 100 diamond'),
                    'description' => 'Paket 100 diamond/UC/Robux untuk ' . $category->name,
                    'type' => 'item',
                    'price' => 25000,
                    'stock' => 100,
                    'is_active' => true,
                ],
                [
                    'name' => $category->name . ' - 250 Diamond/UC/Robux',
                    'slug' => Str::slug($category->name . ' 250 diamond'),
                    'description' => 'Paket 250 diamond/UC/Robux untuk ' . $category->name,
                    'type' => 'item',
                    'price' => 60000,
                    'stock' => 100,
                    'is_active' => true,
                ],
                [
                    'name' => $category->name . ' - 500 Diamond/UC/Robux',
                    'slug' => Str::slug($category->name . ' 500 diamond'),
                    'description' => 'Paket 500 diamond/UC/Robux untuk ' . $category->name,
                    'type' => 'item',
                    'price' => 115000,
                    'stock' => 100,
                    'is_active' => true,
                ],
            ];

            foreach ($products as $productData) {
                $productData['category_id'] = $category->id;
                Product::create($productData);
            }
        }

        // Create Account Products
        $mlCategory = Category::where('slug', 'mobile-legends')->first();
        Product::create([
            'category_id' => $mlCategory->id,
            'name' => 'Akun ML Epic - Full Hero',
            'slug' => 'akun-ml-epic-full-hero',
            'description' => 'Akun Mobile Legends rank Epic dengan semua hero dan skin premium',
            'type' => 'account',
            'price' => 500000,
            'stock' => 0,
            'is_active' => true,
        ]);

        echo "Database seeded successfully!\n";
        echo "Admin Login:\n";
        echo "Email: admin@topupstore.com\n";
        echo "Password: password\n";
    }
}
