<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
   public function run(): void
    {
        // 1. DATA TETAP (Buat lo login testing)
        // Master Pusat
        User::updateOrCreate(
            ['email' => 'manager@infokom.putra.com'],
            [
                'username'  => 'manager',
                'password'  => bcrypt('master123'),
                'role'      => 'MASTER',
                'branch_id' => null,
            ]
        );

        // CM Pusat
        User::updateOrCreate(
            ['email' => 'maulida@infokom.putra.com'],
            [
                'username'  => 'maulida',
                'password'  => bcrypt('maul123'),
                'role'      => 'CM',
                'branch_id' => null,
            ]
        );

        // 2. DATA OTOMATIS (Pake Factory + Faker)
        // 1 CE di Branch 1 (Semarang)
        User::factory()->create([
            'role'      => 'CE',
            'branch_id' => 1,
        ]);

        // 1 CS di Branch 2 (Slawi)
        User::factory()->create([
            'role'      => 'CS',
            'branch_id' => 2,
            ]);

        }
    }