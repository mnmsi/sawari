<?php

namespace Database\Seeders;

use App\Models\System\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('delivery_options')->insert([
            [
                'name'  => 'Store Pickup',
                'bonus' => 'Get a free helmet',
            ],
            [
                'name'  => 'Courier Service',
                'bonus' => null
            ]
        ]);
    }
}
