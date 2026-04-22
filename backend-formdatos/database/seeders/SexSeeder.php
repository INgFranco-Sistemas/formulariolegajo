<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SexSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Femenino', 'code' => 'F'],
            ['name' => 'Masculino', 'code' => 'M'],
        ] as $sex) {
            DB::table('sexes')->updateOrInsert(
                ['code' => $sex['code']],
                [
                    'name' => $sex['name'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
