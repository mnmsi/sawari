<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'name'      => 'Honda',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Yamaha',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Suzuki',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Kawasaki',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'BMW',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Victory',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Triumph',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Harley Davidson',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Ducati',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'KTM',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Aprilia',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Kymco',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
            [
                'name'      => 'Royal Enfield',
                'image_url' => 'https://via.placeholder.com/150',
                'type'      => 'bike',
            ],
        ]);
    }
}
