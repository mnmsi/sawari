<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_media')->insert([
            [
                'product_id' => 1,
                'product_color_id' => 1,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 1,
                'product_color_id' => 2,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 1,
                'product_color_id' => 3,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 2,
                'product_color_id' => 4,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 2,
                'product_color_id' => 5,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 2,
                'product_color_id' => 6,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 3,
                'product_color_id' => 7,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 3,
                'product_color_id' => 8,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 3,
                'product_color_id' => 9,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 4,
                'product_color_id' => 10,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 4,
                'product_color_id' => 11,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 4,
                'product_color_id' => 12,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 5,
                'product_color_id' => 13,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 5,
                'product_color_id' => 14,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 5,
                'product_color_id' => 15,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 6,
                'product_color_id' => 16,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 6,
                'product_color_id' => 17,
                'type' => 'image',
                'url' => 'https://via.placeholder.com/150',
                'thumbnail_url' => 'https://via.placeholder.com/150'
            ]
        ]);
    }
}
