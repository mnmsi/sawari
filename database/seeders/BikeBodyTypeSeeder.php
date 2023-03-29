<?php

namespace Database\Seeders;

use App\Models\System\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BikeBodyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bike_body_types')->insert([
            ['name' => 'Scooter'],
            ['name' => 'Sport Bike'],
            ['name' => 'Cruiser'],
            ['name' => 'Chopper'],
            ['name' => 'Touring'],
            ['name' => 'Dual Sport'],
            ['name' => 'Adventure'],
            ['name' => 'Off Road'],
            ['name' => 'Naked'],
            ['name' => 'Standard'],
            ['name' => 'Cafe Racer'],
            ['name' => 'Sport Touring'],
            ['name' => 'Trike'],
            ['name' => 'Sidecar'],
            ['name' => 'Scooter'],
            ['name' => 'Moped'],
        ]);
    }
}
