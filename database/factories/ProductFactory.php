<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

        public function definition(): array
{
    // List brand dan model sesuai input lo
    $brands = [
        'ASUS'      => ['ROG', 'TUF', 'Zenbook', 'Vivobook'],
        'Lenovo'    => ['ThinkPad', 'Yoga', 'IdeaPad', 'Legion'],
        'HP'        => ['Pavilion', 'Spectre', 'EliteBook', 'Victus', 'Omen'],
        'Dell'      => ['XPS', 'Inspiron', 'Latitude', 'Alienware'],
        'Acer'      => ['Swift', 'Aspire', 'Predator', 'Spin'],
        'MSI'       => ['Modern', 'Summit', 'Katana', 'Raider'],
        'Huawei'    => ['MateBook'],
        'Xiaomi'    => ['RedmiBook', 'Xiaomi Book'],
        'Microsoft' => ['Surface Laptop', 'Surface Pro'],
        'Samsung'   => ['Galaxy Book', 'Chromebook'],
        'Infinix'   => ['Inbook'],
        'Razer'     => ['Blade'],
    ];

    $brandName = fake()->randomKey($brands);
    $modelName = fake()->randomElement($brands[$brandName]);

    return [
        // PN: 7 Digit Alfanumerik (Max 7 Digit sesuai request)
        'pn' => strtoupper(fake()->unique()->bothify('**###**')), 
        
        // NT: Brand + Model + Angka Random/Huruf (Acer Swift Edge 14 A)
        'nt' => $brandName . ' ' . $modelName . ' ' . fake()->numberBetween(13, 16) . ' ' . strtoupper(fake()->randomLetter()),
    ];
}
}
