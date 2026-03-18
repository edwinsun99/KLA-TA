<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Schema; // <--- TAMBAHKAN BARIS INI
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
{
    // Matikan check foreign key
    Schema::disableForeignKeyConstraints();

    $this->call([
        BranchSeeder::class,
    ]);

    $this->call([
        CofCounterSeeder::class,
    ]);

     $this->call([
        ProductSeeder::class,
    ]);

     $this->call([
        UserSeeder::class,
    ]);

    // Hidupkan lagi setelah selesai
    Schema::enableForeignKeyConstraints();
}
}

   // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
