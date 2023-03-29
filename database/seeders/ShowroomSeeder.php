<?php

namespace Database\Seeders;

use App\Models\System\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('showrooms')->insert([
            [
                'name'               => 'Showroom 1',
                'phone'              => '01700000000',
                'address'            => 'Address 1',
                'country_id'         => 19,
                'division_id'        => 3,
                'city_id'            => 1,
                'area_id'            => 149,
                'postal_code'        => '1000',
                'location_image_url' => 'https://via.placeholder.com/150',
                'support_number'     => '01700000000',
            ],
            [
                'name'               => 'Showroom 2',
                'phone'              => '01700000000',
                'address'            => 'Address 2',
                'country_id'         => 19,
                'division_id'        => 3,
                'city_id'            => 1,
                'area_id'            => 149,
                'postal_code'        => '1000',
                'location_image_url' => 'https://via.placeholder.com/150',
                'support_number'     => '01700000000',
            ],
            [
                'name'               => 'Showroom 3',
                'phone'              => '01700000000',
                'address'            => 'Address 3',
                'country_id'         => 19,
                'division_id'        => 3,
                'city_id'            => 1,
                'area_id'            => 149,
                'postal_code'        => '1000',
                'location_image_url' => 'https://via.placeholder.com/150',
                'support_number'     => '01700000000',
            ],
        ]);
    }
}
