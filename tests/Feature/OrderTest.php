<?php

namespace Tests\Feature;

use App\Models\ApiKey;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class OrderTest extends TestCase {

    private $api_key;

    public function setUp(): void {
        parent::setUp();

        Artisan::call('migrate:fresh');

        Artisan::call('db:seed');

        $this->api_key = ApiKey::first()->key;
    }

    public function setDown(): void {
        Artisan::call('migrate:rollback');
    }

    public function test_list_endpoint(): void {


        $response = $this->get('/api/orders', [
            'X-API-Key' => $this->api_key,
        ]);

        $response->assertStatus(200);
    }

    public function test_get_single(): void {
        $order = Order::first();

        $response = $this->get('/api/orders/' . $order->uuid, [
            'X-API-Key' => $this->api_key,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'uuid',
            'status',
            'created_at',
            'updated_at',
            'deleted_at',
            'customer_detail',
            'invoice_detail',
            'shipping_address',
            'products',
        ]);
    }

    public function test_create_order(): void {

        $response = $this->post('/api/orders', $mock_order = json_decode('{
    "status": "cancelled",
    "customer_detail": {
        "external_id": null,
        "name": "Elna Bernhard",
        "email": "arne78@example.com",
        "phone": "+1-770-880-0459"
    },
    "invoice_detail": {
        "name": "Iva Bergstrom",
        "email": "jkerluke@example.com",
        "phone": "+13087752106",
        "tax_id": "55966748830"
    },
    "shipping_address": {
        "address": "805 Cleta Lodge\nLakintown, SD 31961",
        "apartment_number": "9693",
        "city": "Dewaynebury",
        "state": "North Natalie",
        "zip": "97348",
        "country": "Guadeloupe"
    },
    "products": [
        {
            "description": "Et rerum ullam doloremque.",
            "sku": "39666678",
            "quantity": 52.09,
            "price": 6.91,
            "discount": 20,
            "total": 339.94
        }
    ]
}', true), [
            'X-API-Key' => $this->api_key,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure(array_keys($mock_order));

    }

    public function test_delete_order(): void {
        $order = Order::first();

        $response = $this->delete('/api/orders/' . $order->uuid, [], [
            'X-API-Key' => $this->api_key,
        ]);

        $response->assertStatus(200);
    }

    public function test_wrong_api_key(): void {
        $response = $this->get('/api/orders', [
            'X-API-Key' => 'wrong-key',
        ]);

        $response->assertStatus(401);
    }
}
