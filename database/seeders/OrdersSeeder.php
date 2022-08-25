<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;


class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)->create()->each(function($p) {
        $p->orders()
            ->saveMany(
                Order::factory(rand(1,5))->make()
            );
        });
    }
}
