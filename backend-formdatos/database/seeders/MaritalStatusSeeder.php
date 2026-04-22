<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaritalStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Soltero(a)', 'code' => 'SOLTERO'],
            ['name' => 'Casado(a)', 'code' => 'CASADO'],
            ['name' => 'Viudo(a)', 'code' => 'VIUDO'],
            ['name' => 'Separado/Divorciado(a)', 'code' => 'DIVORCIADO'],
            ['name' => 'Conviviente', 'code' => 'CONVIVIENTE'],
        ] as $status) {
            DB::table('marital_statuses')->updateOrInsert(
                ['code' => $status['code']],
                [
                    'name' => $status['name'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
