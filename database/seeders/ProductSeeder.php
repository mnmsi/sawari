<?php

namespace Database\Seeders;

use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\System\BikeBodyType;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'brand_id'          => Brand::where('type', 'bike')->inRandomOrder()->first()->id,
                'body_type_id'      => BikeBodyType::inRandomOrder()->first()->id,
                'type'              => 'bike',
                'category_id'       => null,
                'name'              => 'Bike 1',
                'price'             => 500000,
                'discount_rate'     => 10,
                'shipping_charge'   => 100,
                'stock'             => 20,
                'is_used'           => 0,
                'is_featured'       => 1,
                'short_description' => Factory::create()->text(100),
                'description'       => Factory::create()->text(500),
            ],
            [
                'brand_id'          => Brand::where('type', 'bike')->inRandomOrder()->first()->id,
                'body_type_id'      => BikeBodyType::inRandomOrder()->first()->id,
                'type'              => 'bike',
                'category_id'       => null,
                'name'              => 'Bike 2',
                'price'             => 500000,
                'discount_rate'     => 10,
                'shipping_charge'   => 100,
                'stock'             => 20,
                'is_used'           => 1,
                'is_featured'       => 1,
                'short_description' => Factory::create()->text(100),
                'description'       => Factory::create()->text(500),
            ],
            [
                'brand_id'          => Brand::where('type', 'bike')->inRandomOrder()->first()->id,
                'body_type_id'      => BikeBodyType::inRandomOrder()->first()->id,
                'type'              => 'bike',
                'category_id'       => null,
                'name'              => 'Bike 3',
                'price'             => 500000,
                'discount_rate'     => 10,
                'shipping_charge'   => 100,
                'stock'             => 20,
                'is_used'           => 0,
                'is_featured'       => 1,
                'short_description' => Factory::create()->text(100),
                'description'       => Factory::create()->text(500),
            ],
            [
                'brand_id'          => Brand::where('type', 'bike')->inRandomOrder()->first()->id,
                'body_type_id'      => BikeBodyType::inRandomOrder()->first()->id,
                'type'              => 'bike',
                'category_id'       => null,
                'name'              => 'Bike 4',
                'price'             => 500000,
                'discount_rate'     => 10,
                'shipping_charge'   => 100,
                'stock'             => 20,
                'is_used'           => 1,
                'is_featured'       => 1,
                'short_description' => Factory::create()->text(100),
                'description'       => Factory::create()->text(500),
            ],
            [
                'brand_id'          => Brand::where('type', 'accessory')->inRandomOrder()->first()->id,
                'body_type_id'      => BikeBodyType::inRandomOrder()->first()->id,
                'type'              => 'accessory',
                'category_id'       => Category::inRandomOrder()->first()->id,
                'name'              => 'Accessory 1',
                'price'             => 500000,
                'discount_rate'     => 10,
                'shipping_charge'   => 100,
                'stock'             => 20,
                'is_used'           => 0,
                'is_featured'       => 1,
                'short_description' => Factory::create()->text(100),
                'description'       => Factory::create()->text(500),
            ],
            [
                'brand_id'          => Brand::where('type', 'accessory')->inRandomOrder()->first()->id,
                'body_type_id'      => BikeBodyType::inRandomOrder()->first()->id,
                'type'              => 'accessory',
                'category_id'       => Category::inRandomOrder()->first()->id,
                'name'              => 'Accessory 2',
                'price'             => 500000,
                'discount_rate'     => 10,
                'shipping_charge'   => 100,
                'stock'             => 20,
                'is_used'           => 1,
                'is_featured'       => 1,
                'short_description' => Factory::create()->text(100),
                'description'       => Factory::create()->text(500),
            ],
            [
                'brand_id'          => Brand::where('type', 'accessory')->inRandomOrder()->first()->id,
                'body_type_id'      => BikeBodyType::inRandomOrder()->first()->id,
                'type'              => 'accessory',
                'category_id'       => Category::inRandomOrder()->first()->id,
                'name'              => 'Accessory 3',
                'price'             => 500000,
                'discount_rate'     => 10,
                'shipping_charge'   => 100,
                'stock'             => 20,
                'is_used'           => 0,
                'is_featured'       => 1,
                'short_description' => Factory::create()->text(100),
                'description'       => Factory::create()->text(500),
            ],
            [
                'brand_id'          => Brand::where('type', 'accessory')->inRandomOrder()->first()->id,
                'body_type_id'      => BikeBodyType::inRandomOrder()->first()->id,
                'type'              => 'accessory',
                'category_id'       => Category::inRandomOrder()->first()->id,
                'name'              => 'Accessory 4',
                'price'             => 500000,
                'discount_rate'     => 10,
                'shipping_charge'   => 100,
                'stock'             => 20,
                'is_used'           => 1,
                'is_featured'       => 1,
                'short_description' => Factory::create()->text(500),
                'description'       => Factory::create()->text(500),
            ]
        ]);
    }
}
