<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Orders;
use App\Models\Phones;
use App\Models\User;
use Database\Factories\AdminFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = collect([
            [
                'email' => Str::random(10) . '@gmail.com',
                'password' => Str::random(16),
            ],
            [
                'email' => Str::random(10) . '@gmail.com',
                'password' => Str::random(16),
            ],
            [
                'email' => Str::random(10) . '@gmail.com',
                'password' => Str::random(16),
            ],
        ]);

        $phones = collect([
            [
                'model' => "IPhone 12",
                'price' => 150.20,
                'quantity' => 9,
            ],
            [
                'model' => 'LG 123',
                'price' => 40.00,
                'quantity' => 9,
            ],
            [
                'model' => 'Samsung 456',
                'price' => 120.25,
                'quantity' => 9,
            ]
        ]);

        $orders_collection = [];

        for ($i = 0; $i < 9; $i++) {
            $orders_collection[] = [
                'user_id' => rand(1, 3),
                'phone_id' => rand(1, 3),
                'amount' => rand(1, 5),
                'status' => 'pending',
            ];
        }

        $orders = collect($orders_collection);

        $users->map(function ($item) {
            User::factory(1)->create(
                $item
            );

            $item['owner'] = rand(0,1);
            Admin::factory(1)->create(
                $item
            );
        });

        $phones->map(function ($item) {
            Phones::factory(1)->create(
                $item
            );
        });

        $orders->map(function ($item) {
            $phone = Phones::find($item['phone_id']);

            $item['total_price'] = $item['amount'] * $phone->price;

            Orders::factory(1)->create($item);
        });
    }
}
