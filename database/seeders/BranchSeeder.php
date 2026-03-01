<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branches;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'id' => 1,
                'name' => 'Semarang',
                'prefix' => 'A',
                'address' => 'Ruko Mataram Plaza, D8-9, Jagalan, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50613',
                'phone' => '0895616797777',
                'latitude' => 0.0000000,
                'longitude' => 0.0000000,
                'open_at' => '00:00:00',
                'close_at' => '00:00:00',
            ],
            [
                'id' => 2,
                'name' => 'Slawi',
                'prefix' => 'B',
                'address' => 'Jl. Flores Baru, Langon, Kudaile, Kec. Slawi, Kabupaten Tegal, Jawa Tengah 52413',
                'phone' => '085185068679',
                'latitude' => 0.0000000,
                'longitude' => 0.0000000,
                'open_at' => '00:00:00',
                'close_at' => '00:00:00',
            ],
            [
                'id' => 3,
                'name' => 'Tegal',
                'prefix' => 'C',
                'address' => 'Jl. Sultan Agung No.49, Kejambon, Kec. Tegal Tim., Kota Tegal, Jawa Tengah',
                'phone' => '085165867970',
                'latitude' => 0.0000000,
                'longitude' => 0.0000000,
                'open_at' => '00:00:00',
                'close_at' => '00:00:00',
            ],
            [
                'id' => 4,
                'name' => 'Pekalongan',
                'prefix' => 'D',
                'address' => 'Jl. Imam Bonjol No.9, Kergon, Kec. Pekalongan Bar., Kota Pekalongan, Jawa Tengah 51113',
                'phone' => '085724968191',
                'latitude' => 0.0000000,
                'longitude' => 0.0000000,
                'open_at' => '00:00:00',
                'close_at' => '00:00:00',
            ],
            [
                'id' => 5,
                'name' => 'Kediri',
                'prefix' => 'E',
                'address' => 'Jl. Pahlawan Kusuma Bangsa No.21, Banjaran, Kec. Kota, Kota Kediri, Jawa Timur 64129',
                'phone' => '08986561999',
                'latitude' => 0.0000000,
                'longitude' => 0.0000000,
                'open_at' => '00:00:00',
                'close_at' => '00:00:00',
            ],
        ];

        foreach ($branches as $branch) {
            Branches::updateOrCreate(
                ['id' => $branch['id']],
                $branch
            );
        }
    }
}