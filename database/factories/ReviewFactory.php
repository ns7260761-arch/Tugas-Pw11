<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'    => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'product_id' => Product::query()->inRandomOrder()->value('id') ?? Product::factory(),
            'rating'     => fake()->numberBetween(3, 5),
            'comment'    => fake()->randomElement([
                'Barang sesuai deskripsi, pengiriman cepat. Recommended seller!',
                'Kualitas bagus untuk harganya. Packing rapi dan aman.',
                'Sudah dipakai seminggu, performa mantap. Terima kasih!',
                'Original dan bergaransi. Pasti beli lagi di sini.',
                'Pengiriman agak lama tapi barang oke, sesuai ekspektasi.',
                'Cocok buat kuliah. Worth it dengan harga segini.',
            ]),
        ];
    }
}
