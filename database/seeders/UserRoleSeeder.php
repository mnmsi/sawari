<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_role')->insert([
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'status' => 1,
            ],
            [
                'name' => 'Regular User',
                'slug' => 'regular-user',
                'status' => 1,
            ],
        ]);
    }
}
