<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressPdfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->truncate(); // optional: hapus data lama biar gak dobel

        DB::table('branches')->insert([
            [
                'name' => 'Semarang',
                'prefix' => 'A',
                'address' => 'Ruko Mataram Plaza, D8-9, Jagalan, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50613',
                'phone' => '08993201657',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Slawi',
                'prefix' => 'B',
                'address' => 'Jl. Flores Baru, Langon, Kudaile, Kec. Slawi, Kabupaten Tegal, Jawa Tengah 52413',
                'phone' => '082132456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tegal',
                'prefix' => 'C',
                'address' => 'Jl. Ahmad Yani No. 50, Kec. Tegal Barat, Kota Tegal, Jawa Tengah 52121',
                'phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pekalongan',
                'prefix' => 'D',
                'address' => 'Jl. Dr. Cipto No. 100, Kec. Pekalongan Barat, Kota Pekalongan, Jawa Tengah 51141',
                'phone' => '081212345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kediri',
                'prefix' => 'E',
                'address' => 'Jl. Joyoboyo No. 88, Kec. Kota, Kota Kediri, Jawa Timur 64121',
                'phone' => '081345678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
