<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([MerchantSeeder::class]);
        $this->call([PaymentMethodSeeder::class]);
    }
}
