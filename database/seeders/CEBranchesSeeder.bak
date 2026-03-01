<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CEBranchesSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [
            'ce@klasmg.com' => 1, // Semarang
            'ce@klaslw.com' => 2, // Slawi
            'ce@klatgl.com' => 3, // Tegal
            'ce@klapkl.com' => 4, // Pekalongan
            'ce@klakdr.com' => 5, // Kediri
        ];

        foreach ($mapping as $email => $branchId) {
            User::where('email', $email)->update(['branch_id' => $branchId]);
        }
    }
}
