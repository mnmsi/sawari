<?php

namespace Database\Seeders;

use App\Models\System\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'name' => 'Cash on Delivery',
            ],
            [
                'name' => 'Online Payment',
            ]
        ]);
    }
}
