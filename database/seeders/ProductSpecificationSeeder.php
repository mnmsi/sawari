<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_specifications')->insert([
            [
                'product_id'     => 1,
                'title'          => 'Engine',
                'value'          => '1.6L 4-Cylinder',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 1,
                'title'          => 'Transmission',
                'value'          => '6-Speed Automatic',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 1,
                'title'          => 'Drivetrain',
                'value'          => 'Front-Wheel Drive',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 1,
                'title'          => 'Fuel Economy',
                'value'          => '30 MPG City / 39 MPG Highway',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 1,
                'title'          => 'Exterior Color',
                'value'          => 'Alabaster Silver Metallic',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 1,
                'title'          => 'Interior Color',
                'value'          => 'Gray',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 1,
                'title'          => 'Stock Number',
                'value'          => 'C-1001',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 1,
                'title'          => 'VIN',
                'value'          => '1HGCT2B88HA000001',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 2,
                'title'          => 'Engine',
                'value'          => '1.6L 4-Cylinder',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 2,
                'title'          => 'Transmission',
                'value'          => '6-Speed Automatic',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 2,
                'title'          => 'Drivetrain',
                'value'          => 'Front-Wheel Drive',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 2,
                'title'          => 'Fuel Economy',
                'value'          => '30 MPG City / 39 MPG Highway',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 2,
                'title'          => 'Exterior Color',
                'value'          => 'Alabaster Silver Metallic',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 2,
                'title'          => 'Interior Color',
                'value'          => 'Gray',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 2,
                'title'          => 'Stock Number',
                'value'          => 'C-1001',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 2,
                'title'          => 'VIN',
                'value'          => '1HGCT2B88HA000001',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 3,
                'title'          => 'Engine',
                'value'          => '1.6L 4-Cylinder',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 3,
                'title'          => 'Transmission',
                'value'          => '6-Speed Automatic',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 3,
                'title'          => 'Drivetrain',
                'value'          => 'Front-Wheel Drive',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 3,
                'title'          => 'Fuel Economy',
                'value'          => '30 MPG City / 39 MPG Highway',
                'is_key_feature' => 1
            ],
            [
                'product_id'     => 3,
                'title'          => 'Exterior Color',
                'value'          => 'Alabaster Silver Metallic',
                'is_key_feature' => 0
            ],
            [
                'product_id'     => 3,
                'title'          => 'Interior Color',
                'value'          => 'Gray',
                'is_key_feature' => 0
            ]
        ]);

    }
}
