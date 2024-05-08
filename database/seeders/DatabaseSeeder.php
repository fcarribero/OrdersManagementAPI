<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use Database\Factories\OrderFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        ApiKey::factory()->create();

        OrderFactory::times(100)->create();
    }
}
