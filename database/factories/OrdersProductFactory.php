<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrdersProduct>
 */
class OrdersProductFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'description' => $this->faker->sentence(),
            'sku' => $this->faker->randomNumber(8, true),
            'quantity' => $this->faker->randomFloat(2, 1, 100),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'discount' => $this->faker->randomElement([0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 10, 15, 20, 25, 30]),
        ];
    }
}
