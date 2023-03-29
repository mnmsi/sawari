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
            ],
            [
                'name'       => 'Gloves',
                'image_url'  => 'https://via.placeholder.com/150',
            ],
            [
                'name'       => 'Jacket',
                'image_url'  => 'https://via.placeholder.com/150',
            ],
            [
                'name'       => 'Pants',
                'image_url'  => 'https://via.placeholder.com/150',
            ],
            [
                'name'       => 'Boots',
                'image_url'  => 'https://via.placeholder.com/150',
            ],
            [
                'name'       => 'Accessories',
                'image_url'  => 'https://via.placeholder.com/150',
            ],
        ]);
    }
}
