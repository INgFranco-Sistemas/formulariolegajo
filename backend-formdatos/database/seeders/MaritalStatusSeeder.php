<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaritalStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('marital_statuses')->insert([
            [
                'name' => 'Soltero(a)',
                'code' => 'SOLTERO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Casado(a)',
                'code' => 'CASADO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Viudo(a)',
                'code' => 'VIUDO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Separado/Divorciado(a)',
                'code' => 'DIVORCIADO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Conviviente',
                'code' => 'CONVIVIENTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
