<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('data_plans')->insert([
            [
                'operator_card_id' => 1,
                'name' => '10 GB',
                'price' => 100000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 1,
                'name' => '25 GB',
                'price' => 200000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 1,
                'name' => '15 GB',
                'price' => 120000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 1,
                'name' => '5 GB',
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 2,
                'name' => '5 GB',
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 2,
                'name' => '10 GB',
                'price' => 100000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 2,
                'name' => '25 GB',
                'price' => 200000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 2,
                'name' => '15 GB',
                'price' => 120000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 3,
                'name' => '5 GB',
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 3,
                'name' => '10 GB',
                'price' => 100000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 3,
                'name' => '25 GB',
                'price' => 200000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 3,
                'name' => '15 GB',
                'price' => 120000,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
