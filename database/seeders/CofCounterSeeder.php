<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CofCounter;
use App\Models\Branches;

class CofCounterSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua ID dari tabel branches yang sudah di-seed sebelumnya
        $branchIds = Branches::pluck('id');

        foreach ($branchIds as $id) {
            CofCounter::updateOrCreate(
                ['branch_id' => $id],
                ['current_number' => 0]
            );
        }
    }
}
