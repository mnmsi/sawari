<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name'       => 'Helmet',
                'image_url'  => 'https://via.placeholder.com/150',
                'is_popular' => 0
            ],
            [
                'name'       => 'Gloves',
                'image_url'  => 'https://via.placeholder.com/150',
                'is_popular' => 0
            ],
            [
                'name'       => 'Jacket',
                'image_url'  => 'https://via.placeholder.com/150',
                'is_popular' => 1
            ],
            [
                'name'       => 'Pants',
                'image_url'  => 'https://via.placeholder.com/150',
                'is_popular' => 0
            ],
            [
                'name'       => 'Boots',
                'image_url'  => 'https://via.placeholder.com/150',
                'is_popular' => 1
            ],
            [
                'name'       => 'Accessories',
                'image_url'  => 'https://via.placeholder.com/150',
                'is_popular' => 0
            ],
        ]);
    }
}
