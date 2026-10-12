<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 3 akun tetap untuk testing role (password semuanya: password)
        $fixed = [];
        foreach ([
            ['Admin Toko',  'admin@test.com',  'admin'],
            ['Editor Toko', 'editor@test.com', 'editor'],
            ['Budi User',   'user@test.com',   'user'],
        ] as [$name, $email, $role]) {
            $fixed[$role] = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $name,
                    'password' => Hash::make('password'),
                    'role'     => $role,
                ]
            );
        }

        // 10 user acak (role default: user)
        User::factory(10)->create();

        // 6 kategori x 10 = 60 produk
        $this->call(ProductSeeder::class);

        // Alamat + pesanan contoh untuk setiap user
        $products = Product::all();

        User::all()->each(function (User $user) use ($products) {
            $address = Address::create([
                'user_id'     => $user->id,
                'recipient'   => $user->name,
                'phone'       => fake()->numerify('0812########'),
                'street'      => fake()->streetAddress(),
                'city'        => 'Medan',
                'postal_code' => fake()->numerify('202##'),
            ]);

            foreach (range(1, rand(1, 2)) as $_) {
                $order = Order::create([
                    'user_id'    => $user->id,
                    'address_id' => $address->id,
                    'status'     => fake()->randomElement(['pending', 'paid', 'shipped', 'completed']),
                    'total'      => 0,
                ]);

                $total = 0;
                $products->random(rand(1, 3))->each(function (Product $p) use ($order, &$total) {
                    $qty = rand(1, 3);
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $p->id,
                        'quantity'   => $qty,
                        'price'      => $p->price,
                    ]);
                    $total += $p->price * $qty;
                });

                $order->update(['total' => $total]);
            }
        });

        Review::factory(80)->create();

        // Post milik editor, admin, dan campuran (untuk demo PostPolicy)
        Post::factory(3)->create(['user_id' => $fixed['editor']->id]);
        Post::factory(2)->create(['user_id' => $fixed['admin']->id]);
        Post::factory(3)->create();
    }
}
