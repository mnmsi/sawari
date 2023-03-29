<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                "id"   => "1",
                "name" => "Barishal",
            ],
            [
                "id"   => "2",
                "name" => "Chattogram",
            ],
            [
                "id"   => "3",
                "name" => "Dhaka",
            ],
            [
                "id"   => "4",
                "name" => "Khulna",
            ],
            [
                "id"   => "5",
                "name" => "Rajshahi",
            ],
            [
                "id"   => "6",
                "name" => "Rangpur",
            ],
            [
                "id"   => "7",
                "name" => "Sylhet",
            ],
            [
                "id"   => "8",
                "name" => "Mymensingh",
            ],
        ];

        DB::table('divisions')->insert($divisions);
    }
}
