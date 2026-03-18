<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
   public function run(): void
{
    // Bikin 30 produk otomatis dengan brand-brand di atas
    Product::factory(30)->create();
}
}