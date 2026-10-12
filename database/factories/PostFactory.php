<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::query()->whereIn('role', ['admin', 'editor'])->inRandomOrder()->value('id')
                ?? User::factory(),
            'title'   => fake()->unique()->randomElement([
                'Tips Memilih Laptop untuk Mahasiswa',
                'Perbedaan SSD dan HDD: Mana yang Cocok?',
                'Cara Merawat Baterai Smartphone agar Awet',
                'Panduan Memilih Router WiFi untuk Rumah',
                'Rekomendasi Headset Murah di Bawah Rp500 Ribu',
                'Mengenal Garansi Resmi vs Garansi Distributor',
                'Checklist Sebelum Membeli Barang Elektronik Bekas',
                'Promo Akhir Bulan: Diskon Aksesoris Komputer',
                'Cara Backup Data Penting dengan Aman',
                'Keyboard Mechanical: Pilih Switch yang Mana?',
            ]),
            'body'    => implode("\n\n", fake()->paragraphs(3)),
        ];
    }
}
