<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PensionRegimeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pension_regimes')->insert([
            [
                'name' => 'Habitat',
                'code' => 'HABITAT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Integra',
                'code' => 'INTEGRA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prima',
                'code' => 'PRIMA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Profuturo',
                'code' => 'PROFUTURO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SNP',
                'code' => 'SNP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
