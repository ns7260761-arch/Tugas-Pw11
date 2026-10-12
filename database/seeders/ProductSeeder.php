<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * 6 kategori x 10 produk = 60 produk.
 * Harga adalah perkiraan (Rupiah) hanya untuk data contoh.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            'Laptop & Komputer' => [
                'ASUS Vivobook 14 A1404' => 7499000, 'Acer Aspire 5 A515' => 8299000,
                'Lenovo IdeaPad Slim 3' => 6999000, 'HP 14s-dq Series' => 6599000,
                'MSI Modern 14' => 8999000, 'Axioo Hype 5' => 5499000,
                'Dell Inspiron 14' => 9499000, 'Apple MacBook Air M2' => 15999000,
                'Lenovo LOQ 15' => 13499000, 'ASUS TUF Gaming F15' => 12999000,
            ],
            'Smartphone & Tablet' => [
                'Samsung Galaxy A55 5G' => 5999000, 'Xiaomi Redmi Note 13' => 2799000,
                'OPPO Reno11 F' => 4799000, 'vivo V30e' => 4999000,
                'realme C67' => 2199000, 'Infinix Note 40' => 2499000,
                'iPhone 13 128GB' => 9999000, 'Samsung Galaxy Tab A9' => 2699000,
                'Xiaomi Pad 6' => 4999000, 'POCO X6 Pro' => 4699000,
            ],
            'Aksesoris Komputer' => [
                'Mouse Logitech M331 Silent' => 189000, 'Keyboard Logitech K380' => 399000,
                'Keychron K2 Wireless' => 1399000, 'Mousepad Rexus Gaming' => 75000,
                'Webcam Logitech C270' => 329000, 'USB-C Hub 7in1 Ugreen' => 349000,
                'Stand Laptop Aluminium' => 129000, 'Tas Laptop Targus 15.6 Inch' => 299000,
                'Cooling Pad Cooler Master' => 249000, 'Kabel HDMI 2m Baseus' => 89000,
            ],
            'Audio' => [
                'JBL Tune 510BT' => 399000, 'Sony WH-CH520' => 749000,
                'Xiaomi Redmi Buds 5' => 299000, 'Samsung Galaxy Buds FE' => 999000,
                'Rexus Daxa Gaming Headset' => 209000, 'Edifier W820NB' => 699000,
                'Anker Soundcore Life Q30' => 1199000, 'JBL Go 3 Speaker' => 499000,
                'Logitech Z120 Speaker' => 219000, 'Fantech HG20 Chroma' => 329000,
            ],
            'Penyimpanan' => [
                'SanDisk Ultra Flair 64GB' => 79000, 'Kingston DataTraveler 128GB' => 119000,
                'Samsung 980 SSD 500GB' => 749000, 'WD Blue SN580 1TB' => 1099000,
                'Crucial MX500 500GB' => 849000, 'WD Elements HDD 1TB' => 999000,
                'Seagate One Touch 2TB' => 1599000, 'SanDisk microSD 128GB' => 169000,
                'Samsung T7 Portable SSD 1TB' => 1799000, 'Lexar NM620 512GB' => 599000,
            ],
            'Jaringan' => [
                'TP-Link Archer C6' => 429000, 'TP-Link TL-WR840N' => 169000,
                'Tenda AC10' => 399000, 'Xiaomi Router AX3000' => 699000,
                'D-Link DIR-615' => 229000, 'TP-Link UE300 LAN Adapter' => 159000,
                'TP-Link TL-SG108 Switch' => 219000, 'Mercusys MW301R' => 119000,
                'ASUS RT-AX55' => 999000, 'TP-Link Deco M4 (2 Pack)' => 1299000,
            ],
        ];

        foreach ($catalog as $categoryName => $items) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );

            foreach ($items as $name => $price) {
                Product::factory()->create([
                    'category_id' => $category->id,
                    'name'        => $name,
                    'slug'        => Str::slug($name),
                    'price'       => $price,
                    'stock'       => rand(5, 60),
                    'is_active'   => true,
                ]);
            }
        }
    }
}
