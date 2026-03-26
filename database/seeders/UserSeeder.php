<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branches;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA TETAP (Login testing)

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

        // 🔥 AMBIL SEMUA BRANCH
        $branches = Branches::all();

        // 🔁 LOOP SETIAP BRANCH
        foreach ($branches as $branch) {

            // 🔧 5 CE per branch
            User::factory()->count(5)->create([
                'role' => 'CE',
                'branch_id' => $branch->id,
            ]);

            // 🔧 2 CS per branch
            User::factory()->count(2)->create([
                'role' => 'CS',
                'branch_id' => $branch->id,
            ]);
        }
    }
}