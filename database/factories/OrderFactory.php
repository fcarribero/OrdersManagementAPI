<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrdersCustomerDetail;
use App\Models\OrdersInvoiceDetail;
use App\Models\OrdersProduct;
use App\Models\OrdersShippingAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
        ];
    }

    public function configure() {
        return $this->afterCreating(function (Order $order) {
            OrdersCustomerDetail::factory()->create([
                'order_id' => $order->id,
            ]);
            OrdersInvoiceDetail::factory()->create([
                'order_id' => $order->id,
            ]);
            OrdersShippingAddress::factory()->create([
                'order_id' => $order->id,
            ]);
            OrdersProduct::factory()->count(rand(1, 9))->create([
                'order_id' => $order->id,
            ]);
        });
    }
}
