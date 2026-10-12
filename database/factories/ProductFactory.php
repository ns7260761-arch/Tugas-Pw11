<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Nilai default saja. ProductSeeder menimpa name/price/category
 * dengan data produk yang realistis.
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = ucwords(fake()->unique()->words(3, true));

        return [
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'name'        => $name,
            'slug'        => Str::slug($name) . '-' . fake()->unique()->numerify('####'),
            'description' => fake()->randomElement([
                'Barang original dengan garansi resmi 1 tahun. Kondisi baru, segel.',
                'Stok terbatas. Pengiriman cepat dari Medan, packing aman dengan bubble wrap.',
                'Cocok untuk kebutuhan kuliah dan kerja harian. Bergaransi toko 7 hari.',
                'Produk best seller bulan ini. Include dus dan kartu garansi.',
            ]),
            'price'       => fake()->numberBetween(50, 5000) * 1000,
            'stock'       => fake()->numberBetween(0, 80),
            'is_active'   => fake()->boolean(92),
        ];
    }
}
