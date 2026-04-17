<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::updateOrCreate(
            ['email' => 'admin@institucion.gob.pe'],
            [
                'name' => 'Administrador General',
                'password' => Hash::make('Admin123456*'),
                'is_active' => true,
            ]
        );
    }
}