<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrdersShippingAddress>
 */
class OrdersShippingAddressFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'address' => $this->faker->address(),
            'apartment_number' => $this->faker->buildingNumber(),
            'city' => $this->faker->city(),
            'state' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'country' => $this->faker->country(),
        ];
    }
}
