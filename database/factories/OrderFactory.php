<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'shipping' => rand(0,1) == 0 ? 'NOSHIPPING' : 'SHIPPING',
            'invoice_address_title' => rtrim($this->faker->sentence(rand(1,3)), "."),
            'invoice_zip_code' => rand(1000,9999),
            'invoice_city' => $this->faker->city,
            'invoice_address' => $this->faker->streetAddress,
            'shipping_address_title' => rtrim($this->faker->sentence(rand(1,3)), "."),
            'shipping_zip_code' => rand(1000,9999),
            'shipping_city' => $this->faker->city,
            'shipping_address' => $this->faker->streetAddress,
            'total' => ceil(rand(9500,45000) / 10) * 10,
            'status' => rand(0,1) == 0 ? 'NEW' : 'COMPLETED',
        ];
    }
}
