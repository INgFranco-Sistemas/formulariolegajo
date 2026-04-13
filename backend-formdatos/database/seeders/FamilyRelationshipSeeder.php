<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyRelationshipSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('family_relationships')->insert([
            [
                'name' => 'Cónyuge',
                'code' => 'CONYUGE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hijo',
                'code' => 'HIJO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hija',
                'code' => 'HIJA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
