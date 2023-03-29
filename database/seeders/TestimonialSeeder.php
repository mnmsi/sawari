<?php

namespace Database\Seeders;

use App\Models\System\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('testimonials')->insert([
            [
                'name' => 'John Doe',
                'address' => 'New York',
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl nec ultricies ultricies, nunc elit aliquam nisl, eget aliquam nisl nisl sit amet nisl. Nulla facilisi. Sed euismod, nisl nec ultricies ultricies, nunc elit aliquam nisl, eget aliquam nisl nisl sit amet nisl. Nulla facilisi.',
                'rate' => 5,
                'image_url' => 'https://via.placeholder.com/150',
                'is_active' => 1,
            ],
            [
                'name' => 'Jane Doe',
                'address' => 'New York',
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl nec ultricies ultricies, nunc elit aliquam nisl, eget aliquam nisl nisl sit amet nisl. Nulla facilisi. Sed euismod, nisl nec ultricies ultricies, nunc elit aliquam nisl, eget aliquam nisl nisl sit amet nisl. Nulla facilisi.',
                'rate' => 5,
                'image_url' => 'https://via.placeholder.com/150',
                'is_active' => 1,
            ],
            [
                'name' => 'John Doe',
                'address' => 'New York',
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl nec ultricies ultricies, nunc elit aliquam nisl, eget aliquam nisl nisl sit amet nisl. Nulla facilisi. Sed euismod, nisl nec ultricies ultricies, nunc elit aliquam nisl, eget aliquam nisl nisl sit amet nisl. Nulla facilisi.',
                'rate' => 5,
                'image_url' => 'https://via.placeholder.com/150',
                'is_active' => 1,
            ],
        ]);
    }
}
