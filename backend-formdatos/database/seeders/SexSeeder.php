<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SexSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sexes')->insert([
            [
                'name' => 'Femenino',
                'code' => 'F',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Masculino',
                'code' => 'M',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
