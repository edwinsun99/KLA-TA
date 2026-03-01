<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['pn' => 'A514-55G-75BB', 'nt' => 'Acer Aspire 5 A514-55G-75BB Notebook'],
            ['pn' => 'UX3405CA', 'nt' => 'ASUS ExpertBook B3'],
            ['pn' => 'CE711A', 'nt' => 'HP Color Laserjet Professional CP577n'],
            ['pn' => 'JKI56J3', 'nt' => 'Dell Inspiron 14 3000'],
            ['pn' => '9S7-14J112-1237', 'nt' => 'MSI Thin GF63'],
            ['pn' => 'T480s', 'nt' => 'Lenovo IdeaPad Slim 5 Gen'],
            ['pn' => 'ADVAN-LMP-01', 'nt' => 'Advan Laptop Soulmate Intel Celeron N4020'],
            ['pn' => 'MS-SURFACE-PRO9', 'nt' => 'Microsoft Surface Pro 9 Intel Core i5'],
            ['pn' => 'MS-SURFACE-LAP5', 'nt' => 'Microsoft Surface Laptop 5 13.5 inch'],
            ['pn' => 'MAC-AIR-M2', 'nt' => 'Apple MacBook Air M2 13-inch 2022'],
            ['pn' => 'MAC-PRO-M3', 'nt' => 'Apple MacBook Pro M3 14-inch 2023'],
            ['pn' => 'MSI-KATANA-15', 'nt' => 'MSI Katana 15 B13VFK Intel i7-13620H'],
            ['pn' => 'MSI-MODERN-14', 'nt' => 'MSI Modern 14 C11M Intel Core i3'],
            ['pn' => 'ADV-TAB-VX', 'nt' => 'Advan Sketsa 2 Tablet Android with Stylus'],
            ['pn' => 'HP-PAV-X360', 'nt' => 'HP Pavilion x360 Convertible 14-dy000'],
            ['pn' => 'LEN-YOGA-7I', 'nt' => 'Lenovo Yoga 7i Gen 7 Intel Core i7'],
            ['pn' => 'ASU-ROG-STRIX', 'nt' => 'ASUS ROG Strix G15 G513RC Ryzen 7'],
            ['pn' => 'ACE-PRED-HEL', 'nt' => 'Acer Predator Helios Neo 16 PH16'],
            ['pn' => 'DEL-LAT-5430', 'nt' => 'Dell Latitude 5430 Rugged Laptop'],
            ['pn' => 'GIG-AORUS-15', 'nt' => 'Gigabyte AORUS 15 BKF Intel i7-13700H'],
            ['pn' => 'RAZ-BLADE-14', 'nt' => 'Razer Blade 14 Gaming Laptop Ryzen 9'],
            ['pn' => 'SAMSUNG-GB3', 'nt' => 'Samsung Galaxy Book3 Pro 360'],
            ['pn' => 'ADVAN-WORKPLUS', 'nt' => 'Advan Workplus AMD Ryzen 5 6600H'],
            ['pn' => 'XIAOMI-NB-PRO', 'nt' => 'Xiaomi Mi Notebook Pro 14 2021'],
            ['pn' => 'INF-ZERO-BOOK', 'nt' => 'Infinix ZERO BOOK Ultra Intel i9'],
            ['pn' => 'HUA-MATE-D15', 'nt' => 'Huawei MateBook D15 Intel Core i5'],
            ['pn' => 'AVA-LIBER-V', 'nt' => 'Avita Liber V14 Ryzen 5 3500U'],
            ['pn' => 'ZOT-MAGNUS', 'nt' => 'Zotac Magnus EN173080C Mini PC'],
            ['pn' => 'CHU-WI-LAP-PRO', 'nt' => 'Chuwi LapBook Pro Intel Celeron'],
            ['pn' => 'MSI-STEALTH-16', 'nt' => 'MSI Stealth 16 Studio A13V i9-13900H'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['pn' => $product['pn']], // unique key
                [
                    'nt' => $product['nt'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}