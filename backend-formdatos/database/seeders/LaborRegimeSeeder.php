<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaborRegimeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('labor_regimes')->insert([
            [
                'name' => 'DL 1057',
                'code' => 'DL1057',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DL 276',
                'code' => 'DL276',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DL 728',
                'code' => 'DL728',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SERVIR',
                'code' => 'SERVIR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
