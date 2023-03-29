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
                'name'       => 'Honda',
                'image_url'  => 'https://www.honda.com.au/content/dam/honda-australia/corporate/images/logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Yamaha',
                'image_url'  => 'https://www.yamaha-motor.com.au/content/dam/yamaha-motor/au/en/logo/yamaha-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Suzuki',
                'image_url'  => 'https://www.suzuki.com.au/content/dam/suzuki/au/en/logo/suzuki-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Kawasaki',
                'image_url'  => 'https://www.kawasaki.com.au/content/dam/kawasaki/au/en/logo/kawasaki-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'BMW',
                'image_url'  => 'https://www.bmw.com.au/content/dam/bmw/common/all-models/3-series/2019/bmw-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Victory',
                'image_url'  => 'https://www.victorymotorcycles.com/content/dam/victorymotorcycles/global/en/brand-assets/victory-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Triumph',
                'image_url'  => 'https://www.triumphmotorcycles.com.au/content/dam/triumph/au/en/logo/triumph-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Harley Davidson',
                'image_url'  => 'https://www.harley-davidson.com/content/dam/h-d/images/logos/hd-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Ducati',
                'image_url'  => 'https://www.ducati.com/content/dam/ducati/common/ducati-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'KTM',
                'image_url'  => 'https://www.ktm.com/content/dam/ktm/au/en/logo/ktm-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Aprilia',
                'image_url'  => 'https://www.aprilia.com/content/dam/aprilia/common/logo/aprilia-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Kymco',
                'image_url'  => 'https://www.kymco.com.au/content/dam/kymco/au/en/logo/kymco-logo.png',
                'type'       => 'bike',
            ],
            [
                'name'       => 'Royal Enfield',
                'image_url'  => 'https://www.royalenfield.com.au/content/dam/royalenfield/au/en/logo/royalenfield-logo.png',
                'type'       => 'bike',
            ],
        ]);
    }
}
