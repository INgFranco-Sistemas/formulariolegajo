<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaborRegimeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'DL 1057', 'code' => 'DL1057'],
            ['name' => 'DL 276', 'code' => 'DL276'],
            ['name' => 'DL 728', 'code' => 'DL728'],
            ['name' => 'SERVIR', 'code' => 'SERVIR'],
        ] as $regime) {
            DB::table('labor_regimes')->updateOrInsert(
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
