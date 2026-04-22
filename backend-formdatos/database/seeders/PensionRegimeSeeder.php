<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PensionRegimeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Habitat', 'code' => 'HABITAT'],
            ['name' => 'Integra', 'code' => 'INTEGRA'],
            ['name' => 'Prima', 'code' => 'PRIMA'],
            ['name' => 'Profuturo', 'code' => 'PROFUTURO'],
            ['name' => 'SNP', 'code' => 'SNP'],
        ] as $regime) {
            DB::table('pension_regimes')->updateOrInsert(
                ['code' => $regime['code']],
                [
                    'name' => $regime['name'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
