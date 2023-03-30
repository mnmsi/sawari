<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_colors')->insert([
            [
                'product_id' => 1,
                'name'       => 'Red',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 1,
                'name'       => 'Blue',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 1,
                'name'       => 'Black',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 2,
                'name'       => 'Red',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 2,
                'name'       => 'Blue',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 2,
                'name'       => 'Black',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 3,
                'name'       => 'Red',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 3,
                'name'       => 'Blue',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 3,
                'name'       => 'Black',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 4,
                'name'       => 'Red',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 4,
                'name'       => 'Blue',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 4,
                'name'       => 'Black',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 5,
                'name'       => 'Red',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 5,
                'name'       => 'Blue',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 5,
                'name'       => 'Black',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 6,
                'name'       => 'Red',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 6,
                'name'       => 'Blue',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 6,
                'name'       => 'Black',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 7,
                'name'       => 'Red',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 7,
                'name'       => 'Blue',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 7,
                'name'       => 'Black',
                'image_url'  => 'https://via.placeholder.com/150'
            ],
            [
                'product_id' => 8,
                'name'       => 'Red',
                'image_url'  => 'https://via.placeholder.com/150'
            ]
        ]);
    }
}
