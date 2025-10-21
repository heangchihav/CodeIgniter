<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Electronics
            [
                'category_id' => 1,
                'name'        => 'Wireless Headphones',
                'slug'        => 'wireless-headphones',
                'description' => 'High-quality wireless headphones with noise cancellation',
                'price'       => 99.99,
                'stock'       => 50,
                'image'       => 'https://via.placeholder.com/300x300?text=Headphones',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 1,
                'name'        => 'Smartphone',
                'slug'        => 'smartphone',
                'description' => 'Latest model smartphone with advanced features',
                'price'       => 699.99,
                'stock'       => 30,
                'image'       => 'https://via.placeholder.com/300x300?text=Smartphone',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 1,
                'name'        => 'Laptop',
                'slug'        => 'laptop',
                'description' => 'Powerful laptop for work and gaming',
                'price'       => 1299.99,
                'stock'       => 20,
                'image'       => 'https://via.placeholder.com/300x300?text=Laptop',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            // Clothing
            [
                'category_id' => 2,
                'name'        => 'Cotton T-Shirt',
                'slug'        => 'cotton-tshirt',
                'description' => 'Comfortable cotton t-shirt in various colors',
                'price'       => 19.99,
                'stock'       => 100,
                'image'       => 'https://via.placeholder.com/300x300?text=T-Shirt',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 2,
                'name'        => 'Denim Jeans',
                'slug'        => 'denim-jeans',
                'description' => 'Classic denim jeans with modern fit',
                'price'       => 49.99,
                'stock'       => 75,
                'image'       => 'https://via.placeholder.com/300x300?text=Jeans',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            // Books
            [
                'category_id' => 3,
                'name'        => 'Programming Guide',
                'slug'        => 'programming-guide',
                'description' => 'Comprehensive guide to modern programming',
                'price'       => 39.99,
                'stock'       => 60,
                'image'       => 'https://via.placeholder.com/300x300?text=Book',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 3,
                'name'        => 'Fiction Novel',
                'slug'        => 'fiction-novel',
                'description' => 'Bestselling fiction novel',
                'price'       => 24.99,
                'stock'       => 80,
                'image'       => 'https://via.placeholder.com/300x300?text=Novel',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            // Home & Garden
            [
                'category_id' => 4,
                'name'        => 'Garden Tools Set',
                'slug'        => 'garden-tools-set',
                'description' => 'Complete set of essential garden tools',
                'price'       => 79.99,
                'stock'       => 40,
                'image'       => 'https://via.placeholder.com/300x300?text=Tools',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            // Sports
            [
                'category_id' => 5,
                'name'        => 'Yoga Mat',
                'slug'        => 'yoga-mat',
                'description' => 'Non-slip yoga mat for exercise',
                'price'       => 29.99,
                'stock'       => 90,
                'image'       => 'https://via.placeholder.com/300x300?text=Yoga+Mat',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 5,
                'name'        => 'Running Shoes',
                'slug'        => 'running-shoes',
                'description' => 'Lightweight running shoes for athletes',
                'price'       => 89.99,
                'stock'       => 55,
                'image'       => 'https://via.placeholder.com/300x300?text=Shoes',
                'is_active'   => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}
