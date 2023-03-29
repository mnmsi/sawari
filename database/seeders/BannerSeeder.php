<?php

namespace Database\Seeders;

use App\Models\System\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banners')->insert([
            [
                'page'      => 'home',
                'show_on'   => 'top',
                'image_url' => 'https://via.placeholder.com/1920x1080',
                'is_active' => 1,
            ],
            [
                'page'      => 'home',
                'show_on'   => 'bottom',
                'image_url' => 'https://via.placeholder.com/1920x1080',
                'is_active' => 1,
            ],
            [
                'page'      => 'all-bikes',
                'show_on'   => 'top',
                'image_url' => 'https://via.placeholder.com/1920x1080',
                'is_active' => 1,
            ],
            [
                'page'      => 'popular-brands',
                'show_on'   => 'top',
                'image_url' => 'https://via.placeholder.com/1920x1080',
                'is_active' => 1,
            ],
            [
                'page'      => 'bike-accessories',
                'show_on'   => 'top',
                'image_url' => 'https://via.placeholder.com/1920x1080',
                'is_active' => 1,
            ],
            [
                'page'      => 'our-showrooms',
                'show_on'   => 'top',
                'image_url' => 'https://via.placeholder.com/1920x1080',
                'is_active' => 1,
            ],
        ]);
    }
}
