<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyRelationshipSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Cónyuge', 'code' => 'CONYUGE'],
            ['name' => 'Hijo', 'code' => 'HIJO'],
            ['name' => 'Hija', 'code' => 'HIJA'],
        ] as $relationship) {
            DB::table('family_relationships')->updateOrInsert(
                ['code' => $relationship['code']],
                [
                    'name' => $relationship['name'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
